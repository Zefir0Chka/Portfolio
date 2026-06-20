<?php
header('Content-Type: application/json');

// Подключение к базе данных
require_once '../includes/db.php';

$login = $_GET['login'];

// Запрос на получение секретного вопроса
$sql = "SELECT secret_question FROM users WHERE login = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->bind_result($secret_question);
$stmt->fetch();

if ($secret_question) {
    echo json_encode(['question' => $secret_question]);
} else {
    echo json_encode(['question' => null]);
}

$stmt->close();
$conn->close();
?>