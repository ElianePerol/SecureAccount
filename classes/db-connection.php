<?php
declare(strict_types=1);

namespace App;

class DatabaseConnection {
    private static ?DatabaseConnection $instance = null;
    private \PDO $connection;
    
    // Constantes de configuration
    private const HOST = 'localhost';
    private const DB_NAME = 'secure-account';
    private const USERNAME = 'admin-welcome-training';
    private const PASSWORD = 'BeepBoop.0.0';
    private const CHARSET = 'utf8mb4';

    // Constructeur privé pour empêcher l'instanciation directe
    private function __construct() {
        try {
            $dsn = sprintf(
                "mysql:host=%s;dbname=%s;charset=%s",
                self::HOST,
                self::DB_NAME,
                self::CHARSET
            );

            $options = [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => false,
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];

            $this->connection = new \PDO($dsn, self::USERNAME, self::PASSWORD, $options);
        } catch (\PDOException $e) {
            throw new \RuntimeException(
                "Erreur de connexion à la base de données : " . $e->getMessage()
            );
        }
    }

    // Méthode pour obtenir l'instance unique
    public static function getInstance(): self {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Obtenir la connexion PDO
    public function getConnection(): \PDO {
        return $this->connection;
    }

    // Empêcher le clonage
    private function __clone() {}

    // Empêcher la désérialisation
    public function __wakeup() {
        throw new \RuntimeException("Cannot unserialize singleton");
    }

    // Méthode utilitaire pour préparer et exécuter une requête
    public function prepare(string $sql): \PDOStatement {
        return $this->connection->prepare($sql);
    }

    // Méthode utilitaire pour les requêtes simples
    public function query(string $sql): \PDOStatement {
        return $this->connection->query($sql);
    }

    // Méthode pour vérifier la connexion
    public function testConnection(): bool {
        try {
            $this->connection->query('SELECT 1');
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }
}