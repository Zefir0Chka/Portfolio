<?php
session_start();

// Уничтожаем сессию
session_destroy();

// Перенаправляем на страницу регистрации
header("Location: register.php");
exit();
?>