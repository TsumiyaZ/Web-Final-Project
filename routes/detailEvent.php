<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
} else {
    $event_id = $_GET['event_id'] ?? null;
    if (!$event_id) {
        header('Location: /home');
        exit();
    }
    $event = getEventByEventIdForDetail($event_id);
    if (!$event) {
        header('Location: /home');
        exit();
    }
    renderView('detailEvent', ['event_id' => $event_id, 'event' => $event]);
}
