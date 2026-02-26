<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['otp'])) {
        $_SESSION['error'] = 'ไม่พบ OTP';
        header('Location: /myJoinEvent');
        exit();
    }

    $otp = $_POST['otp'];
    $event_id = $_POST['event_Id'];
    $user_id = $_POST['user_id'];

    $verify = checkVerify($event_id, $otp, $user_id);
    if (!$verify) {
        $_SESSION['error'] = 'ไม่พบ OTP / OTP หมดอายุ';
    } else {
        $_SESSION['success'] = 'เช็คขื่อเข้าร่วมงานสำเร็จ';
    }
    header("Location: /manageEvent?event_id=" . $event_id);
    exit();
}

header("Location: /manageEvent?event_id=" . $event_id);
exit();
