<?php

namespace Models;

use PDO;

class User
{
    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($email, $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Email invalide
            return false;
        }
        $hash = password_hash($password, PASSWORD_ARGON2ID);
        $stmt = $this->db->prepare('INSERT INTO users (email, password) VALUES (:email, :password)');
        return $stmt->execute(['email' => $email, 'password' => $hash]);
    }
}
