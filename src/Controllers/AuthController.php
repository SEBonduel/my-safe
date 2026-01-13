<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\PasswordValidator;

class AuthController
{
    public function register()
    {
        $error = null;
        $success = null;
        // Si le formulaire est soumis (POST)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // --- DÉBUT VERIF CSRF ---
            $token = $_POST['csrf_token'] ?? '';

            if ($token !== Security::getCsrfToken()) {
                // Arrêt immédiat du script avec un message d'erreur
                die('Erreur de sécurité : Jeton CSRF invalide !');
            }
            // --- FIN VERIF CSRF ---

            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            // 1. On vérifie d'abord si les champs sont remplis
            if (!$email || empty($password)) {
                $error = 'Veuillez remplir tous les champs.';
            }

            // 2. On utilise notre validateur TDD pour la force du mot de passe
            elseif (!PasswordValidator::validate($password)) {
                $error = "Le mot de passe est trop faible (min 8 caractères et
                1 chiffre).";
            } else {
                $userModel = new User();
                // 3. Le reste de la logique reste identique (Vérif email + Hash + Création)
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
        // Chargement de la Vue (en passant les variables $error et $success)
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
                    \App\Utils\Security::login($user['id']);
                    header('Location: /dashboard');
                    exit();
                }
            }
        }

        require __DIR__ . '/../../templates/login.php';
    }
}
