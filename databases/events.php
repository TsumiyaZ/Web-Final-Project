<?php

function createEvent($user_id, $nameEvent, $startDate, $stopDate, $description, $amount) {
    $conn = getConnection();
    $sql = 'insert into events (creator_id, event_name, start_date, stop_date, description, amount) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issssi', $user_id, $nameEvent, $startDate, $stopDate, $description, $amount);
    $stmt->execute();

    return (int)$conn->insert_id;
}

function getAllEvents() {
    $conn = getConnection();
    $sql = 'select * from events';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}