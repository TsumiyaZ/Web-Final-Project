<?php

if (isset($_SESSION['user'])) {
    $_SESSION = [];
    session_destroy();
    header('Location: /login');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = getUserByEmail($email);

    if ($db && password_verify($password, $db['password'])) {

        $_SESSION['user'] = [
            'user_id' => $db['user_id'],
            'name'    => $db['name']
        ];
        $unix_timestamp = time();
        $_SESSION['timestamp'] = $unix_timestamp;
        $_SESSION['success'] = "เข้าสู่ระบบเเล้ว";
        header('Location: /home', true, 303);
        exit();
    }

    $_SESSION['error'] = 'Invalid email or password';
    header('Location: /login', true, 303);
    exit();
} else {
    renderView('login');
}
