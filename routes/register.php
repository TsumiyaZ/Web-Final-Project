<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $birthday = $_POST['birthday'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if (empty($username) || empty($email) || empty($password) || empty($birthday) || empty($gender)) {
        $_SESSION['error'] = 'กรุณากรอกข้อมูลให้ครบทุกช่อง';
        header('Location: /register');
        exit();
    }

    if (checkEmailExists($email)) {
        $_SESSION['error'] = 'อีเมลนี้มีบัญชีอยู่เเล้ว';
        header('Location: /register');
        exit();
    }

    $result = insertUser($username, $birthday, $email, $password, $gender);
    
    if ($result) {
        $_SESSION['success'] = 'สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ';
        header('Location: /login');
        exit();
    } else {
        $_SESSION['error'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล';
        header('Location: /register');
        exit();
    }
} else {
    renderView('register');
}