<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($birthday) || empty($gender)) {
        $_SESSION['error'] = 'กรุณากรอกข้อมูลให้ครบทุกช่อง';
        header('Location: /home');
        exit();
    }

    if (checkEmailExists($email)) {
        $_SESSION['error'] = 'อีเมลนี้มีบัญชีอยู่เเล้ว';
        header('Location: /home');
        exit();
    }

    $result = insertUser($username, $birthday, $email, $password, $gender);
    
   
}        