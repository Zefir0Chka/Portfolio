<?php
require_once 'db.php';

// Создание таблицы пользователей
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

executeQuery($sql);

// Добавление тестового пользователя
$test_username = "admin";
$test_email = "admin@example.com";
$test_password = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password) 
        VALUES ('$test_username', '$test_email', '$test_password')
        ON DUPLICATE KEY UPDATE id=id;";

executeQuery($sql);

echo json_encode([
    'success' => true,
    'message' => 'База данных успешно инициализирована'
], JSON_UNESCAPED_UNICODE);
?> 