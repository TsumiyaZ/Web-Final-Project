<?php

function joinEvent($event_id, $user_id) {
    $conn = getConnection();
    $sql = 'INSERT INTO event_join (user_id, event_id) VALUES (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}