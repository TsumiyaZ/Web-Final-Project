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

function getAllYourEventByUserId($user_id) {
    $conn = getConnection();
    $sql = 'select events.* from events 
            JOIN users ON events.creator_id = users.user_id 
            where events.creator_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getEventByEventId($event_id, $user_id) {
    $conn = getConnection();
    $sql = 'select * from events where event_id = ? and creator_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $event_id, $user_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

function getEventByEventIdForDetail($event_id) {
    $conn = getConnection();
    $sql = 'select * from events where event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

function updateEventByEventId($name_event, $startDate, $stopDate, $description, $amount, $event_id) {
    $conn = getConnection();
    $sql = 'update events 
            set event_name = ?,
            start_date = ?,
            stop_date = ?,
            description = ?,
            amount = ?
            where event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssii', $name_event, $startDate, $stopDate, $description, $amount, $event_id);
    $stmt->execute();

    return $stmt->affected_rows > 0;

}

function deleteEvent($event_Id) {
    $conn = getConnection();
    $sql = 'delete from events where event_id = ?';
    $stmt= $conn->prepare($sql);
    $stmt->bind_param('i', $event_Id);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}
