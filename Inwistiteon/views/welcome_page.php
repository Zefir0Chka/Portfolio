<?php
// views/welcome_page.php
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать, <?php echo htmlspecialchars($login); ?></title>
    <link rel="stylesheet" href="../css/welcome.css">
    <!-- Подключение Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    
    <!-- Header -->
    <header>
        <nav>
            <!-- Logo -->
            <div class="logo">Stratosphere Investments</div>

            <!-- Premium Navigation Links -->
            <ul class="nav-links">
                <li>
                    <a href="#profile">
                        <i class="fas fa-user-circle"></i> <!-- Иконка профиля -->
                        <span>Профиль и аналитика</span>
                        <small>Доверено Microsoft, Google и Tesla</small>
                    </a>
                </li>
                <li>
                    <a href="#settings">
                        <i class="fas fa-cog"></i> <!-- Иконка настроек -->
                        <span>Расширенные настройки</span>
                        <small>Предпочитают Apple, Amazon и SpaceX</small>
                    </a>
                </li>
                <li>
                    <a href="../auth/logout.php">
                        <i class="fas fa-sign-out-alt"></i> <!-- Иконка выхода -->
                        <span>Выйти</span>
                        <small>Защищено IBM, Oracle и Salesforce</small>
                    </a>
                </li>
            </ul>

            <!-- Hamburger Menu for Mobile -->
            <div class="hamburger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <!-- Modernized Main Content -->
    <main>
        <!-- Premium Welcome Section -->
        <section class="welcome-section">
            <div class="welcome-container">
                <div class="welcome-header">
                    <i class="fas fa-handshake"></i> <!-- Иконка приветствия -->
                    <h1>Добро пожаловать, <span class="highlight"><?php echo htmlspecialchars($login); ?></span>!</h1>
                    <p class="subtext">Мы рады видеть вас здесь. Ваш успех поддерживается мировыми лидерами.</p>
                </div>
                <div class="user-info">
                    <div class="info-item">
                        <i class="fas fa-envelope"></i> <!-- Иконка email -->
                        <p>Ваш Email: <span class="highlight"><?php echo htmlspecialchars($email); ?></span></p>
                    </div>
                    <div class="info-item">
                        <i class="fas fa-globe"></i> <!-- Иконка глобуса -->
                        <p>Ваш успех — наш приоритет. Достигнем величия вместе.</p>
                    </div>
                </div>
                <div class="cta-buttons">
                    <a href="#profile" class="cta-button">Профиль</a>
                    <a href="#settings" class="cta-button">Настройки</a>
                </div>
            </div>
        </section>

        <!-- Modernized Dashboard Widgets -->
        <section class="widgets">
            <div class="widget">
                <div class="widget-icon">
                    <i class="fas fa-history"></i> <!-- Иконка последней активности -->
                </div>
                <h2>Последняя активность</h2>
                <p>Активность не обнаружена.</p>
                <a href="#activity" class="widget-link">Посмотреть журнал</a>
            </div>
            <div class="widget">
                <div class="widget-icon">
                    <i class="fas fa-bell"></i> <!-- Иконка уведомлений -->
                </div>
                <h2>Уведомления</h2>
                <p>Новых уведомлений нет.</p>
                <a href="#notifications" class="widget-link">Управление уведомлениями</a>
            </div>
            <div class="widget">
                <div class="widget-icon">
                    <i class="fas fa-check-circle"></i> <!-- Иконка статуса аккаунта -->
                </div>
                <h2>Статус аккаунта</h2>
                <p>Ваш аккаунт активен и в хорошем состоянии.</p>
                <a href="#account" class="widget-link">Детали аккаунта</a>
            </div>
        </section>

        <!-- Секция Analytics -->
        <section class="analytics">
            <div class="analytics-header">
                <h2>Аналитика</h2>
                <p>Отслеживайте и анализируйте свои показатели.</p>
            </div>
            <div class="analytics-content">
                <!-- График 1: Обзор активности -->
                <div class="analytics-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3>Обзор активности</h3>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="activityChart"></canvas>
                    </div>
                    <div class="card-footer">
                        <p>Отслеживайте ежедневные показатели активности.</p>
                        <small>Последнее обновление: <span class="last-updated">2023-10-05</span></small>
                    </div>
                </div>

                <!-- График 2: Использование функций -->
                <div class="analytics-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-chart-bar"></i>
                        </div>
                        <h3>Использование функций</h3>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="usageChart"></canvas>
                    </div>
                    <div class="card-footer">
                        <p>Анализируйте использование инструментов.</p>
                        <small>Охват данных: <span class="coverage">98.7%</span></small>
                    </div>
                </div>

                <!-- График 3: Распределение задач -->
                <div class="analytics-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-chart-pie"></i>
                        </div>
                        <h3>Распределение задач</h3>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="taskDistributionChart"></canvas>
                    </div>
                    <div class="card-footer">
                        <p>Визуализация распределения задач по командам.</p>
                        <small>Последнее обновление: <span class="last-updated">2023-10-05</span></small>
                    </div>
                </div>

                <!-- График 4: Тренды доходов -->
                <div class="analytics-card">
                    <div class="card-header">
                        <div class="card-icon">
                            <i class="fas fa-chart-area"></i>
                        </div>
                        <h3>Тренды доходов</h3>
                    </div>
                    <div class="chart-wrapper">
                        <canvas id="revenueTrendsChart"></canvas>
                    </div>
                    <div class="card-footer">
                        <p>Отслеживайте тренды доходов.</p>
                        <small>Охват данных: <span class="coverage">95.5%</span></small>
                    </div>
                </div>
            </div>
        </section>

        <!-- Секция отзывов -->
        <section class="testimonials">
            <div class="container">
                <h2>Что говорят наши клиенты</h2>
                <p class="subheading">Доверено лидерами индустрии по всему миру</p>
                <div class="testimonial-cards">
                    <div class="testimonial-card">
                        <p>"Эта платформа изменила способ управления нашими процессами. Эффективность выросла в разы, а команда стала более продуктивной. Незаменимый инструмент для любой современной компании."</p>
                        <span>- Иван Иванов, CTO в TechGlobal Inc.</span>
                    </div>
                    <div class="testimonial-card">
                        <p>"Мы пробовали множество решений, но ни одно не сравнится с этой платформой. Интеграция и удобство использования на высшем уровне."</p>
                        <span>- Анна Петрова, CEO в InnovateCorp</span>
                    </div>
                    <div class="testimonial-card">
                        <p>"Уровень кастомизации и поддержки исключительный. Наши глобальные команды теперь работают слаженнее, чем когда-либо."</p>
                        <span>- Михаил Сидоров, COO в GlobalSolutions</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Секция преимуществ -->
        <section class="features">
            <div class="container">
                <h2>Почему выбирают нас?</h2>
                <p class="subheading">Мы предоставляем передовые решения для бизнеса по всему миру</p>
                <div class="feature-list">
                    <div class="feature-item">
                        <div class="icon-wrapper">
                            <i class="icon fas fa-shield-alt"></i>
                        </div>
                        <h3>Продвинутая безопасность</h3>
                        <p>Ваши данные защищены с использованием современных протоколов шифрования, соответствующих мировым стандартам, таким как GDPR и ISO 27001.</p>
                    </div>
                    <div class="feature-item">
                        <div class="icon-wrapper">
                            <i class="icon fas fa-headset"></i>
                        </div>
                        <h3>Поддержка 24/7</h3>
                        <p>Наша команда поддержки доступна круглосуточно, чтобы обеспечить бесперебойную работу вашего бизнеса.</p>
                    </div>
                    <div class="feature-item">
                        <div class="icon-wrapper">
                            <i class="icon fas fa-cogs"></i>
                        </div>
                        <h3>Полная кастомизация</h3>
                        <p>Настройте платформу под свои нужды с помощью персонализированных дашбордов, отчетов и интеграций.</p>
                    </div>
                    <div class="feature-item">
                        <div class="icon-wrapper">
                            <i class="icon fas fa-plug"></i>
                        </div>
                        <h3>Интеграции</h3>
                        <p>Легко подключайтесь к более чем 100+ инструментам, включая Slack, Salesforce и Microsoft Teams.</p>
                    </div>
                </div>
                <div class="cta">
                    <p>Присоединяйтесь к тысячам компаний, которые уже используют нашу платформу.</p>
                    <a href="#" class="cta-button">Начать сейчас</a>
                </div>
            </div>
        </section>

        <!-- Секция сравнения функций -->
        <section class="usage-table-section">
            <div class="container">
                <h2>Сравнение функций</h2>
                <p class="subheading">Выберите план, который подходит вашему бизнесу</p>
                <table class="usage-table">
                    <thead>
                        <tr>
                            <th>Функция</th>
                            <th>Базовый план</th>
                            <th>Премиум план</th>
                            <th>Корпоративный план</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Функция 1 -->
                        <tr>
                            <td>
                                <strong>Основные функции</strong>
                                <p>Доступ к базовым инструментам, таким как управление задачами и отчеты.</p>
                            </td>
                            <td>✔</td>
                            <td>✔</td>
                            <td>✔</td>
                        </tr>
                        <!-- Функция 2 -->
                        <tr>
                            <td>
                                <strong>Продвинутая аналитика</strong>
                                <p>Искусственный интеллект, прогнозная аналитика и кастомные дашборды.</p>
                            </td>
                            <td>❌</td>
                            <td>✔</td>
                            <td>✔</td>
                        </tr>
                        <!-- Функция 3 -->
                        <tr>
                            <td>
                                <strong>Приоритетная поддержка 24/7</strong>
                                <p>Доступ к выделенному менеджеру и мгновенной помощи.</p>
                            </td>
                            <td>❌</td>
                            <td>✔</td>
                            <td>✔</td>
                        </tr>
                        <!-- Функция 4 -->
                        <tr>
                            <td>
                                <strong>Интеграции</strong>
                                <p>API и интеграции с более чем 100+ инструментами.</p>
                            </td>
                            <td>❌</td>
                            <td>Ограничено</td>
                            <td>✔</td>
                        </tr>
                        <!-- Функция 5 -->
                        <tr>
                            <td>
                                <strong>Коллаборация</strong>
                                <p>Неограниченное количество пользователей и совместная работа.</p>
                            </td>
                            <td>До 5 пользователей</td>
                            <td>До 50 пользователей</td>
                            <td>Неограниченно</td>
                        </tr>
                        <!-- Функция 6 -->
                        <tr>
                            <td>
                                <strong>Безопасность</strong>
                                <p>Соответствие GDPR и шифрование данных.</p>
                            </td>
                            <td>Базовый</td>
                            <td>Продвинутый</td>
                            <td>Полный</td>
                        </tr>
                        <!-- Функция 7 -->
                        <tr>
                            <td>
                                <strong>Кастомизация</strong>
                                <p>Брендирование и поддержка доменов.</p>
                            </td>
                            <td>❌</td>
                            <td>❌</td>
                            <td>✔</td>
                        </tr>
                    </tbody>
                </table>
                <div class="cta">
                    <p>Остались вопросы? Свяжитесь с нашей командой.</p>
                    <a href="#" class="cta-button">Связаться с продажами</a>
                </div>
            </div>
        </section>

        <!-- Секция премиум-функций -->
        <section class="premium-unlock-section">
            <div class="container">
                <div class="premium-content">
                    <h2>Откройте премиум-функции</h2>
                    <p class="subheading">Перейдите на премиум и получите доступ к эксклюзивным инструментам.</p>
                    <ul class="premium-features">
                        <li><i class="fas fa-check-circle"></i> Продвинутая аналитика и AI-инсайты</li>
                        <li><i class="fas fa-check-circle"></i> Приоритетная поддержка 24/7</li>
                        <li><i class="fas fa-check-circle"></i> Интеграции с 100+ инструментами</li>
                        <li><i class="fas fa-check-circle"></i> Улучшенная безопасность</li>
                        <li><i class="fas fa-check-circle"></i> Брендирование и кастомизация</li>
                    </ul>
                    <a href="premium.html" class="cta-button">Перейти на премиум</a>
                    <p class="small-text">Начните 14-дневный бесплатный пробный период. Без кредитной карты.</p>
                </div>
            </div>
        </section>

        <!-- Секция FAQ -->
        <section class="faq">
            <div class="container">
                <div class="faq-header">
                    <h2>Часто задаваемые вопросы</h2>
                    <p class="subheading">Узнайте, как наша платформа помогает компаниям по всему миру.</p>
                </div>
                <div class="faq-items">
                    <!-- Вопрос 1 -->
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Как система шифрования обеспечивает безопасность данных?</span>
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Мы используем современное шифрование AES-256, которое соответствует мировым стандартам безопасности. Это обеспечивает защиту ваших данных от несанкционированного доступа.</p>
                        </div>
                    </div>
                    <!-- Вопрос 2 -->
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Какие преимущества у кастомизации интерфейса?</span>
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Кастомизация позволяет адаптировать платформу под ваши бизнес-процессы, повышая эффективность работы.</p>
                        </div>
                    </div>
                    <!-- Вопрос 3 -->
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Соответствует ли платформа мировым стандартам?</span>
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Да, наша платформа соответствует GDPR, CCPA и другим международным стандартам.</p>
                        </div>
                    </div>
                    <!-- Вопрос 4 -->
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Какая поддержка доступна для корпоративных клиентов?</span>
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Мы предоставляем 24/7 поддержку с выделенным менеджером и приоритетным обслуживанием.</p>
                        </div>
                    </div>
                    <!-- Вопрос 5 -->
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Можно ли интегрировать платформу с другими инструментами?</span>
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Да, мы поддерживаем интеграцию с более чем 100+ инструментами, включая Slack и Salesforce.</p>
                        </div>
                    </div>
                    <!-- Вопрос 6 -->
                    <div class="faq-item">
                        <button class="faq-question">
                            <span>Почему платформа подходит для глобальных компаний?</span>
                            <span class="faq-icon">+</span>
                        </button>
                        <div class="faq-answer">
                            <p>Мы предлагаем многоязычную поддержку, мультивалютность и соответствие региональным стандартам.</p>
                        </div>
                    </div>
                </div>
                <div class="cta">
                    <p>Остались вопросы? Наша команда готова помочь.</p>
                    <a href="#" class="cta-button">Связаться с поддержкой</a>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer>
            <div class="footer-content">
                <div class="container">
                    <!-- Logo and Description -->
                    <div class="footer-box footer-logo">
                        <div class="logo">MyApp</div>
                        <p class="description">Мы предоставляем передовые решения для бизнеса.</p>
                        <div class="social-links">
                            <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                            <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div class="footer-box footer-links">
                        <h4>Быстрые ссылки</h4>
                        <ul>
                            <li><a href="#">Главная</a></li>
                            <li><a href="#">Функции</a></li>
                            <li><a href="#">Цены</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Контакты</a></li>
                        </ul>
                    </div>

                    <!-- Resources -->
                    <div class="footer-box footer-links">
                        <h4>Ресурсы</h4>
                        <ul>
                            <li><a href="#">Документация</a></li>
                            <li><a href="#">Кейсы</a></li>
                            <li><a href="#">Вебинары</a></li>
                            <li><a href="#">Блог</a></li>
                            <li><a href="#">API</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div class="footer-box footer-contact">
                        <h4>Контакты</h4>
                        <ul>
                            <li><i class="fas fa-map-marker-alt"></i> 123 Улица, Москва, Россия</li>
                            <li><i class="fas fa-phone"></i> +7 (800) 123-45-67</li>
                            <li><i class="fas fa-envelope"></i> support@myapp.com</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="container">
                    <p>&copy; 2023 Stratosphere Investments. Все права защищены.</p>
                    <ul class="legal-links">
                        <li><a href="#">Политика конфиденциальности</a></li>
                        <li><a href="#">Условия использования</a></li>
                        <li><a href="#">Политика cookies</a></li>
                    </ul>
                </div>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="../js/welcome.js"></script> <!-- Корневой путь к JS -->
    </body>
</html>