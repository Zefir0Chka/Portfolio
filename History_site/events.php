<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>События - Исторические события</title>
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
            color: white !important;
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
    </style>
</head>
<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Исторические события</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'index' ? 'active' : ''; ?>" href="index.php">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'events' ? 'active' : ''; ?>" href="events.php">События</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'chronology' ? 'active' : ''; ?>" href="chronology.php">Хронология</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'map' ? 'active' : ''; ?>" href="map.php">Карта</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo $currentPage === 'about' ? 'active' : ''; ?>" href="about.php">О нас</a>
                    </li>
                </ul>
            <div class="d-flex">
                <button class="btn btn-custom me-2" data-bs-toggle="modal" data-bs-target="#loginModal">Вход</button>
                <button class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#registerModal">Регистрация</button>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h1 class="text-center mb-5">Исторические события</h1>
    
    <!-- Фильтры -->
    <div class="filters-section mb-5">
        <div class="filter-container p-4 rounded-3 shadow-sm">
            <h4 class="filter-title mb-4">Фильтры поиска</h4>
            <div class="row g-4">
                <!-- Поиск -->
                <div class="col-md-6">
                    <div class="search-box">
                        <i class="fas fa-search search-icon"></i>
                        <input type="text" class="form-control search-input" id="searchInput" placeholder="Поиск событий...">
                    </div>
                </div>

                <!-- Период -->
                <div class="col-md-6">
                    <div class="filter-group">
                    
                        <select class="form-select custom-select" id="periodFilter">
                            <option value="">Все периоды</option>
                            <option value="ancient">Древний мир</option>
                            <option value="middle">Средние века</option>
                            <option value="modern">Новое время</option>
                            <option value="contemporary">Новейшее время</option>
                        </select>
                    </div>
                </div>

                <!-- Категория -->
                <div class="col-md-4">
                    <div class="filter-group">
                        <label class="filter-label">Категория</label>
                        <select class="form-select custom-select" id="categoryFilter">
                            <option value="">Все категории</option>
                            <option value="politics">Политика</option>
                            <option value="culture">Культура</option>
                            <option value="war">Войны</option>
                            <option value="science">Наука</option>
                        </select>
                    </div>
                </div>

                <!-- Важность события -->
                <div class="col-md-4">
                    <div class="filter-group">
                        <label class="filter-label">Важность события</label>
                        <select class="form-select custom-select" id="importanceFilter">
                            <option value="">Любая важность</option>
                            <option value="high">Высокая</option>
                            <option value="medium">Средняя</option>
                            <option value="low">Низкая</option>
                        </select>
                    </div>
                </div>

                <!-- Сортировка -->
                <div class="col-md-4">
                    <div class="filter-group">
                        <label class="filter-label">Сортировка</label>
                        <select class="form-select custom-select" id="sortFilter">
                            <option value="date_asc">По дате (возрастание)</option>
                            <option value="date_desc">По дате (убывание)</option>
                            <option value="title_asc">По названию (А-Я)</option>
                            <option value="title_desc">По названию (Я-А)</option>
                        </select>
                    </div>
                </div>

                <!-- Быстрые фильтры -->
                <div class="col-12">
                    <div class="quick-filters">
                        <label class="filter-label mb-3">Быстрые фильтры:</label>
                        <div class="quick-filter-buttons">
                            <button type="button" class="quick-filter-btn" data-filter="period" data-value="ancient">
                                <i class="fas fa-landmark"></i> Древний мир
                            </button>
                            <button type="button" class="quick-filter-btn" data-filter="period" data-value="middle">
                                <i class="fas fa-chess-knight"></i> Средние века
                            </button>
                            <button type="button" class="quick-filter-btn" data-filter="period" data-value="modern">
                                <i class="fas fa-book"></i> Новое время
                            </button>
                            <button type="button" class="quick-filter-btn" data-filter="period" data-value="contemporary">
                                <i class="fas fa-rocket"></i> Новейшее время
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Сброс фильтров -->
                <div class="col-12 text-end mt-4">
                    <button type="button" class="reset-filters-btn" id="resetFilters">
                        <i class="fas fa-undo-alt me-2"></i>Сбросить фильтры
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- События -->
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <!-- Древний мир -->
        <div class="col" data-period="ancient" data-category="culture">
            <div class="card h-100">
                <img src="images/rome.webp" class="card-img-top" alt="Основание Рима">
                <div class="card-body">
                    <h5 class="card-title">Основание Рима</h5>
                    <p class="card-text">Легендарное основание города Рима в 753 году до н.э.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Древний мир</span>
                        <span class="badge bg-secondary">Культура</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="ancient" data-category="war">
            <div class="card h-100">
                <img src="images/Kans_fight.jpg" class="card-img-top" alt="Битва при Каннах">
                <div class="card-body">
                    <h5 class="card-title">Битва при Каннах</h5>
                    <p class="card-text">Одно из крупнейших сражений Второй Пунической войны в 216 году до н.э.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Древний мир</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="ancient" data-category="culture">
            <div class="card h-100">
                <img src="images/grand_wol.webp" class="card-img-top" alt="Великая китайская стена">
                <div class="card-body">
                    <h5 class="card-title">Великая китайская стена</h5>
                    <p class="card-text">Начало строительства Великой китайской стены в III веке до н.э.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Древний мир</span>
                        <span class="badge bg-secondary">Культура</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Средние века -->
        <div class="col" data-period="middle" data-category="culture">
            <div class="card h-100">
                <img src="images/Kreshenie.jpg" class="card-img-top" alt="Крещение Руси">
                <div class="card-body">
                    <h5 class="card-title">Крещение Руси</h5>
                    <p class="card-text">Принятие христианства в 988 году князем Владимиром стало поворотным моментом в истории Древней Руси.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Культура</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="middle" data-category="war">
            <div class="card h-100">
                <img src="images/krest_wolke.webp" class="card-img-top" alt="Крестовые походы">
                <div class="card-body">
                    <h5 class="card-title">Крестовые походы</h5>
                    <p class="card-text">Начало Первого крестового похода в 1096 году.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="middle" data-category="politics">
            <div class="card h-100">
                <img src="images/moskow.webp" class="card-img-top" alt="Основание Москвы">
                <div class="card-body">
                    <h5 class="card-title">Основание Москвы</h5>
                    <p class="card-text">Первое упоминание Москвы в летописях в 1147 году.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="middle" data-category="war">
            <div class="card h-100">
                <img src="images/ise_fight.jpg" class="card-img-top" alt="Ледовое побоище">
                <div class="card-body">
                    <h5 class="card-title">Ледовое побоище</h5>
                    <p class="card-text">Битва на Чудском озере в 1242 году, где войска Александра Невского разгромили немецких рыцарей.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="middle" data-category="science">
            <div class="card h-100">
                <img src="images/chuma.jpg" class="card-img-top" alt="Черная смерть">
                <div class="card-body">
                    <h5 class="card-title">Черная смерть</h5>
                    <p class="card-text">Начало пандемии чумы в Европе в 1347 году.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Наука</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="middle" data-category="war">
            <div class="card h-100">
                <img src="images/culek_fight.jpg" class="card-img-top" alt="Куликовская битва">
                <div class="card-body">
                    <h5 class="card-title">Куликовская битва</h5>
                    <p class="card-text">Решающее сражение между русскими войсками и ордой Мамая в 1380 году.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Средние века</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Новое время -->
        <div class="col" data-period="modern" data-category="science">
            <div class="card h-100">
                <img src="images/grand_geo_open.jpg" class="card-img-top" alt="Великие географические открытия">
                <div class="card-body">
                    <h5 class="card-title">Великие географические открытия</h5>
                    <p class="card-text">Эпоха Великих географических открытий XV-XVII веков.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Наука</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="modern" data-category="culture">
            <div class="card h-100">
                <img src="images/reforms.webp" class="card-img-top" alt="Реформация">
                <div class="card-body">
                    <h5 class="card-title">Реформация</h5>
                    <p class="card-text">Начало Реформации в 1517 году с выступления Мартина Лютера.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Культура</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="modern" data-category="war">
            <div class="card h-100">
                <img src="images/thetin_ages_war.jpg" class="card-img-top" alt="Тридцатилетняя война">
                <div class="card-body">
                    <h5 class="card-title">Тридцатилетняя война</h5>
                    <p class="card-text">Начало Тридцатилетней войны в 1618 году.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="modern" data-category="politics">
            <div class="card h-100">
                <img src="images/Peterburg.jpg" class="card-img-top" alt="Основание Санкт-Петербурга">
                <div class="card-body">
                    <h5 class="card-title">Основание Санкт-Петербурга</h5>
                    <p class="card-text">В 1703 году Петр I основал новый город, который стал столицей Российской империи.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="modern" data-category="politics">
            <div class="card h-100">
                <img src="images/new_time.webp" class="card-img-top" alt="Великая французская революция">
                <div class="card-body">
                    <h5 class="card-title">Великая французская революция</h5>
                    <p class="card-text">Начало Великой французской революции в 1789 году.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="modern" data-category="war">
            <div class="card h-100">
                <img src="images/new_time.webp" class="card-img-top" alt="Бородинское сражение">
                <div class="card-body">
                    <h5 class="card-title">Бородинское сражение</h5>
                    <p class="card-text">Крупнейшее сражение Отечественной войны 1812 года между русской и французской армиями.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="modern" data-category="politics">
            <div class="card h-100">
                <img src="images/thetin_ages_war.jpg" class="card-img-top" alt="Отмена крепостного права">
                <div class="card-body">
                    <h5 class="card-title">Отмена крепостного права</h5>
                    <p class="card-text">В 1861 году Александр II подписал манифест об отмене крепостного права в России.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новое время</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Новейшее время -->
        <div class="col" data-period="contemporary" data-category="war">
            <div class="card h-100">
                <img src="images/World_war.jpg" class="card-img-top" alt="Первая мировая война">
                <div class="card-body">
                    <h5 class="card-title">Первая мировая война</h5>
                    <p class="card-text">Начало Первой мировой войны в 1914 году.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="contemporary" data-category="politics">
            <div class="card h-100">
                <img src="images/grait_october_revalushen.jpg" class="card-img-top" alt="Великая Октябрьская революция">
                <div class="card-body">
                    <h5 class="card-title">Великая Октябрьская революция</h5>
                    <p class="card-text">Октябрьская революция 1917 года - одно из важнейших событий XX века, которое привело к созданию первого в мире социалистического государства.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="contemporary" data-category="war">
            <div class="card h-100">
                <img src="images/grait_otechestv_war.jpg" class="card-img-top" alt="Великая Отечественная война">
                <div class="card-body">
                    <h5 class="card-title">Великая Отечественная война</h5>
                    <p class="card-text">Начало Великой Отечественной войны 22 июня 1941 года.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Войны</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="contemporary" data-category="science">
            <div class="card h-100">
                <img src="images/gagarin.webp" class="card-img-top" alt="Полет Гагарина">
                <div class="card-body">
                    <h5 class="card-title">Полет Гагарина</h5>
                    <p class="card-text">12 апреля 1961 года Юрий Гагарин стал первым человеком, побывавшим в космосе.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Наука</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col" data-period="contemporary" data-category="politics">
            <div class="card h-100">
                <img src="images/USSR.jpg" class="card-img-top" alt="Распад СССР">
                <div class="card-body">
                    <h5 class="card-title">Распад СССР</h5>
                    <p class="card-text">26 декабря 1991 года Советский Союз официально прекратил свое существование.</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="badge bg-primary">Новейшее время</span>
                        <span class="badge bg-secondary">Политика</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Исторические периоды -->
