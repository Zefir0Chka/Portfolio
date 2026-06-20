<?php
// auth/login.php

session_start();
require_once('../includes/db.php');

// Функция для логирования ошибок
function logError($message) {
    $logDir = '../logs';
    $logFile = $logDir . '/error.log';

    // Проверяем, существует ли папка logs
    if (!is_dir($logDir)) {
        // Создаём папку, если её нет
        mkdir($logDir, 0755, true);
    }

    // Логируем ошибку
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[$timestamp] $message\n";
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}

// Функция для защиты от brute-force атак
function delay() {
    sleep(2); // Задержка 2 секунды
}

// Функция для отправки email
function sendEmailNotification($email, $message) {
    $to = $email;
    $subject = "Неудачная попытка входа";
    $headers = "From: no-reply@yoursite.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    mail($to, $subject, $message, $headers);
}

// Массив для хранения ошибок
$errors = [];

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);

    // Проверка на пустые поля
    if (empty($login) || empty($pass)) {
        $errors[] = "Заполните все поля.";
        logError("Ошибка: Не все поля заполнены.");
    } else {
        // Проверка длины логина (от 5 до 20 символов)
        if (strlen($login) < 5 || strlen($login) > 20) {
            $errors[] = "Логин должен содержать от 5 до 20 символов.";
            logError("Ошибка: Логин не соответствует требованиям длины.");
        }
        // Проверка на латинские буквы и цифры в логине
        elseif (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
            $errors[] = "Логин должен содержать только латинские буквы и цифры.";
            logError("Ошибка: Логин содержит недопустимые символы.");
        }
        // Проверка длины пароля (от 8 до 30 символов)
        elseif (strlen($pass) < 8 || strlen($pass) > 30) {
            $errors[] = "Пароль должен содержать от 8 до 30 символов.";
            logError("Ошибка: Пароль не соответствует требованиям длины.");
        } else {
            // Защита от brute-force атак
            delay();

            // Проверка, существует ли пользователь с таким логином
            $sql = "SELECT * FROM users WHERE login = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();

                // Проверка пароля
                if (password_verify($pass, $row['pass'])) {
                    // Сохраняем ID пользователя и логин в сессии
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['user'] = $row['login'];

                    // Перенаправляем на страницу welcome.php
                    header("Location: ../lk/welcome.php");
                    exit();
                } else {
                    $errors[] = "Неверный пароль.";
                    logError("Ошибка: Неверный пароль для пользователя $login.");
                }
            } else {
                $errors[] = "Нет такого пользователя.";
                logError("Ошибка: Пользователь с логином $login не найден.");
            }
        }
    }
}

// Подключаем HTML-форму
require_once('../views/login_form.php');
?>