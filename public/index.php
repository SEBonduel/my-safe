<?php

session_set_cookie_params([
    'httponly' => true,
    'samesite' => 'Strict',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
]);
session_start();

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Models/Secret.php';
require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/VaultController.php';

$uri = $_SERVER['REQUEST_URI'];

if ($uri === '/login' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controllers\AuthController($db);
    $result = $controller->login($_POST['email'], $_POST['password']);
    if (isset($result['error'])) {
        $error = $result['error'];
        include '../templates/login.php';
    } else {
        header('Location: /dashboard');
        exit;
    }
} 
elseif ($uri === '/register' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    include '../templates/register.php';
}elseif ($uri === '/register' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controllers\AuthController($db);
    $result = $controller->register($_POST['email'], $_POST['password']);
    if (isset($result['error'])) {
        $error = $result['error'];
        include '../templates/register.php';
    } else {
        header('Location: /login');
        exit;
    }
} elseif ($uri === '/dashboard') {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit;
    }
    $controller = new Controllers\VaultController($db);
    $secrets = $controller->getSecrets($_SESSION['user_id']);
    include '../templates/dashboard.php';
} elseif ($uri === '/add-secret' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controllers\VaultController($db);
    $controller->addSecret($_SESSION['user_id'], $_POST['title'], $_POST['login'], $_POST['password']);
    header('Location: /dashboard');
    exit;
} elseif ($uri === '/delete-secret' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controllers\VaultController($db);
    $controller->deleteSecret($_POST['id'], $_SESSION['user_id']);
    header('Location: /dashboard');
    exit;
} elseif ($uri === '/logout.php') {
    include '../public/logout.php';
}
elseif ($uri === '/login' && $_SERVER['REQUEST_METHOD'] === 'GET') {
    include '../templates/login.php';
} else {
    include '../templates/login.php';
}


echo "<h1>Mon Coffre-Fort Sécurisé</h1>";
echo "<p>Base de données connectée.</p>";


?>