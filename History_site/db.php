<?php
// includes/db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "website_db";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Установка кодировки
$conn->set_charset("utf8");
?>