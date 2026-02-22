<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'] ?? '';
    $user_id = $_POST['user_id'] ?? '';

    if (empty($event_id) || empty($user_id)) {
        $_SESSION['error'] = 'ข้อมูลไม่ครบถ้วน';
        header('Location: /home');
        exit();
    }

    if (joinEvent($event_id, $user_id)) {
        $_SESSION['success'] = 'ขอเข้าร่วมกิจกรรมสำเร็จ';
        header('Location: /home');
        exit();
    } else {
        $_SESSION['error'] = 'ขอเข้าร่วมกิจกรรมไม่สำเร็จ';
        header('Location: /home');
        exit();
    }
}