<?php
header('Content-Type: application/json');
session_start();
require_once '../db.php';

$data = json_decode(file_get_contents('php://input'), true);
$action = $data['action'] ?? '';

if ($action === 'signup') {
    $username = $data['username'] ?? '';
    $subject = $data['subject'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, subject, email, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $subject, $email, $password]);
        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['username'] = $username;
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo json_encode(['success' => false, 'message' => 'Username or Email already exists']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error']);
        }
    }
} elseif ($action === 'login') {
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
    $stmt->execute([$email, $password]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
    }
} elseif ($action === 'check') {
    if (isset($_SESSION['user_id'])) {
        echo json_encode(['success' => true, 'username' => $_SESSION['username']]);
    } else {
        echo json_encode(['success' => false]);
    }
} elseif ($action === 'logout') {
    session_destroy();
    echo json_encode(['success' => true]);
}
?>
