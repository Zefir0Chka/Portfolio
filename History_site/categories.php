<?php
session_start();
require_once 'db.php';
require_once 'check_auth.php';

$pageTitle = 'Категории - Исторические события';
$currentPage = 'categories';

// Include the header
require_once 'header.php';
?>

<!-- Основной контент --> 