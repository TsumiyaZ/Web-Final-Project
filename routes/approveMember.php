<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $event_id = $_POST['event_id'];

    // Check if user is event creator
    $event = getEventByEventId($event_id, $_SESSION['user']['user_id']);
    
    if ($event && $event['creator_id'] == $_SESSION['user']['user_id']) {
        $result = approveMember($event_id, $user_id);
        if ($result) {
            $_SESSION['success'] = 'อนุมัติผู้ใช้สำเร็จแล้ว';
        } else {
            $_SESSION['error'] = 'ไม่สามารถอนุมัติผู้ใช้ได้';
        }
        
        // PRG Pattern: Redirect with GET to prevent duplicate form submission
        header('Location: /manageEvent?event_id=' . $event_id);
        exit();
    } else {
        $_SESSION['error'] = 'คุณไม่มีสิทธิ์อนุมัติผู้ใช้ในกิจกรรมนี้';
        header('Location: /manageEvent?event_id=' . $event_id);
        exit();
    }
} else {
    // If not POST, redirect to avoid direct access to this route
    header('Location: /home');
    exit();
}
