<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $user_id = $_POST['user_id'];

    cancelEvent($event_id, $user_id);
    
    header('Location: /myJoinEvent');
    exit();
} else {
    header('Location: /myJoinEvent');
    exit();
}
