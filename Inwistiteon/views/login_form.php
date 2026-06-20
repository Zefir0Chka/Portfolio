<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"> <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/login.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Вход</title>
</head>
<body>
    <div class="login-container">
        <h2>Вход</h2>

        <!-- Блок для вывода ошибок -->
        <?php if (!empty($errors)): ?>
            <div class="error-box">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <!-- Поле для логина -->
            <input type="text" name="login" placeholder="Логин" required>

            <!-- Поле для пароля с кнопкой переключения видимости -->
            <div class="password-container">
                <input type="password" name="pass" id="login-pass" placeholder="Пароль" required>
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('login-pass', this)">
                    <i class="fas fa-eye"></i> <!-- Иконка глаза -->
                </button>
            </div>

            <!-- Кнопка "Войти" -->
            <button type="submit">Войти</button>

            <!-- Кнопка "Забыли пароль?" -->
            <a href="../views/forgot-password.php" style="display: block; margin-top: 10px; text-align: center;">Забыли пароль?</a>
        </form>

        <!-- Дополнительные способы входа -->
        <div class="social-login">
            <p>Или войдите через:</p>
            <div class="social-buttons">
                <!-- Кнопка входа через Telegram -->
                <button class="social-btn telegram-btn" onclick="window.location.href='https://web.telegram.org/'">
                    <i class="fab fa-telegram-plane"></i> Telegram
                </button>

                <!-- Кнопка входа через Google -->
                <button class="social-btn google-btn" onclick="window.location.href='https://workspace.google.com/intl/ru/gmail/'">
                    <i class="fab fa-google"></i> Google
                </button>

                <!-- Кнопка входа через Facebook -->
                <button class="social-btn facebook-btn" onclick="window.location.href='https://www.facebook.com/'">
                    <i class="fab fa-facebook-f"></i> Facebook
                </button>
            </div>
        </div>

        <!-- Ссылка на регистрацию -->
        <p>Нет аккаунта? <a href="registr.php">Зарегистрируйтесь</a></p>
    </div>

    <!-- Подключение JavaScript -->
    <script src="../js/togglePassword.js"></script>
</body>
</html>