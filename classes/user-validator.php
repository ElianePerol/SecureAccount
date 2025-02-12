<?php
declare(strict_types=1);

namespace App;;
 
class UserValidator {
    private array $errors = [];

    public function validate(User $user, string $confirmPassword): bool {
        $this->validateUsername($user->getUsername());
        $this->validateEmail($user->getEmail());
        $this->validatePassword($user->getPassword(), $confirmPassword);

        return empty($this->errors);
    }

    private function validateUsername(string $username): void {
        if (strlen($username) < 3) {
            $this->errors[] = "Le nom d'utilisateur doit contenir au moins 3 caractères";
        }
    }

    private function validateEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "L'adresse e-mail n'est pas valide";
        }
    }

    private function validatePassword(string $password, string $confirmPassword): void {
        $pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.@$!%*?&])[A-Za-z\d.@$!%*?&]{12,}$/";
        
        if (!preg_match($pattern, $password)) {
            $this->errors[] = "Le mot de passe doit contenir au moins 12 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial";
        }

        if ($password !== $confirmPassword) {
            $this->errors[] = "Les mots de passe ne correspondent pas";
        }
    }

    public function getErrors(): array {
        return $this->errors;
    }
}