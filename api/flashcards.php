<?php
require_once '../db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['subject'])) {
            $stmt = $pdo->prepare("SELECT * FROM flashcards WHERE subject = ?");
            $stmt->execute([$_GET['subject']]);
        } else {
            $stmt = $pdo->query("SELECT * FROM flashcards");
        }
        echo json_encode($stmt->fetchAll());
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data['id'])) {
            $stmt = $pdo->prepare("UPDATE flashcards SET subject = ?, question = ?, answer = ? WHERE id = ?");
            $stmt->execute([$data['subject'], $data['question'], $data['answer'], $data['id']]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO flashcards (subject, question, answer) VALUES (?, ?, ?)");
            $stmt->execute([$data['subject'], $data['question'], $data['answer']]);
        }
        echo json_encode(['success' => true]);
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM flashcards WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        }
        break;
}
?>
