<?php
// Подключение к базе данных
require_once '../includes/db.php';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/login.css">
    <title>Восстановление пароля</title>
</head>
<body>
    <div class="recovery-container">
        <h2>Восстановление пароля</h2>
        <form method="POST" action="../auth/recover.php"> <!-- Убедитесь, что путь правильный -->
            <!-- Поле для логина -->
            <input type="text" name="login" placeholder="Логин" required>

            <!-- Секретный вопрос -->
            <div id="secret-question-container">
                <!-- Секретный вопрос будет загружен через JavaScript -->
            </div>

            <!-- Поле для ответа -->
            <input type="text" name="secret_answer" placeholder="Ответ на секретный вопрос" required>

            <!-- Новый пароль с кнопкой переключения видимости -->
            <div class="password-container">
                <input type="password" name="new_pass" id="new-pass" placeholder="Новый пароль" required>
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('new-pass', this)">
                    <i class="fas fa-eye"></i> <!-- Иконка глаза -->
                </button>
            </div>

            <!-- Кнопка восстановления -->
            <button type="submit">Восстановить пароль</button>
        </form>

        <!-- Ссылка на вход -->
        <p>Вспомнили пароль? <a href="../auth/login.php">Войдите</a></p>
    </div>

    <script src="../js/togglePassword.js"></script>
</body>
</html>