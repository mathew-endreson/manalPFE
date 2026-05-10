<?php
require_once '../db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        $stmt = $pdo->query("SELECT * FROM resources");
        echo json_encode($stmt->fetchAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'])) {
            $stmt = $pdo->prepare("UPDATE resources SET subject = ?, title = ?, type = ?, url = ? WHERE id = ?");
            $stmt->execute([$data['subject'], $data['title'], $data['type'], $data['url'], $data['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO resources (subject, title, type, url) VALUES (?, ?, ?, ?)");
            $stmt->execute([$data['subject'], $data['title'], $data['type'], $data['url']]);
        }
        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM resources WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        }
        break;
}
?>
