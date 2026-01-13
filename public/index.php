<?php

require_once __DIR__ . '/../config/security.php';
require_once __DIR__ . '/../config/db.php';

require_once __DIR__ . '/../src/Utils/Database.php';
require_once __DIR__ . '/../src/Utils/Security.php';
require_once __DIR__ . '/../src/Utils/Crypto.php';

require_once __DIR__ . '/../src/Models/User.php';
require_once __DIR__ . '/../src/Models/Secret.php';

require_once __DIR__ . '/../src/Controllers/AuthController.php';
require_once __DIR__ . '/../src/Controllers/DashboardController.php';

use App\Controllers\AuthController;
use App\Controllers\DashboardController;

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

try {
    match (true) {
        str_ends_with($uri, '/register') => (new AuthController())->register(),
        str_ends_with($uri, '/login') => (new AuthController())->login(),
        str_ends_with($uri, '/dashboard') => (new DashboardController())->index(),
        default => throw new Exception('Page non trouvée'),
    };
} catch (Exception $e) {
    http_response_code(404);
    echo '404 - Page non trouvée';
}
