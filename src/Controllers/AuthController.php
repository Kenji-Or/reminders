<?php
require_once __DIR__.'/../db.php';

class AuthController {
    private $pdo;

    public function __construct() {
        global $pdo; // Utilise la connexion PDO globale
        $this->pdo = $pdo;
    }

    public function loginUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ? AND password = ?');
        $stmt->execute([$data['email'], $data['password']]);
        $user = $stmt->fetch();

        if ($user) {
            echo json_encode(['message' => 'Login successful', 'user' => $user]);
        } else {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid credentials']);
        }
    }

    public function logoutUser() {
        // Pour une API RESTful, la déconnexion peut être gérée côté client
        echo json_encode(['message' => 'Logout successful']);
    }
}
