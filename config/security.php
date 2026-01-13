<?php
 
// 1. On cherche d'abord dans $_ENV (Laragon/Local via phpdotenv)
// 2. Sinon on cherche dans getenv() (Docker/Production)
$key = $_ENV['APP_KEY'] ?? getenv('APP_KEY');
 
if (!$key) {
    die("Erreur critique : La clé de sécurité APP_KEY_HEX est introuvable. Vérifiez votre fichier .env ou votre configuration Docker.");
}
 
define('APP_KEY', $key);
