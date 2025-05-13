<?php

require __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$pdo = new \PDO(
    sprintf(
        'mysql:host=%s;dbname=%s;charset=utf8mb4',
        $_ENV['DB_HOST'],
        $_ENV['DB_NAME']
    ),
    $_ENV['DB_USER'],
    $_ENV['DB_PASSWORD'],
    [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
    ]
);

$sql = file_get_contents(__DIR__ . '/tables.sql');

try {
    $pdo->exec($sql);
    echo "Tabelas criadas ou já existentes.\n";
} catch (\PDOException $e) {
    echo "Erro ao criar tabelas: " . $e->getMessage() . "\n";
    exit(1);
}
