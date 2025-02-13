<?php
declare(strict_types=1);

namespace App;

class User {
    private string $username;
    private string $email;
    private string $password;
    private ?int $id = null;
    private ?string $salt = null;
    private ?string $two_factor_secret;
    
    public function __construct(string $username, string $email, string $password, ?int $id = null, ?string $salt = null) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
        $this->salt = $salt;
    }

    public static function createNewUser(string $username, string $email, string $password): User {
        return new User($username, $email, $password, null, null);
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function getSalt(): string {
        return $this->salt;
    }

    public function is2faEnabled(): bool {
        return $this->salt !== null && $this->salt !== "";
    }

    public function get2faSecret(): ?string {
        return $this->two_factor_secret;
    }
}