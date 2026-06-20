<?php
// Включение отображения ошибок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Подключение к базе данных
require_once '../includes/db.php';

// Проверка данных из формы
if (!isset($_POST['login']) || !isset($_POST['secret_answer']) || !isset($_POST['new_pass'])) {
    die("Неверные данные формы.");
}

$login = $_POST['login'];
$secret_answer = $_POST['secret_answer'];
$new_pass = password_hash($_POST['new_pass'], PASSWORD_BCRYPT);

// Проверка ответа на секретный вопрос
$sql = "SELECT secret_answer FROM users WHERE login = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Ошибка подготовки запроса: " . $conn->error);
}

$stmt->bind_param("s", $login);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    die("Пользователь не найден.");
}

$stmt->bind_result($hashed_answer);
$stmt->fetch();

if (password_verify($secret_answer, $hashed_answer)) {
    // Обновление пароля
    $sql = "UPDATE users SET pass = ? WHERE login = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Ошибка подготовки запроса: " . $conn->error);
    }

    $stmt->bind_param("ss", $new_pass, $login);
    $stmt->execute();

    error_log("Пользователь $login пытается восстановить пароль.");

    ob_start(); // Начало буферизации
    // Перенаправление на страницу входа (абсолютный путь)
    header("Location: /auth/login.php");
    exit();
} else {
    echo "Неверный ответ на секретный вопрос.";
}

$stmt->close();
$conn->close();
?>