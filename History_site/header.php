<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Исторические события'; ?></title>
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

        .modal-content {
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border: 1px solid var(--glass-border);
            border-radius: 20px;
        }

        .modal-header {
            background: var(--gradient-secondary);
            border-bottom: none;
            border-radius: 20px 20px 0 0;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            padding: 12px;
            color: var(--text-color);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: var(--neon-shadow);
            border-color: var(--accent-color);
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
</body>
</html> 