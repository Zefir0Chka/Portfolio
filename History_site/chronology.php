
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Хронология исторических событий</title>
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
                url('https://images.unsplash.com/photo-1519751138087-5bf79df62d5b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');
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
            color: var(--background-color) !important;
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

        .page-header {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            margin: 40px 0;
            border: 1px solid var(--glass-border);
            box-shadow: var(--neon-shadow);
        }

        .page-title {
            color: var(--primary-color);
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
            position: relative;
        }

        .page-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: var(--gradient-primary);
            border-radius: 2px;
        }

        .page-description {
            color: var(--text-color);
            text-align: center;
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
            opacity: 0.9;
        }

        /* Обновляем стили кнопок */
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

        .navbar-brand, .nav-link {
            color: var(--background-color) !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }

        .card {
            background-color: var(--secondary-color);
            border-color: var(--border-color);
        }

        .modal-content {
            background-color: var(--background-color);
            border-color: var(--border-color);
        }

        .form-control {
            background-color: var(--background-color);
            border-color: var(--border-color);
            color: var(--text-color);
        }

        .form-control:focus {
            background-color: var(--background-color);
            border-color: var(--primary-color);
            color: var(--text-color);
        }

        .alert {
            background-color: var(--secondary-color);
            border-color: var(--border-color);
            color: var(--text-color);
        }

        .timeline-container {
            background-color: var(--secondary-color);
            border-radius: 15px;
            padding: 20px;
            margin-top: 20px;
            box-shadow: 0 0 15px rgba(139, 69, 19, 0.2);
        }

        .timeline-item {
            background-color: var(--background-color);
            border-color: var(--border-color);
            color: var(--text-color);
            margin-bottom: 20px;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(139, 69, 19, 0.1);
        }

        .timeline-date {
            background-color: var(--primary-color);
            color: var(--background-color);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 10px;
        }

        .timeline-title {
            color: var(--primary-color);
            font-weight: bold;
            margin-bottom: 10px;
        }

        .timeline-description {
            color: var(--text-color);
            margin-bottom: 10px;
        }

        .timeline-image {
            border-radius: 10px;
            border: 2px solid var(--border-color);
            margin-top: 10px;
        }

        .filters-section {
            background-color: var(--secondary-color);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 15px rgba(139, 69, 19, 0.2);
        }

        .filter-group {
            margin-bottom: 15px;
        }

        .filter-group label {
            color: var(--text-color);
            font-weight: 600;
        }

        .filter-group select {
            background-color: var(--background-color);
            border-color: var(--border-color);
            color: var(--text-color);
        }

        .filter-group select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
        }

        /* Основные стили временной шкалы */
        .timeline {
            position: relative;
            padding: 20px 0;
        }
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, var(--primary-color), var(--secondary-color));
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .timeline-item {
            position: relative;
            margin-bottom: 50px;
            width: 100%;
            opacity: 1;
            transform: translateY(0);
            transition: all 0.6s ease;
        }
        .timeline-item.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .timeline-item:nth-child(odd) {
            padding-right: 50%;
        }
        .timeline-item:nth-child(even) {
            padding-left: 50%;
        }
        .timeline-content {
            position: relative;
            padding: 25px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            margin: 20px 0;
        }
        .timeline-content:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        }
        .timeline-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-radius: 15px;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }
        .timeline-content:hover::before {
            opacity: 0.1;
        }
        .timeline-date {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            font-weight: bold;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }
        .timeline-content:hover .timeline-date {
            transform: translateX(-50%) scale(1.1);
        }
        .timeline-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: transform 0.3s ease;
        }
        .timeline-content:hover .timeline-image {
            transform: scale(1.05);
        }
        .timeline-badge {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 25px;
            height: 25px;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 0 0 4px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        .timeline-content:hover .timeline-badge {
            transform: translateX(-50%) scale(1.2);
            box-shadow: 0 0 0 6px rgba(0,0,0,0.2);
        }
        .timeline-item:nth-child(odd) .timeline-badge {
            right: -12px;
            left: auto;
        }
        .timeline-item:nth-child(even) .timeline-badge {
            left: -12px;
        }
        .timeline-item:nth-child(odd) .timeline-date {
            right: -25px;
            left: auto;
        }
        .timeline-item:nth-child(even) .timeline-date {
            left: -25px;
        }
        .timeline-content h3 {
            color: var(--primary-color);
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }
        .timeline-content:hover h3 {
            color: var(--secondary-color);
        }
        .timeline-content p {
            color: #666;
            line-height: 1.6;
        }
        .badge {
            padding: 8px 15px;
            font-size: 0.9rem;
            border-radius: 20px;
            transition: all 0.3s ease;
            margin-right: 10px;
        }
        .badge:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .badge.bg-primary {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color)) !important;
        }
        .badge.bg-secondary {
            background: linear-gradient(45deg, var(--secondary-color), var(--primary-color)) !important;
        }

        /* Фильтры и поиск */
        .filters-section {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        .search-box {
            position: relative;
            margin-bottom: 20px;
        }
        .search-box input {
            padding-left: 40px;
            border-radius: 25px;
            border: 2px solid #eee;
            transition: all 0.3s ease;
        }
        .search-box input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #666;
        }
        .filter-group {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }
        .filter-group select {
            flex: 1;
            min-width: 200px;
            border-radius: 25px;
            border: 2px solid #eee;
            padding: 8px 20px;
            transition: all 0.3s ease;
        }
        .filter-group select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .timeline::before {
                left: 30px;
            }
            .timeline-item:nth-child(odd),
            .timeline-item:nth-child(even) {
                padding-left: 80px;
                padding-right: 0;
            }
            .timeline-item:nth-child(odd) .timeline-date,
            .timeline-item:nth-child(even) .timeline-date {
                left: 0;
                right: auto;
            }
            .timeline-item:nth-child(odd) .timeline-badge,
            .timeline-item:nth-child(even) .timeline-badge {
                left: 20px;
                right: auto;
            }
            .filter-group {
                flex-direction: column;
            }
            .filter-group select {
                width: 100%;
            }
        }

        /* Анимация загрузки */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }
        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Стили для секции достижений */
        .achievements {
            padding: 80px 0;
            background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80') center/cover fixed;
            position: relative;
            overflow: hidden;
        }

        .achievements::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(139, 69, 19, 0.85);
            backdrop-filter: blur(5px);
        }

        .achievement-container {
            position: relative;
            z-index: 1;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .achievement-container.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .achievement-item {
            text-align: center;
            padding: 40px 20px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            backdrop-filter: blur(10px);
            color: white;
            transition: all 0.5s ease;
            position: relative;
            overflow: hidden;
        }

        .achievement-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--accent-color), transparent);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .achievement-item:hover::before {
            transform: translateX(100%);
        }

        .achievement-item:hover {
            transform: translateY(-10px) scale(1.02);
            background: rgba(255, 255, 255, 0.15);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .achievement-icon {
            font-size: 3.5rem;
            margin-bottom: 20px;
            background: linear-gradient(45deg, var(--accent-color), var(--primary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            transition: all 0.5s ease;
            display: inline-block;
        }

        .achievement-item:hover .achievement-icon {
            transform: rotateY(360deg);
        }

        .achievement-number {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
            background: linear-gradient(45deg, #fff, var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.5s ease;
        }

        .achievement-number.visible {
            opacity: 1;
            transform: scale(1);
        }

        .achievement-text {
            font-size: 1.2rem;
            opacity: 0.9;
            position: relative;
            padding-bottom: 15px;
        }

        .achievement-text::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: var(--accent-color);
            transition: width 0.3s ease;
        }

        .achievement-item:hover .achievement-text::after {
            width: 80px;
        }

        @keyframes countUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>
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
    <div class="container mt-5">
        <h1 class="text-center mb-5">.</h1>
        
        <!-- Фильтры -->
        <div class="filters-section">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" id="searchInput" placeholder="Поиск событий...">
            </div>
            <div class="filter-group">
                <select class="form-select" id="periodFilter">
                    <option value="">Все периоды</option>
                    <option value="ancient">Древний мир</option>
                    <option value="middle">Средние века</option>
                    <option value="modern">Новое время</option>
                    <option value="contemporary">Новейшее время</option>
                </select>
                <select class="form-select" id="categoryFilter">
                    <option value="">Все категории</option>
                    <option value="politics">Политика</option>
                    <option value="culture">Культура</option>
                    <option value="science">Наука</option>
                    <option value="war">Войны</option>
                </select>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="timeline">
            <!-- Древний мир -->
            <div class="timeline-item" data-period="ancient" data-category="culture">
                <div class="timeline-content">
                    <div class="timeline-date">753 г. до н.э.</div>
                    <h3 class="timeline-title">Основание Рима</h3>
                    <p class="timeline-description">Легендарное основание города Рима в 753 году до н.э.</p>
                    <img src="images/rome.webp" alt="Основание Рима" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Древний мир</span>
                        <span class="badge bg-secondary">Культура</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="ancient" data-category="war">
                <div class="timeline-content">
                    <div class="timeline-date">216 г. до н.э.</div>
                    <h3 class="timeline-title">Битва при Каннах</h3>
                    <p class="timeline-description">Одно из крупнейших сражений Второй Пунической войны.</p>
                    <img src="images/Kans_fight.jpg" alt="Битва при Каннах" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Древний мир</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="ancient">
                <div class="timeline-content">
                    <div class="timeline-date">221 г. до н.э.</div>
                    <h3 class="timeline-title">Великая китайская стена</h3>
                    <p class="timeline-description">Начало строительства Великой китайской стены в III веке до н.э.</p>
                    <img src="images/grand_wol.webp" alt="Великая китайская стена" class="timeline-image">
                    <span class="badge bg-primary">Древний мир</span>
                    <span class="badge bg-secondary">Культура</span>
                </div>
            </div>

            <!-- Средние века -->
            <div class="timeline-item" data-period="middle" data-category="culture">
                <div class="timeline-content">
                    <div class="timeline-date">988 г.</div>
                    <h3 class="timeline-title">Крещение Руси</h3>
                    <p class="timeline-description">Принятие христианства в 988 году князем Владимиром стало поворотным моментом в истории Древней Руси.</p>
                    <img src="images/Kreshenie.jpg" alt="Крещение Руси" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Культура</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="middle" data-category="war">
                <div class="timeline-content">
                    <div class="timeline-date">1096 г.</div>
                    <h3 class="timeline-title">Крестовые походы</h3>
                    <p class="timeline-description">Начало Первого крестового похода в 1096 году.</p>
                    <img src="images/krest_wolke.webp" alt="Крестовые походы" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="middle" data-category="politics">
                <div class="timeline-content">
                    <div class="timeline-date">1147 г.</div>
                    <h3 class="timeline-title">Основание Москвы</h3>
                    <p class="timeline-description">Первое упоминание Москвы в летописях в 1147 году.</p>
                    <img src="images/moskow.webp" alt="Основание Москвы" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="middle" data-category="war">
                <div class="timeline-content">
                    <div class="timeline-date">1242 г.</div>
                    <h3 class="timeline-title">Ледовое побоище</h3>
                    <p class="timeline-description">Битва на Чудском озере в 1242 году, где войска Александра Невского разгромили немецких рыцарей.</p>
                    <img src="images/ise_fight.jpg" alt="Ледовое побоище" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="middle" data-category="science">
                <div class="timeline-content">
                    <div class="timeline-date">1347 г.</div>
                    <h3 class="timeline-title">Черная смерть</h3>
                    <p class="timeline-description">Начало пандемии чумы в Европе в 1347 году.</p>
                    <img src="images/chuma.jpg" alt="Черная смерть" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Наука</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="middle" data-category="war">
                <div class="timeline-content">
                    <div class="timeline-date">1380 г.</div>
                    <h3 class="timeline-title">Куликовская битва</h3>
                    <p class="timeline-description">Решающее сражение между русскими войсками и ордой Мамая в 1380 году.</p>
                    <img src="images/culek_fight.jpg" alt="Куликовская битва" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="middle">
                <div class="timeline-content">
                    <div class="timeline-date">1480 г.</div>
                    <h3 class="timeline-title">Стояние на Угре</h3>
                    <p class="timeline-description">Окончательное освобождение Руси от ордынского ига в 1480 году.</p>
                    <img src="images/Kreshenie.jpg" alt="Крещение Руси" class="timeline-image">
                    <span class="badge bg-primary">Средние века</span>
                    <span class="badge bg-secondary">Войны</span>
                </div>
            </div>

            <!-- Новое время -->
            <div class="timeline-item" data-period="modern" data-category="science">
                <div class="timeline-content">
                    <div class="timeline-date">XV-XVII вв.</div>
                    <h3 class="timeline-title">Великие географические открытия</h3>
                    <p class="timeline-description">Эпоха Великих географических открытий XV-XVII веков.</p>
                    <img src="images/grand_geo_open.jpg" alt="Великие географические открытия" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Наука</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="modern" data-category="culture">
                <div class="timeline-content">
                    <div class="timeline-date">1517 г.</div>
                    <h3 class="timeline-title">Реформация</h3>
                    <p class="timeline-description">Начало Реформации в 1517 году с выступления Мартина Лютера.</p>
                    <img src="images/reforms.webp" alt="Реформация" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Культура</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="modern" data-category="war">
                <div class="timeline-content">
                    <div class="timeline-date">1618 г.</div>
                    <h3 class="timeline-title">Тридцатилетняя война</h3>
                    <p class="timeline-description">Начало Тридцатилетней войны в 1618 году.</p>
                    <img src="images/thetin_ages_war.jpg" alt="Тридцатилетняя война" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="modern" data-category="politics">
                <div class="timeline-content">
                    <div class="timeline-date">1703 г.</div>
                    <h3 class="timeline-title">Основание Санкт-Петербурга</h3>
                    <p class="timeline-description">В 1703 году Петр I основал новый город, который стал столицей Российской империи.</p>
                    <img src="images/Peterburg.jpg" alt="Основание Санкт-Петербурга" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="modern">
                <div class="timeline-content">
                    <div class="timeline-date">1789 г.</div>
                    <h3 class="timeline-title">Великая французская революция</h3>
                    <p class="timeline-description">Начало Великой французской революции в 1789 году.</p>
                    <img src="images/Kans_fight.jpg" alt="Крещение Руси" class="timeline-image">
                    <span class="badge bg-primary">Новое время</span>
                    <span class="badge bg-secondary">Политика</span>
                </div>
            </div>

            <div class="timeline-item" data-period="modern">
                <div class="timeline-content">
                    <div class="timeline-date">1812 г.</div>
                    <h3 class="timeline-title">Бородинское сражение</h3>
                    <p class="timeline-description">Крупнейшее сражение Отечественной войны 1812 года между русской и французской армиями.</p>
                     <img src="images/culek_fight.jpg" alt="Крещение Руси" class="timeline-image">
                    <span class="badge bg-primary">Новое время</span>
                    <span class="badge bg-secondary">Войны</span>
                </div>
            </div>

            <div class="timeline-item" data-period="modern">
                <div class="timeline-content">
                    <div class="timeline-date">1861 г.</div>
                    <h3 class="timeline-title">Отмена крепостного права</h3>
                    <p class="timeline-description">В 1861 году Александр II подписал манифест об отмене крепостного права в России.</p>
                    <img src="images/thetin_ages_war.jpg" alt="Крещение Руси" class="timeline-image">
                    <span class="badge bg-primary">Новое время</span>
                    <span class="badge bg-secondary">Политика</span>
                </div>
            </div>

            <!-- Новейшее время -->
            <div class="timeline-item" data-period="contemporary" data-category="war">
                <div class="timeline-content">
                    <div class="timeline-date">1914 г.</div>
                    <h3 class="timeline-title">Первая мировая война</h3>
                    <p class="timeline-description">Начало Первой мировой войны в 1914 году.</p>
                    <img src="images/World_war.jpg" alt="Первая мировая война" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="contemporary" data-category="politics">
                <div class="timeline-content">
                    <div class="timeline-date">1917 г.</div>
                    <h3 class="timeline-title">Великая Октябрьская революция</h3>
                    <p class="timeline-description">Октябрьская революция 1917 года - одно из важнейших событий XX века, которое привело к созданию первого в мире социалистического государства.</p>
                    <img src="images/grait_october_revalushen.jpg" alt="Великая Октябрьская революция" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="contemporary" data-category="war">
                <div class="timeline-content">
                    <div class="timeline-date">1941 г.</div>
                    <h3 class="timeline-title">Великая Отечественная война</h3>
                    <p class="timeline-description">Начало Великой Отечественной войны 22 июня 1941 года.</p>
                    <img src="images/grait_otechestv_war.jpg" alt="Великая Отечественная война" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="contemporary" data-category="science">
                <div class="timeline-content">
                    <div class="timeline-date">1961 г.</div>
                    <h3 class="timeline-title">Полет Гагарина</h3>
                    <p class="timeline-description">12 апреля 1961 года Юрий Гагарин стал первым человеком, побывавшим в космосе.</p>
                    <img src="images/gagarin.webp" alt="Полет Гагарина" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Наука</span>
                    </div>
                </div>
            </div>

            <div class="timeline-item" data-period="contemporary" data-category="politics">
                <div class="timeline-content">
                    <div class="timeline-date">1991 г.</div>
                    <h3 class="timeline-title">Распад СССР</h3>
                    <p class="timeline-description">26 декабря 1991 года Советский Союз официально прекратил свое существование.</p>
                    <img src="images/USSR.jpg" alt="Распад СССР" class="timeline-image">
                    <div class="timeline-badges">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Политика</span>
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
    <script>
        // Функция для фильтрации событий
        function filterEvents() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            const periodFilter = document.getElementById('periodFilter').value;
            const categoryFilter = document.getElementById('categoryFilter').value;
            
            const events = document.querySelectorAll('.timeline-item');
            
            events.forEach(event => {
                const title = event.querySelector('.timeline-title').textContent.toLowerCase();
                const description = event.querySelector('.timeline-description').textContent.toLowerCase();
                const period = event.getAttribute('data-period');
                const category = event.querySelector('.badge.bg-secondary').textContent.toLowerCase();
                
                const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
                const matchesPeriod = !periodFilter || period === periodFilter;
                const matchesCategory = !categoryFilter || category.includes(categoryFilter.toLowerCase());
                
                if (matchesSearch && matchesPeriod && matchesCategory) {
                    event.style.display = 'block';
                } else {
                    event.style.display = 'none';
                }
            });
        }

        // Добавляем обработчики событий для фильтров
        document.getElementById('searchInput').addEventListener('input', filterEvents);
        document.getElementById('periodFilter').addEventListener('change', filterEvents);
        document.getElementById('categoryFilter').addEventListener('change', filterEvents);

        // Добавляем JavaScript для анимации
        document.addEventListener('DOMContentLoaded', function() {
            const achievementContainer = document.querySelector('.achievement-container');
            const achievementNumbers = document.querySelectorAll('.achievement-number');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        
                        if (entry.target.classList.contains('achievement-container')) {
                            animateNumbers();
                        }
                    }
                });
            }, { threshold: 0.3 });
            
            observer.observe(achievementContainer);
            
            function animateNumbers() {
                achievementNumbers.forEach(number => {
                    const targetValue = parseInt(number.getAttribute('data-value'));
                    let currentValue = 0;
                    const duration = 2000; // 2 seconds
                    const stepTime = 20;
                    const steps = duration / stepTime;
                    const increment = targetValue / steps;
                    
                    number.classList.add('visible');
                    
                    const timer = setInterval(() => {
                        currentValue += increment;
                        if (currentValue >= targetValue) {
                            number.textContent = targetValue;
                            clearInterval(timer);
                        } else {
                            number.textContent = Math.floor(currentValue);
                        }
                    }, stepTime);
                });
            }
        });
    </script>
</body>
</html>
