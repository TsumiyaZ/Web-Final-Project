<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $db = getUserByEmail($email);

    if ($db && password_verify($password, $db['password'])) {

        $_SESSION['user'] = [
            'user_id' => $db['user_id'],
            'name'    => $db['name']
        ];

        header('Location: /home', true, 303);
        exit();
    }
    
    $_SESSION['error'] = 'Invalid email or password';
    header('Location: /home', true, 303);
} else {
    renderView('home');
}   
