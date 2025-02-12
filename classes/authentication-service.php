<?php
declare(strict_types=1);

namespace App;

class AuthenticationService {
    private UserRepository $repository;

    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function authenticate(string $usernameOrEmail, string $password): array {
        $user = $this->repository->findByUsernameOrEmail($usernameOrEmail);


        if (!$user) {
            return [
                'success' => false,
                'errors' => ['Nom d\'utilisateur ou e-mail incorrect']
            ];
        }

        if (!password_verify($password, $user->getPassword())) {
            return [
                'success' => false,
                'errors' => ['Mot de passe incorrect']
            ];
        }

        session_start();
        $_SESSION["user_id"] = $user->getId();
        $_SESSION["username"] = $user->getUsername();
        $_SESSION["email"] = $user->getEmail();
        
        return ['success' => true];
    }
}
