<?php

require_once __DIR__ . '/src/Utils/Crypto.php';

$secret = 'Mot de passe';

$encrypted = Crypto::encrypt($secret, 'APP_KEY');
$decrypted = Crypto::decrypt($encrypted, 'APP_KEY');

echo 'crypté ';
var_dump($encrypted);

echo 'décrypté ';
var_dump($decrypted);

echo 'secret ';
var_dump($secret);