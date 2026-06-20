<?php
session_start();

// Проверяем, авторизован ли пользователь
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: process_register.php"); // Перенаправляем на страницу регистрации
    exit();
}

// Получаем данные пользователя из сессии
$username = htmlspecialchars($_SESSION['username']);
$email = htmlspecialchars($_SESSION['email']);
$registration_date = htmlspecialchars($_SESSION['created_at'] ?? 'Неизвестно');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет - Исторические события</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #8B4513;
            --secondary-color: #D2B48C;
            --accent-color: #DEB887;
            --background-color: #FFF8DC;
            --text-color: #4A2C2A;
            --border-color: #CD853F;
            --hover-color: #A0522D;
        }
        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand, .nav-link {
            color: var(--background-color) !important;
        }
        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            padding: 40px 0;
            margin-bottom: 30px;
            color: white;
            border-radius: 0 0 20px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .profile-avatar {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 5px solid white;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .profile-avatar:hover {
            transform: scale(1.05);
        }
        .profile-stats {
            background: white;
            border-radius: 15px;
            padding: 20px;
            margin: 20px 0;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        .profile-stats:hover {
            transform: translateY(-5px);
        }
        .stat-item {
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            background: linear-gradient(45deg, var(--background-color), white);
            transition: all 0.3s ease;
        }
        .stat-item:hover {
            background: linear-gradient(45deg, var(--secondary-color), var(--background-color));
            transform: translateY(-3px);
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 5px;
        }
        .stat-label {
            color: var(--text-color);
            font-size: 14px;
        }
        .profile-section {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .section-title {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--accent-color);
        }
        .activity-item {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            background: var(--background-color);
            transition: all 0.3s ease;
        }
        .activity-item:hover {
            transform: translateX(10px);
            background: linear-gradient(45deg, var(--background-color), white);
        }
        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        .badge-custom {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            margin-right: 10px;
        }
        .btn-custom {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            background: var(--hover-color);
            transform: translateY(-2px);
            color: white;
        }
        .settings-item {
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            background: var(--background-color);
            transition: all 0.3s ease;
        }
        .settings-item:hover {
            background: linear-gradient(45deg, var(--background-color), white);
        }
        .form-control {
            border-radius: 10px;
            border: 2px solid var(--border-color);
            padding: 10px 15px;
        }
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <!-- Навигационная панель -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Исторические события</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Главная</a>
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
                </ul>
                <div class="d-flex align-items-center">
                    <a href="profile.php" class="btn btn-custom me-2">
                        <i class="fas fa-user"></i> Профиль
                    </a>
                    <a href="logout.php" class="btn btn-outline-light">
                        <i class="fas fa-sign-out-alt"></i> Выход
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Шапка профиля -->
    <div class="profile-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-3 text-center">
                    <img src="https://via.placeholder.com/150" alt="Аватар пользователя" class="profile-avatar mb-3">
                    <button class="btn btn-custom btn-sm" onclick="document.getElementById('avatarUpload').click()">
                        <i class="fas fa-camera"></i> Изменить фото
                    </button>
                    <input type="file" id="avatarUpload" style="display: none">
                </div>
                <div class="col-md-9">
                    <h2><?= $username ?></h2>
                    <p class="mb-2"><i class="fas fa-envelope me-2"></i> <?= $email ?></p>
                    <p class="mb-3"><i class="fas fa-clock me-2"></i> На сайте с <?= $registration_date ?></p>
                    <div class="d-flex flex-wrap gap-2">
                        <span class="badge-custom"><i class="fas fa-star me-1"></i> Продвинутый пользователь</span>
                        <span class="badge-custom"><i class="fas fa-trophy me-1"></i> 5 достижений</span>
                        <span class="badge-custom"><i class="fas fa-book me-1"></i> 15 изученных событий</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Основной контент -->
    <div class="container">
        <div class="row">
            <!-- Статистика -->
            <div class="col-md-12">
                <div class="profile-stats">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">150</div>
                                <div class="stat-label">Изученных событий</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">45</div>
                                <div class="stat-label">Комментариев</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">12</div>
                                <div class="stat-label">Достижений</div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="stat-item">
                                <div class="stat-number">89%</div>
                                <div class="stat-label">Успешность в тестах</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Левая колонка -->
            <div class="col-md-8">
                <!-- Последняя активность -->
                <div class="profile-section animate-fade-in">
                    <h3 class="section-title">Последняя активность</h3>
                    <div class="activity-item d-flex align-items-center">
                        <div class="activity-icon">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Изучено событие "Куликовская битва"</h5>
                            <small class="text-muted">2 часа назад</small>
                        </div>
                    </div>
                    <div class="activity-item d-flex align-items-center">
                        <div class="activity-icon">
                            <i class="fas fa-comment"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Оставлен комментарий к событию "Основание Москвы"</h5>
                            <small class="text-muted">5 часов назад</small>
                        </div>
                    </div>
                    <div class="activity-item d-flex align-items-center">
                        <div class="activity-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">Получено достижение "Знаток древней истории"</h5>
                            <small class="text-muted">1 день назад</small>
                        </div>
                    </div>
                </div>
                <!-- Достижения -->
                <div class="profile-section animate-fade-in">
                    <h3 class="section-title">Достижения</h3>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="activity-item text-center">
                                <i class="fas fa-medal fa-2x mb-2" style="color: var(--primary-color)"></i>
                                <h5>Историк-новичок</h5>
                                <small>Изучено 10 событий</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="activity-item text-center">
                                <i class="fas fa-crown fa-2x mb-2" style="color: var(--primary-color)"></i>
                                <h5>Знаток древности</h5>
                                <small>100 правильных ответов</small>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="activity-item text-center">
                                <i class="fas fa-star fa-2x mb-2" style="color: var(--primary-color)"></i>
                                <h5>Активный участник</h5>
                                <small>30 дней на сайте</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Правая колонка -->
            <div class="col-md-4">
                <!-- Настройки профиля -->
                <div class="profile-section animate-fade-in">
                    <h3 class="section-title">Настройки профиля</h3>
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Имя пользователя</label>
                            <input type="text" class="form-control" value="<?= $username ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" value="<?= $email ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">О себе</label>
                            <textarea class="form-control" rows="3">Увлекаюсь историей древнего мира и средневековья.</textarea>
                        </div>
                        <button type="submit" class="btn btn-custom w-100">Сохранить изменения</button>
                    </form>
                </div>
                <!-- Уведомления -->
                <div class="profile-section animate-fade-in">
                    <h3 class="section-title">Уведомления</h3>
                    <div class="settings-item d-flex align-items-center justify-content-between">
                        <div>Email-уведомления</div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>
                    <div class="settings-item d-flex align-items-center justify-content-between">
                        <div>Новости сайта</div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>
                    <div class="settings-item d-flex align-items-center justify-content-between">
                        <div>Уведомления о достижениях</div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" checked>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Анимация появления элементов
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.animate-fade-in');
            elements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, index * 200);
            });
        });
        // Обработка загрузки аватара
        document.getElementById('avatarUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-avatar').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
        // Анимация статистики
        function animateNumbers() {
            document.querySelectorAll('.stat-number').forEach(element => {
                const target = parseInt(element.textContent);
                let current = 0;
                const increment = target / 50;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        element.textContent = target;
                        clearInterval(timer);
                    } else {
                        element.textContent = Math.floor(current);
                    }
                }, 20);
            });
        }
        // Запуск анимации при появлении элемента в поле зрения
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumbers();
                    observer.unobserve(entry.target);
                }
            });
        });
        document.querySelector('.profile-stats').forEach(element => {
            observer.observe(element);
        });
    </script>
</body>
</html>