<?php
declare(strict_types=1);

namespace App;

class RegistrationService {
    public function __construct(
        private UserValidator $validator,
        private UserRepository $repository
    ) {}

    public function register(string $username, string $email, string $password, string $confirmPassword): array {
        $user = new User($username, $email, $password);
        
        // Validation
        if (!$this->validator->validate($user, $confirmPassword)) {
            return [
                'success' => false,
                'errors' => $this->validator->getErrors()
            ];
        }

        // Vérification de l'existence de l'email
        if ($this->repository->findByEmail($email) !== null) {
            return [
                'success' => false,
                'errors' => ['Cette adresse e-mail est déjà utilisée']
            ];
        }

        try {
            $this->repository->save($user);
            return [
                'success' => true,
                'message' => 'Inscription réussie'
            ];
        } catch (\RuntimeException $e) {
            return [
                'success' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}