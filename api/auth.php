<?php
header('Content-Type: application/json');
session_start();

require_once '../db.php';
$data = json_decode(file_get_contents('php://input'), true);
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM admins WHERE username = 'admin' AND password = ?");
$stmt->execute([$password]);
$admin = $stmt->fetch();

if ($admin) {
    $_SESSION['admin_logged_in'] = true;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Incorrect password']);
}
?>
