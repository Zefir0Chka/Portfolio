
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>О нас - Исторические события</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2B48C;
            --accent-color: #DEB887;
            --background-color: #FFF8DC;
            --text-color: #4A2C2A;
            --border-color: #CD853F;
            --card-bg: #FFF8DC;
            --hover-color: #CD853F;
            --shadow-color: rgba(139, 69, 19, 0.2);
            
            /* Добавляем новые цветовые переменные */
            --gradient-primary: linear-gradient(135deg, #8B4513, #CD853F);
            --gradient-secondary: linear-gradient(45deg, #D2B48C, #DEB887);
            --glass-bg: rgba(255, 248, 220, 0.8);
            --glass-border: rgba(255, 255, 255, 0.2);
            --neon-shadow: 0 0 15px rgba(222, 184, 135, 0.5);
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            background-image: 
                linear-gradient(135deg, rgba(139, 69, 19, 0.1) 0%, rgba(210, 180, 140, 0.1) 100%),
                url('https://images.unsplash.com/photo-1518636306295-1870b3b2d6b2?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-blend-mode: overlay;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: var(--gradient-primary) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            background: linear-gradient(to right, #FFF8DC, #DEB887);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            padding: 10px 0;
        }

        .nav-link {
            position: relative;
            padding: 10px 20px !important;
            margin: 0 5px;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--accent-color);
            transition: all 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .btn-custom, .btn-primary {
            background: var(--gradient-primary);
            border: none;
            border-radius: 30px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before, .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: all 0.5s ease;
        }

        .btn-custom:hover::before, .btn-primary:hover::before {
            left: 100%;
        }

        .card {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: var(--neon-shadow);
        }

        .team-member-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .about-section {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
        }
    </style>
</head>
<h5>Фильтры</h5>
<h5>Фильтры</h5>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Исторические события</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">События</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chronology.php">Хронология</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="map.php">Карта</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">О нас</a>
                    </li>
                </ul>
                <div class="d-flex">
                    <?php if ($isLoggedIn): ?>
                        <a href="profile.php" class="btn btn-custom me-2">
                            <i class="fas fa-user"></i> <?php echo htmlspecialchars($userData['username']); ?>
                        </a>
                        <a href="logout.php" class="btn btn-outline-light">
                            <i class="fas fa-sign-out-alt"></i> Выход
                        </a>
                    <?php else: ?>
                        <button class="btn btn-outline-light me-2" data-bs-toggle="modal" data-bs-target="#loginModal">
                            <i class="fas fa-sign-in-alt"></i> Войти
                        </button>
                        <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#registerModal">
                            <i class="fas fa-user-plus"></i> Регистрация
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <div class="container mt-4">
        <div class="about-section">
            <h1 class="text-center mb-4">О нашем проекте</h1>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <p class="lead text-center">
                        "Исторические события" - это образовательный проект, созданный для того, чтобы сделать изучение истории 
                        интересным и доступным для каждого.
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-map-marked-alt fa-3x mb-3"></i>
                        <h3>Интерактивная карта</h3>
                        <p>Исследуйте исторические события на интерактивной карте мира, чтобы лучше понять их географический контекст.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-clock fa-3x mb-3"></i>
                        <h3>Хронология</h3>
                        <p>Изучайте события в хронологическом порядке, чтобы понять их взаимосвязь и влияние на ход истории.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-search fa-3x mb-3"></i>
                        <h3>Удобный поиск</h3>
                        <p>Используйте различные фильтры для поиска интересующих вас исторических событийна ход истории.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-section mt-4">
            <h2 class="text-center mb-4">Наша миссия</h2>
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <p class="text-center">
                        Мы стремимся сделать изучение истории увлекательным и доступным для всех. Наша цель - помочь людям 
                        лучше понять взаимосвязь исторических событий и их влияние на современный мир.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Статистика -->
    <div class="container mt-5">
        <div class="row g-4">
            <div class="col-md-3">
                <div class="stat-item text-center">
                    <i class="fas fa-book-open fa-3x mb-3" style="color: var(--primary-color);"></i>
                    <h2 class="stat-number">1000+</h2>
                    <p class="stat-label">Исторических событий</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item text-center">
                    <i class="fas fa-users fa-3x mb-3" style="color: var(--primary-color);"></i>
                    <h2 class="stat-number">50K+</h2>
                    <p class="stat-label">Активных пользователей</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item text-center">
                    <i class="fas fa-globe fa-3x mb-3" style="color: var(--primary-color);"></i>
                    <h2 class="stat-number">100+</h2>
                    <p class="stat-label">Стран в базе</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-item text-center">
                    <i class="fas fa-clock fa-3x mb-3" style="color: var(--primary-color);"></i>
                    <h2 class="stat-number">2000+</h2>
                    <p class="stat-label">Лет истории</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Временная шкала -->
    <div class="container mt-5">
        <h2 class="text-center mb-5">История нашего проекта</h2>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-badge">
                    <i class="fas fa-flag"></i>
                </div>
                <div class="timeline-content">
                    <h4>2021</h4>
                    <p>Запуск проекта</p>
                    <p>Начало разработки платформы для изучения исторических событий</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-badge">
                    <i class="fas fa-users"></i>
                </div>
                <div class="timeline-content">
                    <h4>2022</h4>
                    <p>Рост сообщества</p>
                    <p>Достижение отметки в 10,000 активных пользователей</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-badge">
                    <i class="fas fa-award"></i>
                </div>
                <div class="timeline-content">
                    <h4>2023</h4>
                    <p>Признание</p>
                    <p>Получение награды "Лучший образовательный проект года"</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Команда -->
    <div class="container mt-5">
        <h2 class="text-center mb-5">Наша команда</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="team-card card">
                    <div class="card-body text-center">
                        <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="Team Member" class="team-member-img mb-3">
                        <h4>Александр Петров</h4>
                        <p class="text-muted">Основатель проекта</p>
                        <p>Историк, кандидат исторических наук</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card card">
                    <div class="card-body text-center">
                        <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Team Member" class="team-member-img mb-3">
                        <h4>Елена Иванова</h4>
                        <p class="text-muted">Главный редактор</p>
                        <p>Историк-исследователь, PhD</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="team-card card">
                    <div class="card-body text-center">
                        <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Team Member" class="team-member-img mb-3">
                        <h4>Михаил Сидоров</h4>
                        <p class="text-muted">Технический директор</p>
                        <p>Разработчик, архитектор проекта</p>
                        <div class="social-links mt-3">
                            <a href="#" class="social-link"><i class="fab fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Отзывы -->
    <div class="container mt-5">
        <h2 class="text-center mb-5">Что говорят наши пользователи</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="testimonial-card card">
                    <div class="card-body">
                        <div class="testimonial-text">
                            <i class="fas fa-quote-left fa-2x mb-3" style="color: var(--primary-color);"></i>
                            <p>Отличный ресурс для изучения истории. Интерактивная карта особенно полезна для понимания географического контекста событий.</p>
                        </div>
                        <div class="testimonial-author mt-3">
                            <h5>Анна К.</h5>
                            <p class="text-muted">Преподаватель истории</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card card">
                    <div class="card-body">
                        <div class="testimonial-text">
                            <i class="fas fa-quote-left fa-2x mb-3" style="color: var(--primary-color);"></i>
                            <p>Удобный интерфейс и богатая база данных. Использую для подготовки к экзаменам и просто для расширения кругозора.</p>
                        </div>
                        <div class="testimonial-author mt-3">
                            <h5>Дмитрий М.</h5>
                            <p class="text-muted">Студент</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="testimonial-card card">
                    <div class="card-body">
                        <div class="testimonial-text">
                            <i class="fas fa-quote-left fa-2x mb-3" style="color: var(--primary-color);"></i>
                            <p>Потрясающий проект! Особенно нравится возможность создавать собственные подборки событий и делиться ими.</p>
                        </div>
                        <div class="testimonial-author mt-3">
                            <h5>Мария В.</h5>
                            <p class="text-muted">Историк-любитель</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальные окна -->
    <!-- Модальное окно входа -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Вход в систему</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Войти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Модальное окно регистрации -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Регистрация</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm">
                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input type="text" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input type="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Подтверждение пароля</label>
                            <input type="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Стили для новых блоков */
        .stat-item {
            background: var(--glass-bg);
            padding: 2rem;
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-10px);
            box-shadow: var(--neon-shadow);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 1rem 0;
        }

        .timeline {
            position: relative;
            padding: 2rem 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            bottom: 0;
            width: 2px;
            background: var(--primary-color);
            transform: translateX(-50%);
        }

        .timeline-item {
            margin-bottom: 2rem;
            position: relative;
            width: 50%;
            padding: 0 2rem;
        }

        .timeline-item:nth-child(even) {
            margin-left: 50%;
        }

        .timeline-badge {
            width: 40px;
            height: 40px;
            background: var(--primary-color);
            border-radius: 50%;
            position: absolute;
            top: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }

        .timeline-item:nth-child(odd) .timeline-badge {
            right: -20px;
        }

        .timeline-item:nth-child(even) .timeline-badge {
            left: -20px;
        }

        .timeline-content {
            background: var(--glass-bg);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid var(--glass-border);
            transition: all 0.3s ease;
        }

        .timeline-content:hover {
            transform: translateY(-5px);
            box-shadow: var(--neon-shadow);
        }

        .team-card {
            height: 100%;
        }

        .social-links {
            display: flex;
            justify-content: center;
            gap: 1rem;
        }

        .social-link {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gradient-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .social-link:hover {
            transform: translateY(-3px);
            box-shadow: var(--neon-shadow);
            color: white;
        }

        .testimonial-card {
            height: 100%;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 1rem;
        }

        @media (max-width: 768px) {
            .timeline::before {
                left: 0;
            }

            .timeline-item {
                width: 100%;
                padding-left: 2rem;
                margin-left: 0 !important;
            }

            .timeline-badge {
                left: -20px !important;
            }
        }
    </style>

    <!-- Подвал -->
    <footer class="footer mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>О проекте</h5>
                    <p>Исторические события - это платформа для изучения и обсуждения важных исторических моментов.</p>
                </div>
                <div class="col-md-4">
                    <h5>Контакты</h5>
                    <p>Email: info@historical-events.ru</p>
                    <p>Телефон: +7 (123) 456-78-90</p>
                </div>
                <div class="col-md-4">
                    <h5>Социальные сети</h5>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-vk"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-telegram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 