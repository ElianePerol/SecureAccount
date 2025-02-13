<?php
declare(strict_types=1);

namespace App;

use OTPHP\TOTP;
use OTPHP\SecretKey;
use ParagonIE\ConstantTime\Base32;
use RuntimeException;

class AuthenticationService {
    private UserRepository $repository;
    private const TOTP_WINDOW = 1; // Allow 30 seconds before/after
    private const SESSION_LIFETIME = 3600; // 1 hour

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function authenticate(string $usernameOrEmail, string $password, string $otp = null): array {
        $user = $this->repository->findByUsernameOrEmail($usernameOrEmail);


        if (!$user) {

            password_verify($password, '$2y$10$abcdefghijklmnopqrstuv');
            return [
                'success' => false,
                'errors' => ['Nom d\'utilisateur ou e-mail incorrect']
            ];
        }

        $salt = $user->getSalt();
        $saltedPassword = $password . $salt;

        if (!password_verify($saltedPassword, $user->getPassword())) {
            return [
                'success' => false,
                'errors' => ['Mot de passe incorrect']
            ];
        }

        if ($user->is2faEnabled()) {
            if (!$otp) {
                return [
                    'success' => false, 
                    'errors' => ['Code 2FA requis']
                ];
            }

            try {
                $totp = TOTP::create($user->get2faSecret());
                if (!$totp->verify($otp, null, self::TOTP_WINDOW)) {
                    return [
                        'success' => false, 
                        'errors' => ['Code 2FA incorrect']
                    ];
                }
            } catch (\Exception $e) {
                // Log the error securely
                error_log("2FA verification failed: " . $e->getMessage());
                return [
                    'success' => false, 
                    'errors' => ['Erreur de vérification 2FA']];
            }

            return $this->createSecureSession($user);
        }
    }

    private function createSecureSession(User $user): array {
        // Regenerate session ID to prevent session fixation
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_regenerate_id(true);

        // Set session variables
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['username'] = $user->getUsername();
        $_SESSION['email'] = $user->getEmail();
        $_SESSION['last_activity'] = time();

        // Set secure cookie parameters
        $params = session_get_cookie_params();
        setcookie(session_name(), session_id(), [
            'expires' => time() + self::SESSION_LIFETIME,
            'path' => $params['path'],
            'domain' => $params['domain'],
            'secure' => true,
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        return ['success' => true];
    }

    public function enable2fa(int $userId): string {
        try {
            // Generate a cryptographically secure random secret
            $secret = bin2hex(random_bytes(20));
            $base32Secret = Base32::encodeUpper($secret);
            
            // Create TOTP to validate the secret
            TOTP::create($base32Secret);
            
            $this->repository->set2faSecret($userId, $base32Secret);
            return $base32Secret;
        } catch (\Exception $e) {
            throw new RuntimeException('Échec de la génération du secret 2FA', 0, $e);
        }
    }

    public function disable2fa(int $userId): void {
        $this->repository->set2faSecret($userId, null);
    }
}
