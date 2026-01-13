<?php

namespace App\Models;

use App\Utils\Database;
use App\Utils\Crypto;
use PDO;

class Secret
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getConnection();
    }

    public function getAllByUser(int $userId): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM secrets WHERE user_id = :user_id'
        );

        $stmt->execute([
            'user_id' => $userId
        ]);

        return $stmt->fetchAll();
    }

    public function create(
        int $userId,
        string $title,
        string $login,
        string $password
    ): bool {
        $encryptedPassword = Crypto::encrypt(
            $password,
            hex2bin(\APP_KEY)
        );

        $stmt = $this->pdo->prepare(
            'INSERT INTO secrets (user_id, title, login, encrypted_password)
             VALUES (:user_id, :title, :login, :encrypted_password)'
        );

        return $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'login' => $login,
            'encrypted_password' => $encryptedPassword
        ]);
    }
}
