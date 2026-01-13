<?php

namespace App\Controllers;

use App\Models\Secret;
use App\Utils\Security;

class DashboardController
{
    public function index()
    {
        if (!Security::isLogged()) {
            header('Location: /login');
            exit;
        }

        $secretModel = new Secret();
        $userId = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title'] ?? '');
            $login = trim($_POST['login'] ?? '');
            $password = trim($_POST['password'] ?? '');

            if ($title && $login && $password) {
                $secretModel->create(
                    $userId,
                    $title,
                    $login,
                    $password
                );

                header('Location: dashboard');
                exit;
            }
        }

        $secrets = $secretModel->getAllByUser($userId);

        require __DIR__ . '/../../templates/dashboard.php';
    }
}
