<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
} 

$event_id = $_POST['event_id'] ?? '';
$event = getEventByEventId($event_id);

renderView('/myCreateEvent', ['event' => $event]);