<div class="container gallery-section my-5">
    <div class="section-header text-center mb-5">
        <h2 class="section-title">Исторические периоды</h2>
        <div class="section-divider"></div>
        <p class="section-subtitle">Исследуйте различные эпохи человеческой истории</p>
    </div>
    <div class="row g-4 justify-content-center">
        <div class="col-md-4">
            <div class="period-card h-100" data-period="ancient">
                <div class="period-image">
                    <img src="images/rome.webp" alt="Древний Рим">
                    <div class="period-overlay">
                        <div class="period-icon">
                            <i class="fas fa-landmark"></i>
                        </div>
                    </div>
                </div>
                <div class="period-content d-flex flex-column">
                    <h3 class="period-title">Древний мир</h3>
                    <p class="period-description flex-grow-1">От зарождения цивилизаций до падения Римской империи</p>
                    <div class="period-stats">
                        <div class="stat">
                            <i class="fas fa-scroll"></i>
                            <span>500+ событий</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-globe-europe"></i>
                            <span>12 цивилизаций</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="period-card h-100" data-period="middle">
                <div class="period-image">
                    <img src="images/midle_time.jpg" alt="Средние века">
                    <div class="period-overlay">
                        <div class="period-icon">
                            <i class="fas fa-chess-rook"></i>
                        </div>
                    </div>
                </div>
                <div class="period-content d-flex flex-column">
                    <h3 class="period-title">Средние века</h3>
                    <p class="period-description flex-grow-1">Эпоха рыцарей, замков и великих открытий</p>
                    <div class="period-stats">
                        <div class="stat">
                            <i class="fas fa-scroll"></i>
                            <span>300+ событий</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-crown"></i>
                            <span>15 королевств</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="period-card h-100" data-period="modern">
                <div class="period-image">
                    <img src="images/new_time.webp" alt="Новое время">
                    <div class="period-overlay">
                        <div class="period-icon">
                            <i class="fas fa-industry"></i>
                        </div>
                    </div>
                </div>
                <div class="period-content d-flex flex-column">
                    <h3 class="period-title">Новое время</h3>
                    <p class="period-description flex-grow-1">Эпоха революций, изобретений и перемен</p>
                    <div class="period-stats">
                        <div class="stat">
                            <i class="fas fa-scroll"></i>
                            <span>400+ событий</span>
                        </div>
                        <div class="stat">
                            <i class="fas fa-lightbulb"></i>
                            <span>50+ открытий</span>
                        </div>
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

