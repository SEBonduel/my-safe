<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class User
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function findByEmail(string $email)
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        return $stmt->fetch();
    }

   public function create(string $email, string $passwordHash): bool
{
    $stmt = $this->pdo->prepare(
        'INSERT INTO users (email, password_hash) VALUES (:email, :password_hash)'
    );

    return $stmt->execute([
        'email' => $email,
        'password_hash' => $passwordHash
    ]);
}

}
