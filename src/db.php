<?php
/**
 * Gestion de la connexion à la base de données avec lazy loading
 */

class Database {
    private static $instance = null;
    private $pdo = null;
    private $config;

    private function __construct() {
        $this->config = [
            'host' => getenv('DB_HOST') ?: 'localhost',
            'db'   => getenv('MYSQL_DATABASE') ?: 'reminders',
            'user' => getenv('MYSQL_USER') ?: 'user',
            'pass' => getenv('MYSQL_PASSWORD') ?: 'userpass',
            'charset' => 'utf8mb4'
        ];
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        if ($this->pdo === null) {
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['db']};charset={$this->config['charset']}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                $this->pdo = new PDO($dsn, $this->config['user'], $this->config['pass'], $options);
            } catch (\PDOException $e) {
                throw new \PDOException("Erreur de connexion à la base de données: " . $e->getMessage(), (int)$e->getCode());
            }
        }

        return $this->pdo;
    }
}

/**
 * Fonction helper pour obtenir la connexion PDO
 */
function getDB() {
    return Database::getInstance()->getConnection();
}
