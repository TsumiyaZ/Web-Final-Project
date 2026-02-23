<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

$eventId = $_POST['event_id'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (deleteEvent($eventId)) {
        $_SESSION['success'] = 'ลบกิจกรรมเรียบร้อยแล้ว';
    } else {
        $_SESSION['error'] = 'ลบกิจกรรมไม่สำเร็จ';
    }
    header('Location: /myCreateEvent');
    exit();
}
