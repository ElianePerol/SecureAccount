<?php
declare(strict_types=1);

namespace App;

class RegistrationService {
    public function __construct(
        private UserValidator $validator,
        private UserRepository $repository
    ) {}

    public function register(string $username, string $email, string $password, string $confirmPassword): array {
        // 1. Création de l'utilisateur *sans* ID ni sel
        $user = User::createNewUser($username, $email, $password);

        if (!$this->validator->validate($user, $confirmPassword)) {
            return [
                'success' => false,
                'errors' => $this->validator->getErrors()
            ];
        }

        if ($this->repository->findByEmail($email) !== null) {
            return [
                'success' => false,
                'errors' => ['Cette adresse e-mail est déjà utilisée']
            ];
        }

        try {
            // 2. Enregistrement de l'utilisateur et récupération de l'ID
            $userId = $this->repository->save($user);
    
            // 3. Récupération de l'utilisateur *complet* (avec ID et sel)
            $savedUser = $this->repository->findById($userId);
    
            if ($savedUser) {
                return [
                    'success' => true,
                    'message' => 'Inscription réussie'
                ];
            } else {
                return [
                    'success' => false,
                    'errors' => ['Erreur lors de l\'enregistrement de l\'utilisateur']
                ];
            }
    
        } catch (\RuntimeException $e) {
            return [
                'success' => false,
                'errors' => [$e->getMessage()]
            ];
        }
    }
}