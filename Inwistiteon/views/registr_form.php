<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../css/registr.css">
    <link rel="stylesheet" href="../css/modal.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Регистрация</title>
</head>
<body>
    <div class="registr-container">
        <h2>Регистрация</h2>

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

        <form method="POST" action="registr.php">
            <!-- Поле для логина -->
            <input type="text" name="login" placeholder="Логин" required>

            <!-- Поле для пароля с кнопкой переключения видимости -->
            <div class="password-container">
                <input type="password" name="pass" id="register-pass" placeholder="Пароль" required>
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('register-pass', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <!-- Поле для подтверждения пароля с кнопкой переключения видимости -->
            <div class="password-container">
                <input type="password" name="repeatpass" id="register-repeatpass" placeholder="Повторите пароль" required>
                <button type="button" class="toggle-password" onclick="togglePasswordVisibility('register-repeatpass', this)">
                    <i class="fas fa-eye"></i>
                </button>
            </div>

            <!-- Поле для email -->
            <input type="email" name="email" placeholder="Email" required>

            <!-- Поле для выбора роли -->
            <label for="role">Выберите вашу роль:</label>
            <select name="role" id="role" required>
                <option value="founder">Founder</option>
                <option value="investor">Investor</option>
                <option value="developer">Developer</option>
                <option value="designer">Designer</option>
            </select>

            <!-- Поле для описания проекта -->
            <textarea name="project-description" placeholder="Опишите ваш проект или идею (максимум 200 символов)" maxlength="200"></textarea>

            <label for="secret_question">Секретный вопрос:</label>
            <select name="secret_question" id="secret_question" required>
                <option value="" disabled selected>Выберите секретный вопрос</option>
                <option value="1">Название вашего первого стартапа или проекта?</option>
                <option value="2">В каком году вы впервые инвестировали в акции?</option>
                <option value="3">Какой ваш любимый инвестиционный принцип или стратегия?</option>
                <option value="4">Название компании, которая вас вдохновляет в бизнесе?</option>
                <option value="5">Какой был ваш первый шаг в предпринимательстве?</option>
                <option value="6">В какой отрасли вы видите наибольший потенциал для инвестиций?</option>
                <option value="7">Какой ваш самый важный урок в управлении финансами?</option>
                <option value="8">Название книги по бизнесу, которая повлияла на вас больше всего?</option>
                <option value="9">Какой ваш самый амбициозный профессиональный план на ближайшие 5 лет?</option>
            <option value="10">Какой ваш любимый показатель успеха стартапа (например, ROI, CAC, LTV)?</option>
            </select>

            <!-- Поле для ответа на секретный вопрос -->
            <input type="text" name="secret_answer" placeholder="Ответ на секретный вопрос" required>

            <!-- Согласие на обработку персональных данных -->
            <div class="consent-container">
                <label class="custom-checkbox">
                    <input type="checkbox" name="consent" required>
                    <span class="checkmark"></span>
                    Я согласен(а) на обработку моих персональных данных в соответствии с 
                    <a href="#" id="privacy-link">Политикой конфиденциальности</a>
                </label>
            </div>

            <!-- Подписка на рассылку -->
            <div class="subscribe-container">
                <label class="custom-checkbox">
                    <input type="checkbox" name="subscribe">
                    <span class="checkmark"></span>
                    Подписаться на новости и обновления.
                </label>
            </div>

            <!-- Кнопка "Зарегистрироваться" -->
            <button type="submit">Зарегистрироваться</button>
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

        <!-- Ссылка на вход -->
        <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
    </div>

    <!-- Подключение модального окна -->
    <?php include '../views/privacy_modal.php'; ?>

    <!-- Подключение JavaScript -->
    <script src="../js/togglePassword.js"></script>
    <script src="../js/modal.js"></script>
</body>
</html>