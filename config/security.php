<?php
// Si la variable existe dans l'environnement (Docker), on la prend.
// Sinon, on garde une valeur de secours (pour le dev local sans Docker).
$key = getenv('APP_KEY_HEX');
if ($key === false) {
 // Fallback ou erreur explicite
 die("Erreur critique : La clé de sécurité APP_KEY_HEX est introuvable.");
}
define('APP_KEY', getenv('APP_KEY_HEX') ?: '');
