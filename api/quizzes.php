<?php
require_once '../db.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['subject'])) {
            $stmt = $pdo->prepare("SELECT q.*, qu.question_text as question, qu.option1, qu.option2, qu.option3, qu.option4, qu.correct_answer 
                                   FROM quizzes q 
                                   LEFT JOIN questions qu ON q.id = qu.quiz_id 
                                   WHERE q.subject = ?");
            $stmt->execute([$_GET['subject']]);
            $rows = $stmt->fetchAll();
            
            // Format into the structure the frontend expects
            if (empty($rows)) {
                echo json_encode([]);
                exit;
            }
            
            $quiz = [
                'id' => $rows[0]['id'],
                'subject' => $rows[0]['subject'],
                'title' => $rows[0]['title'],
                'questions' => []
            ];
            
            foreach ($rows as $row) {
                if ($row['question']) {
                    $quiz['questions'][] = [
                        'question' => $row['question'],
                        'options' => [$row['option1'], $row['option2'], $row['option3'], $row['option4']],
                        'correctAnswer' => $row['correct_answer']
                    ];
                }
            }
            echo json_encode([$quiz]);
        } else {
            $stmt = $pdo->query("SELECT * FROM quizzes");
            echo json_encode($stmt->fetchAll());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $pdo->beginTransaction();
        try {
            if (isset($data['id']) && !empty($data['id'])) {
                // Update existing
                $stmt = $pdo->prepare("UPDATE quizzes SET subject = ?, title = ? WHERE id = ?");
                $stmt->execute([$data['subject'], $data['title'], $data['id']]);
                $quizId = $data['id'];
                // Delete old questions
                $pdo->prepare("DELETE FROM questions WHERE quiz_id = ?")->execute([$quizId]);
            } else {
                // Create new
                $stmt = $pdo->prepare("INSERT INTO quizzes (subject, title) VALUES (?, ?)");
                $stmt->execute([$data['subject'], $data['title']]);
                $quizId = $pdo->lastInsertId();
            }

            foreach ($data['questions'] as $q) {
                $stmt = $pdo->prepare("INSERT INTO questions (quiz_id, question_text, option1, option2, option3, option4, correct_answer) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $quizId, 
                    $q['question'], 
                    $q['options'][0], 
                    $q['options'][1], 
                    $q['options'][2], 
                    $q['options'][3], 
                    $q['correctAnswer']
                ]);
            }
            $pdo->commit();
            echo json_encode(['success' => true, 'id' => $quizId]);
        } catch (Exception $e) {
            $pdo->rollBack();
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        break;

    case 'DELETE':
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM quizzes WHERE id = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true]);
        }
        break;
}
?>
