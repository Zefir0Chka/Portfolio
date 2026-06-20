<?php
require_once 'db.php';

// Пример добавления нового пользователя
function addUser($username, $email, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    
    $stmt = mysqli_prepare($GLOBALS['conn'], $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
    
    if (mysqli_stmt_execute($stmt)) {
        return [
            'success' => true,
            'message' => 'Пользователь успешно добавлен',
            'user_id' => mysqli_insert_id($GLOBALS['conn'])
        ];
    } else {
        return [
            'success' => false,
            'message' => 'Ошибка при добавлении пользователя: ' . mysqli_error($GLOBALS['conn'])
        ];
    }
}

// Пример получения пользователя по email
function getUserByEmail($email) {
    $sql = "SELECT * FROM users WHERE email = ?";
    
    $stmt = mysqli_prepare($GLOBALS['conn'], $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

// Пример проверки пароля
function verifyPassword($email, $password) {
    $user = getUserByEmail($email);
    if ($user && password_verify($password, $user['password'])) {
        return [
            'success' => true,
            'user' => $user
        ];
    }
    return [
        'success' => false,
        'message' => 'Неверный email или пароль'
    ];
}

// Пример получения всех пользователей
function getAllUsers() {
    return getData("SELECT id, username, email, created_at FROM users");
}

// Пример использования функций
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['action'])) {
        switch ($data['action']) {
            case 'register':
                $result = addUser($data['username'], $data['email'], $data['password']);
                break;
            case 'login':
                $result = verifyPassword($data['email'], $data['password']);
                break;
            case 'get_users':
                $result = getAllUsers();
                break;
            default:
                $result = ['success' => false, 'message' => 'Неизвестное действие'];
        }
        
        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}
?> 