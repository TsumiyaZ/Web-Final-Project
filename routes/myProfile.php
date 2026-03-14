<?php

if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}

$user_id = $_SESSION['user']['user_id'];
$user_data = getUserById($user_id);

$data = ['user' => $user_data];

renderView('myProfile', $data);