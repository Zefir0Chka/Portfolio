<?php
session_start();
require_once 'db.php';
require_once 'check_auth.php';

// Проверка прав администратора
if (!isLoggedIn() || !isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: index.php');
    exit();
}

$pageTitle = 'Панель администратора';
$currentPage = 'admin';

// Получение статистики
$totalUsers = 0; // Здесь должен быть запрос к БД
$totalEvents = 0; // Здесь должен быть запрос к БД
$totalComments = 0; // Здесь должен быть запрос к БД
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора - Исторические события</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
    <style>
        .admin-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--neon-shadow);
        }

        .stat-box {
            background: var(--gradient-primary);
            color: white;
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-box:hover {
            transform: translateY(-5px);
            box-shadow: var(--neon-shadow);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 1rem 0;
        }

        .action-button {
            background: var(--gradient-primary);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            transform: translateY(-2px);
            box-shadow: var(--neon-shadow);
            color: white;
        }

        .table-container {
            background: var(--glass-bg);
            border-radius: 15px;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .admin-table {
            width: 100%;
        }

        .admin-table th {
            background: var(--gradient-primary);
            color: white;
            padding: 1rem;
        }

        .admin-table td {
            padding: 1rem;
            vertical-align: middle;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .status-active {
            background: #28a745;
            color: white;
        }

        .status-inactive {
            background: #dc3545;
            color: white;
        }

        .sidebar {
            background: var(--glass-bg);
            border-radius: 15px;
            padding: 1.5rem;
            height: 100%;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 0.8rem 1rem;
            color: var(--text-color);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.3s ease;
            margin-bottom: 0.5rem;
        }

        .sidebar-link:hover {
            background: var(--gradient-primary);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-link i {
            margin-right: 1rem;
        }
    </style>
</head>
<body>
    <?php require_once 'header.php'; ?>

    <div class="container-fluid mt-4">
        <div class="row">
            <!-- Боковое меню -->
            <div class="col-md-3 mb-4">
                <div class="sidebar">
                    <h4 class="mb-4">Панель управления</h4>
                    <a href="#dashboard" class="sidebar-link active">
                        <i class="fas fa-home"></i> Главная
                    </a>
                    <a href="#users" class="sidebar-link">
                        <i class="fas fa-users"></i> Пользователи
                    </a>
                    <a href="#events" class="sidebar-link">
                        <i class="fas fa-calendar-alt"></i> События
                    </a>
                    <a href="#comments" class="sidebar-link">
                        <i class="fas fa-comments"></i> Комментарии
                    </a>
                    <a href="#settings" class="sidebar-link">
                        <i class="fas fa-cog"></i> Настройки
                    </a>
                </div>
            </div>

            <!-- Основной контент -->
            <div class="col-md-9">
                <!-- Статистика -->
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="stat-box">
                            <i class="fas fa-users fa-2x"></i>
                            <div class="stat-number"><?php echo $totalUsers; ?></div>
                            <div>Пользователей</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <i class="fas fa-calendar-alt fa-2x"></i>
                            <div class="stat-number"><?php echo $totalEvents; ?></div>
                            <div>Событий</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat-box">
                            <i class="fas fa-comments fa-2x"></i>
                            <div class="stat-number"><?php echo $totalComments; ?></div>
                            <div>Комментариев</div>
                        </div>
                    </div>
                </div>

                <!-- Последние действия -->
                <div class="admin-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>Последние действия</h4>
                        <a href="#" class="action-button text-decoration-none">
                            <i class="fas fa-plus"></i> Добавить событие
                        </a>
                    </div>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Действие</th>
                                    <th>Пользователь</th>
                                    <th>Дата</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Добавлено новое событие</td>
                                    <td>Администратор</td>
                                    <td>2024-03-20</td>
                                    <td><span class="status-badge status-active">Активно</span></td>
                                </tr>
                                <tr>
                                    <td>Обновлен профиль пользователя</td>
                                    <td>Модератор</td>
                                    <td>2024-03-19</td>
                                    <td><span class="status-badge status-active">Активно</span></td>
                                </tr>
                                <tr>
                                    <td>Удален комментарий</td>
                                    <td>Модератор</td>
                                    <td>2024-03-18</td>
                                    <td><span class="status-badge status-inactive">Удалено</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Управление пользователями -->
                <div class="admin-card p-4 mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>Управление пользователями</h4>
                        <a href="#" class="action-button text-decoration-none">
                            <i class="fas fa-user-plus"></i> Добавить пользователя
                        </a>
                    </div>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Роль</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Администратор</td>
                                    <td>admin@example.com</td>
                                    <td>Администратор</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Модератор</td>
                                    <td>moderator@example.com</td>
                                    <td>Модератор</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Управление событиями -->
                <div class="admin-card p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>Управление событиями</h4>
                        <a href="#" class="action-button text-decoration-none">
                            <i class="fas fa-plus"></i> Добавить событие
                        </a>
                    </div>
                    <div class="table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Название</th>
                                    <th>Дата</th>
                                    <th>Категория</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Великая Отечественная война</td>
                                    <td>1941-1945</td>
                                    <td>Войны</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Полет Юрия Гагарина</td>
                                    <td>1961</td>
                                    <td>Космос</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Активация текущего пункта меню
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarLinks = document.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    sidebarLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
</body>
</html> 