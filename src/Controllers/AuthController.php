<?php
namespace App\Controllers;

class AuthController {
    private $pdo;

    public function __construct() {
        $this->pdo = getDB(); // Utilise la fonction getDB() lazy loading
    }

    public function loginUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['email']) || !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }

        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$data['email']]);
        $user = $stmt->fetch();

        if ($user && password_verify($data['password'], $user['password'])) {
            echo json_encode(['message' => 'Login success', 'user_id' => $user['id']]);
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
