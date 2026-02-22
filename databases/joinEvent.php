<?php

function joinEvent($event_id, $user_id) {
    $conn = getConnection();
    $sql = 'INSERT INTO event_join (user_id, event_id) VALUES (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

function getJoinedEventsByUserId($user_id) {
    $conn = getConnection();
    $sql = 'SELECT events.* FROM events 
            JOIN event_join ON events.event_id = event_join.event_id 
            WHERE event_join.user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}