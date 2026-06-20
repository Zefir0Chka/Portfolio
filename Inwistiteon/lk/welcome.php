<?php
// lk/welcome.php
session_start();

// Извлекаем логин пользователя из сессии
$email = $_SESSION['user']; // Просто используем значение строки
$login = $_SESSION['user'];

// Подключаем HTML-форму и передаём переменную $login
require_once('../views/welcome_page.php');
?>