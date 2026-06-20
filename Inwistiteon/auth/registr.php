<?php
// auth/registr.php
session_start();
require_once('../includes/db.php');

// Секция: Логирование ошибок
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

// Массив для хранения ошибок
$errors = [];

// Секция: Обработка формы регистрации
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $pass = trim($_POST['pass']);
    $repeatpass = trim($_POST['repeatpass']);
    $email = trim($_POST['email']);
    $secret_question = trim($_POST['secret_question']);
    $secret_answer = trim($_POST['secret_answer']);

    // Секция: Проверка на пустые поля
    if (empty($login) || empty($pass) || empty($repeatpass) || empty($email) || empty($secret_question) || empty($secret_answer)) {
        $errors[] = "Заполните все поля.";
        logError("Ошибка: Не все поля заполнены.");
    } else {
        // Секция: Проверка длины логина
        if (strlen($login) < 5 || strlen($login) > 20) {
            $errors[] = "Логин должен содержать от 5 до 20 символов.";
            logError("Ошибка: Логин не соответствует требованиям длины.");
        }
        // Секция: Проверка на латинские буквы и цифры в логине
        elseif (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
            $errors[] = "Логин должен содержать только латинские буквы и цифры.";
            logError("Ошибка: Логин содержит недопустимые символы.");
        }
        // Секция: Проверка корректности email
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Некорректный email.";
            logError("Ошибка: Некорректный email.");
        }
        // Секция: Проверка длины пароля
        elseif (strlen($pass) < 8 || strlen($pass) > 30) {
            $errors[] = "Пароль должен содержать от 8 до 30 символов.";
            logError("Ошибка: Пароль не соответствует требованиям длины.");
        }
        // Секция: Проверка сложности пароля
        elseif (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).+$/', $pass)) {
            $errors[] = "Пароль должен содержать хотя бы одну заглавную букву, одну строчную букву, одну цифру и один специальный символ.";
            logError("Ошибка: Пароль недостаточно сложный.");
        }
        // Секция: Проверка на повторяющиеся символы в пароле
        elseif (preg_match('/(.)\1{2,}/', $pass)) {
            $errors[] = "Пароль не должен содержать более двух одинаковых символов подряд.";
            logError("Ошибка: Пароль содержит повторяющиеся символы.");
        }
        // Секция: Проверка совпадения паролей
        elseif ($pass != $repeatpass) {
            $errors[] = "Пароли не совпадают.";
            logError("Ошибка: Пароли не совпадают.");
        } else {
            // Секция: Проверка существования пользователя
            $check_login_sql = "SELECT * FROM users WHERE login = ?";
            logError("Подготавливаемый запрос: " . $check_login_sql); // Логируем запрос
            $stmt = $conn->prepare($check_login_sql);

            if ($stmt === false) {
                logError("Ошибка подготовки запроса: " . $conn->error); // Логируем ошибку
                die("Ошибка подготовки запроса.");
            }

            $stmt->bind_param("s", $login);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $errors[] = "Пользователь с таким логином уже существует.";
                logError("Ошибка: Пользователь с логином $login уже существует.");
            } else {
                // Секция: Хеширование пароля и секретного ответа
                $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
                $hashed_secret_answer = password_hash($secret_answer, PASSWORD_DEFAULT);

                // SQL-запрос для добавления пользователя
                $insert_sql = "INSERT INTO users (login, pass, email, secret_question, secret_answer) VALUES (?, ?, ?, ?, ?)";
                logError("Подготавливаемый запрос: " . $insert_sql); // Логируем запрос
                $stmt = $conn->prepare($insert_sql);

                if ($stmt === false) {
                    logError("Ошибка подготовки запроса: " . $conn->error); // Логируем ошибку
                    die("Ошибка подготовки запроса.");
                }

                $stmt->bind_param("sssss", $login, $hashed_pass, $email, $secret_question, $hashed_secret_answer);

                if ($stmt->execute()) {
                    // Секция: Успешная регистрация
                    $_SESSION['user'] = $login;
                    header("Location: ../lk/welcome.php");
                    exit();
                } else {
                    $errors[] = "Ошибка при регистрации. Пожалуйста, попробуйте позже.";
                    logError("Ошибка базы данных: " . $stmt->error);
                }
            }
        }
    }
}

// Передаем массив ошибок в шаблон
require_once('../views/registr_form.php');
?>