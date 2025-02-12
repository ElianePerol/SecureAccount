<?php
declare(strict_types=1);

namespace App;

class UserRepository {
    private \PDO $pdo;

    public function __construct(DatabaseConnection $db) {
        $this->pdo = $db->getConnection();
    }

    public function save(User $user): int {
        try {

            $salt = bin2hex(random_bytes(32));
            $saltedPassword = $user->getPassword() . $salt;

            $hashedPassword = password_hash($saltedPassword, PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare(
                "INSERT INTO users (username, email, password, salt) VALUES (:username, :email, :password, :salt)"
            );

            $stmt->execute([
                ':username' => $user->getUsername(),
                ':email' => $user->getEmail(),
                ':password' => $hashedPassword,
                ':salt' => $salt
            ]);

            return (int)$this->pdo->lastInsertId();
        } catch (\PDOException $e) {
            throw new \RuntimeException("Erreur lors de l'enregistrement de l'utilisateur: " . $e->getMessage());
        }
    }

    public function findByEmail(string $email): ?User {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if (!$result) {
                return null;
            }

             // Récupérer le sel pour l'utilisateur
             $salt = $result['salt'];

            return new User(
                $result['username'],
                $result['email'],
                $result['password'],
                (int)$result['id'],
                $salt
            );
        } catch (\PDOException $e) {
            throw new \RuntimeException("Erreur lors de la recherche de l'utilisateur: " . $e->getMessage());
        }
    }

    public function findByUsernameOrEmail(string $usernameOrEmail): ?User {
        try {
            $stmt = $this->pdo->prepare(
                "SELECT * FROM users WHERE username = :username OR email = :email");
    
            $stmt->execute([':username' => $usernameOrEmail, ':email' => $usernameOrEmail]);
    
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    
            if (!$result) {
                return null;
            }
    
            $salt = $result['salt'];
    
            return new User(
                $result['username'],
                $result['email'],
                $result['password'],
                (int)$result['id'],
                $salt
            );
        } catch (\PDOException $e) {
            throw new \RuntimeException("Erreur lors de la recherche de l'utilisateur: " . $e->getMessage());
        }
    }
    
}