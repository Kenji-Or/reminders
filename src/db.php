<?php
// Charger les variables d'environnement
$host = getenv('DB_HOST') ?: 'db';
$db   = getenv('MYSQL_DATABASE') ?: 'reminders';
$user = getenv('MYSQL_USER') ?: 'user';
$pass = getenv('MYSQL_PASSWORD') ?: 'userpass';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
