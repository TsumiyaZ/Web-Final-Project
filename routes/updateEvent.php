<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

$event_name = $_POST['eventName'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$stopDate = $_POST['stopDate'] ?? '';
$description = $_POST['description'] ?? '';
$amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
$event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;

if ($event_id <= 0) {
    $_SESSION['error'] = 'ไม่พบรหัสกิจกรรม';
    header('Location: /myCreateEvent');
    exit();
}

if (updateEventByEventId($event_name, $startDate, $stopDate, $description, $amount, $event_id)) {
    $_SESSION['success'] = 'อัพเดทข้อมูลเสร็จ';
    header('Location: /myCreateEvent');
    exit();
} else {
    $_SESSION['error'] = 'อัพเดทข้อมูลไม่สําเร็จ';
    header('Location: /myCreateEvent');
    exit();
}

