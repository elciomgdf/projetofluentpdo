<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . "/../");
$dotenv->load();

// Permite requisições de qualquer origem (para dev)
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; img-src 'self' data:;");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

// Se for um OPTIONS, só responde e encerra
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

use App\Core\Router;
use App\Services\Service;

(new Service())->checkDatabase();

$uri = explode('/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/'));

if ($uri[0] !== 'api') {
    $handler = new \App\Core\SessionHandler();
    session_set_save_handler($handler, true);
    session_start();
}

require_once __DIR__ . '/../app/Helpers/functions.php';

require_once __DIR__ . '/../routes/routes.php';

if (!empty($routes)) {
    $router = new Router();
    $router->dispatch($routes);
}

http_response_code(404);
echo json_encode(['error' => 'Rota não encontrada']);
