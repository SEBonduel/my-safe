<?php
// filepath: src/Controllers/AuthController.php

namespace Controllers;

use Models\User;

class AuthController
{
    private $userModel;

    public function __construct($db)
    {
        $this->userModel = new User($db);
    }

    public function register($email, $password)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['error' => 'Email invalide.'];
        }
        if ($this->userModel->findByEmail($email)) {
            return ['error' => 'Email déjà utilisé.'];
        }
        $this->userModel->create($email, $password);
        return ['success' => true];
    }

    public function login($email, $password)
    {
        $user = $this->userModel->findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            return ['error' => 'Identifiants invalides.'];
        }
        // Démarrer la session ici
        $_SESSION['user_id'] = $user['id'];
        return ['success' => true];
    }
}