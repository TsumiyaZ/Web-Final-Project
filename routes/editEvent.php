<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
} 

$event_id = $_POST['event_id'] ?? '';
$user_id = $_SESSION['user']['user_id'];
$event = getEventByEventId($event_id, $user_id);

if (!$event) {
    header('Location: /myCreateEvent');
    exit();
}

renderView('/editEvent', ['event' => $event]);
