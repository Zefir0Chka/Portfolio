<?php
session_start();

// Подключение к базе данных
require_once('db.php');

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_password($password) {
    return strlen($password) >= 8;
}

function validate_username($username) {
    return preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username);
}

// Обработка регистрации
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Получаем RAW POST данные
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        // Если данные не пришли как JSON, используем обычный POST
        if (json_last_error() !== JSON_ERROR_NONE) {
            $data = $_POST;
        }

        // Получаем и очищаем данные
        $username = trim($data['username'] ?? '');
        $password = $data['password'] ?? '';
        $confirm_password = $data['confirm_password'] ?? '';
        $email = trim($data['email'] ?? '');

        // Валидация данных
        if (empty($username) || empty($password) || empty($email) || empty($confirm_password)) {
            throw new Exception('Все поля обязательны для заполнения');
        }

        if (!validate_username($username)) {
            throw new Exception('Имя пользователя должно содержать 3-20 символов (буквы, цифры, подчеркивания)');
        }

        if (!validate_email($email)) {
            throw new Exception('Некорректный email адрес');
        }

        if (!validate_password($password)) {
            throw new Exception('Пароль должен содержать минимум 8 символов');
        }

        if ($password !== $confirm_password) {
            throw new Exception('Пароли не совпадают');
        }

        // Проверка существования пользователя перед регистрацией
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE login = ? OR email = ?");
        if (!$check_stmt) {
            throw new Exception('Ошибка подготовки запроса: ' . $conn->error);
        }

        $check_stmt->bind_param("ss", $username, $email);
        $check_stmt->execute();
        $check_stmt->store_result();

        if ($check_stmt->num_rows > 0) {
            throw new Exception('Пользователь с таким именем или email уже существует');
        }
        $check_stmt->close();

        // Хеширование пароля
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Подготовленный запрос
        $stmt = $conn->prepare("INSERT INTO users (login, email, password_hash) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception('Ошибка подготовки запроса: ' . $conn->error);
        }

        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Выполнение запроса
        if ($stmt->execute()) {
            // Сохраняем данные пользователя в сессии
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['logged_in'] = true;

            // Перенаправляем на страницу профиля
            header("Location: profile.php");
            exit();
        } else {
            throw new Exception('Ошибка при регистрации: ' . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        echo 'Ошибка: ' . $e->getMessage();
    }
} else {
    // Если пользователь уже авторизован, отображаем профиль
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        $username = htmlspecialchars($_SESSION['username']);
        $email = htmlspecialchars($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль</title>
</head>
<body>
    <h1>Привет, <?= $username ?>!</h1>
    <p>Email: <?= $email ?></p>
    <a href="logout.php">Выйти</a>
</body>
</html>
<?php
    } else {
        // Форма регистрации
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
    <h1>Регистрация</h1>
    <form method="POST" action="registr.php">
        <label for="username">Логин:</label>
        <input type="text" name="username" required><br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required><br><br>

        <label for="confirm_password">Подтвердите пароль:</label>
        <input type="password" name="confirm_password" required><br><br>

        <button type="submit">Зарегистрироваться</button>
    </form>
</body>
</html>
<?php
    }
}
?>