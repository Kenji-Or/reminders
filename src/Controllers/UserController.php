<?php
namespace App\Controllers;

use PDOException;

class UserController {
    private $pdo;

    public function __construct() {
        global $pdo; // Utilise la connexion PDO globale
        $this->pdo = $pdo;
    }

    public function getAllUsers() {
        $stmt = $this->pdo->query('SELECT * FROM users');
        $users = $stmt->fetchAll();
        echo json_encode($users);
    }

    public function getUserById($id) {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        $user = $stmt->fetch();
        if ($user) {
            echo json_encode($user);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'User not found']);
        }
    }

    public function createUser() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['email']) && !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }
        $password = password_hash($data['password'], PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare('INSERT INTO users (email, password) VALUES (?, ?)');
        try {
            $stmt->execute([$data['email'], $password]);
            http_response_code(201);
            echo json_encode(['message' => 'User created', 'id' => $this->pdo->lastInsertId()]);
        } catch (PDOException $e) {
            http_response_code(400);
            echo json_encode(['error' => 'User already exists']);
        }
    }

    public function updateUser($id) {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['email']) && !isset($data['password'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
            return;
        }
        $stmt = $this->pdo->prepare('UPDATE users SET email = ?, password = ? WHERE id = ?');
        $stmt->execute([$data['email'], $data['password'], $id]);
        echo json_encode(['message' => 'User updated']);
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare('DELETE FROM users WHERE id = ?');
        $stmt->execute([$id]);
        echo json_encode(['message' => 'User deleted']);
    }
}