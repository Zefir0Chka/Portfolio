<?php
session_start();

// Подключение к базе данных через db.php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Проверка подключения к базе данных
    if (!$conn) {
        die("Ошибка подключения к базе данных.");
    }

    try {
        // Поиск пользователя по email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if (!$stmt) {
            die("Ошибка подготовки запроса: " . $conn->error);
        }

        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            // Успешный вход
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['logged_in'] = true;

            // Перенаправляем на profile.php
            header("Location: profile.php");
            exit();
        } else {
            // Неверные учетные данные
            echo "Неверный email или пароль.";
        }
    } catch (Exception $e) {
        echo "Ошибка: " . $e->getMessage();
    }

    $stmt->close();
} else {
    // Если метод запроса не POST, отображаем форму входа
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход</title>
</head>
<body>
    <h2>Вход</h2>
    <form method="POST" action="process_login.php">
        <label for="email">Email:</label>
        <input type="email" name="email" required><br><br>

        <label for="password">Пароль:</label>
        <input type="password" name="password" required><br><br>

        <button type="submit">Войти</button>
    </form>
</body>
</html>
<?php
}
$conn->close();
?>