<!-- Модальное окно деталей события -->
<div class="modal fade" id="eventDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventDetailsTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="" id="eventDetailsImage" class="img-fluid rounded mb-3" alt="">
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-2" id="eventDetailsDate"></p>
                        <p class="mb-3" id="eventDetailsDescription"></p>
                        <div class="d-flex gap-2">
                            <span class="badge bg-primary" id="eventDetailsPeriod"></span>
                            <span class="badge bg-secondary" id="eventDetailsCategory"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="button" class="btn btn-primary" id="addToFavoritesBtn">
                    <i class="fas fa-star"></i> В избранное
                </button>
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
    // Обновленная функция фильтрации
    function filterEvents() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const periodFilter = document.getElementById('periodFilter').value;
        const categoryFilter = document.getElementById('categoryFilter').value;
        const importanceFilter = document.getElementById('importanceFilter').value;
        const sortFilter = document.getElementById('sortFilter').value;
        
        const events = document.querySelectorAll('.col[data-period]');
        let visibleEvents = [];
        
        events.forEach(event => {
            const title = event.querySelector('.card-title').textContent.toLowerCase();
            const description = event.querySelector('.card-text').textContent.toLowerCase();
            const period = event.getAttribute('data-period');
            const category = event.getAttribute('data-category');
            
            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesPeriod = !periodFilter || period === periodFilter;
            const matchesCategory = !categoryFilter || category === categoryFilter;
            
            if (matchesSearch && matchesPeriod && matchesCategory) {
                event.style.display = 'block';
                visibleEvents.push(event);
            } else {
                event.style.display = 'none';
            }
        });

        // Сортировка
        sortEvents(visibleEvents, sortFilter);
    }

    // Функция сортировки
    function sortEvents(events, sortType) {
        const container = document.querySelector('.row.row-cols-1');
        const sortedEvents = [...events];

        switch(sortType) {
            case 'date_asc':
                sortedEvents.sort((a, b) => {
                    const dateA = parseInt(a.querySelector('.card-text').textContent.match(/\d+/)[0]);
                    const dateB = parseInt(b.querySelector('.card-text').textContent.match(/\d+/)[0]);
                    return dateA - dateB;
                });
                break;
            case 'date_desc':
                sortedEvents.sort((a, b) => {
                    const dateA = parseInt(a.querySelector('.card-text').textContent.match(/\d+/)[0]);
                    const dateB = parseInt(b.querySelector('.card-text').textContent.match(/\d+/)[0]);
                    return dateB - dateA;
                });
                break;
            case 'title_asc':
                sortedEvents.sort((a, b) => {
                    const titleA = a.querySelector('.card-title').textContent;
                    const titleB = b.querySelector('.card-title').textContent;
                    return titleA.localeCompare(titleB);
                });
                break;
            case 'title_desc':
                sortedEvents.sort((a, b) => {
                    const titleA = a.querySelector('.card-title').textContent;
                    const titleB = b.querySelector('.card-title').textContent;
                    return titleB.localeCompare(titleA);
                });
                break;
        }

        // Перемещение элементов в новом порядке
        sortedEvents.forEach(event => {
            container.appendChild(event);
        });
    }

    // Обработчики событий
    document.getElementById('searchInput').addEventListener('input', filterEvents);
    document.getElementById('periodFilter').addEventListener('change', filterEvents);
    document.getElementById('categoryFilter').addEventListener('change', filterEvents);
    document.getElementById('importanceFilter').addEventListener('change', filterEvents);
    document.getElementById('sortFilter').addEventListener('change', filterEvents);

    // Быстрые фильтры
    document.querySelectorAll('.quick-filter-btn').forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.dataset.filter;
            const value = this.dataset.value;
            document.getElementById(`${filter}Filter`).value = value;
            filterEvents();
        });
    });

    // Сброс фильтров
    document.getElementById('resetFilters').addEventListener('click', function() {
        document.getElementById('searchInput').value = '';
        document.getElementById('periodFilter').value = '';
        document.getElementById('categoryFilter').value = '';
        document.getElementById('importanceFilter').value = '';
        document.getElementById('sortFilter').value = 'date_asc';
        filterEvents();
    });
