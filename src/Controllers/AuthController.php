<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\PasswordValidator;
use App\Utils\Security;

class AuthController
{
    public function register()
    {
        
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';

        if (!hash_equals(Security::getCsrfToken(), $token)) {
                die('Erreur de sécurité : Jeton CSRF invalide !');
            }

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';

            if (!$email || empty($password)) {
                $error = 'Veuillez remplir tous les champs.';
            } elseif (!PasswordValidator::validate($password)) {
                $error = 'Mot de passe trop faible.';
            } else {
                $userModel = new User();
                if ($userModel->findByEmail($email)) {
                    $error = 'Cet email est déjà utilisé.';
                } else {
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    if ($userModel->create($email, $hash)) {
                        $success = 'Compte créé avec succès !';
                    } else {
                        $error = 'Erreur lors de la création du compte.';
                    }
                }
            }
        }

        require_once __DIR__ . '/../../templates/register.php';
    }

    public function login()
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($email) || empty($password)) {
                $errors[] = 'Tous les champs sont obligatoires';
            } else {
                $userModel = new User();
                $user = $userModel->findByEmail($email);

                if (!$user || !password_verify($password, $user['password_hash'])) {
                    $errors[] = 'Email ou mot de passe incorrect';
                } else {
                    Security::login($user['id']);
                    header('Location: /dashboard');
                    exit();
                }
            }
        }

        require __DIR__ . '/../../templates/login.php';
    }
}
