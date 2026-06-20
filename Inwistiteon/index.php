<?php
// index.php
session_start();

// Если пользователь уже авторизован, перенаправляем его на страницу приветствия
if (isset($_SESSION['user'])) {
    header("Location: lk/welcome.php");
    exit();
}

// Подключаем HTML-страницу
require_once('views/index_page.php');
?>