</script>

<style>
.filters-section {
    background: var(--glass-bg);
    backdrop-filter: blur(10px);
    border: 1px solid var(--glass-border);
}

.filter-container {
    background: rgba(255, 255, 255, 0.9);
}

.filter-title {
    color: var(--primary-color);
    font-weight: 600;
    position: relative;
    padding-bottom: 10px;
}

.filter-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 50px;
    height: 3px;
    background: var(--primary-color);
    border-radius: 2px;
}

.search-box {
    position: relative;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--primary-color);
    z-index: 2;
}

.search-input {
    padding-left: 45px;
    height: 48px;
    border-radius: 24px;
    border: 2px solid var(--border-color);
    background: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
}

.filter-label {
    color: var(--text-color);
    font-weight: 600;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.custom-select {
    height: 48px;
    border-radius: 24px;
    border: 2px solid var(--border-color);
    padding: 0 20px;
    background: rgba(255, 255, 255, 0.9);
    transition: all 0.3s ease;
    cursor: pointer;
}

.custom-select:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(139, 69, 19, 0.25);
}

.quick-filter-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.quick-filter-btn {
    padding: 10px 20px;
    border-radius: 20px;
    border: 2px solid var(--border-color);
    background: rgba(255, 255, 255, 0.9);
    color: var(--text-color);
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.quick-filter-btn:hover {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.quick-filter-btn i {
    margin-right: 8px;
}

.reset-filters-btn {
    padding: 12px 25px;
    border-radius: 20px;
    border: 2px solid var(--border-color);
    background: rgba(255, 255, 255, 0.9);
    color: var(--text-color);
    font-weight: 500;
    transition: all 0.3s ease;
    cursor: pointer;
}

.reset-filters-btn:hover {
    background: var(--accent-color);
    color: white;
    border-color: var(--accent-color);
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .quick-filter-buttons {
        flex-direction: column;
    }
    
    .quick-filter-btn {
        width: 100%;
        text-align: center;
    }
    
    .search-input,
    .custom-select {
        height: 42px;
    }
}

/* Стили для секции исторических периодов */
.gallery-section {
    padding: 60px 0;
    background: var(--background-color);
}

.section-header {
    margin-bottom: 50px;
}

.section-title {
    color: var(--primary-color);
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 20px;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.section-divider {
    width: 80px;
    height: 4px;
    background: var(--gradient-primary);
    margin: 20px auto;
    border-radius: 2px;
}

.section-subtitle {
    color: var(--text-color);
    font-size: 1.2rem;
    opacity: 0.8;
    max-width: 600px;
    margin: 0 auto;
}

.period-card {
    background: var(--glass-bg);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px var(--shadow-color);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    position: relative;
    border: 1px solid var(--glass-border);
    height: 100%;
    display: flex;
    flex-direction: column;
}

.period-card:hover {
    transform: translateY(-15px);
    box-shadow: 0 20px 40px var(--shadow-color);
}

.period-image {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.period-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.period-card:hover .period-image img {
    transform: scale(1.1);
}

.period-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(139, 69, 19, 0.2), rgba(139, 69, 19, 0.8));
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.period-card:hover .period-overlay {
    opacity: 1;
}

.period-icon {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transform: scale(0) rotate(-180deg);
    transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}

.period-card:hover .period-icon {
    transform: scale(1) rotate(0);
}

.period-icon i {
    font-size: 2rem;
    color: var(--primary-color);
    transition: transform 0.3s ease;
}

.period-card:hover .period-icon i {
    transform: scale(1.2);
}

.period-content {
    padding: 25px;
    background: rgba(255, 255, 255, 0.95);
    flex: 1;
    display: flex;
    flex-direction: column;
}

.period-title {
    color: var(--primary-color);
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 15px;
    position: relative;
    padding-bottom: 15px;
    text-align: center;
}

.period-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: var(--gradient-primary);
    border-radius: 2px;
}

.period-description {
    color: var(--text-color);
    font-size: 1rem;
    line-height: 1.6;
    text-align: center;
    margin-bottom: 20px;
    flex-grow: 1;
    display: flex;
    align-items: center;
    justify-content: center;
}

.period-stats {
    display: flex;
    justify-content: space-around;
    padding-top: 20px;
    border-top: 1px solid var(--border-color);
    margin-top: auto;
}

.stat {
    display: flex;
    align-items: center;
    gap: 10px;
    color: var(--text-color);
    font-size: 0.9rem;
    padding: 8px 12px;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.5);
    transition: all 0.3s ease;
}

.stat:hover {
    background: var(--primary-color);
    color: white;
}

.stat:hover i {
    color: white;
}

.stat i {
    color: var(--primary-color);
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

@media (max-width: 768px) {
    .section-title {
        font-size: 2rem;
    }
    
    .period-card {
        margin-bottom: 30px;
    }
    
    .period-image {
        height: 200px;
    }
    
    .period-stats {
        flex-direction: column;
        gap: 10px;
    }
    
    .stat {
        justify-content: center;
    }
}

/* Анимация при появлении */
.period-card {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s ease forwards;
}

.period-card:nth-child(2) {
    animation-delay: 0.2s;
}

.period-card:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</body>
</html>
