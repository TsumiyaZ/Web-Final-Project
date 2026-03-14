<?php

function createEvent($user_id, $nameEvent, $startDate, $stopDate, $description, $amount)
{
    $conn = getConnection();
    $sql = 'insert into events (creator_id, event_name, start_date, stop_date, description, amount) VALUES (?, ?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('issssi', $user_id, $nameEvent, $startDate, $stopDate, $description, $amount);
    $stmt->execute();

    return (int)$conn->insert_id;
}

function getAllEvents()
{
    $conn = getConnection();
    $sql = 'select * from events';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}   

function getAllYourEventByUserId($user_id)
{
    $conn = getConnection();
    $sql = 'select events.* from events 
            JOIN users ON events.creator_id = users.user_id 
            where events.creator_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getEventByEventId($event_id, $user_id)
{
    $conn = getConnection();
    $sql = 'select * from events where event_id = ? and creator_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $event_id, $user_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

function getEventByEventIdForDetail($event_id)
{
    $conn = getConnection();
    $sql = 'select * from events where event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_assoc();
}

function updateEventByEventId($name_event, $startDate, $stopDate, $description, $amount, $event_id)
{
    $conn = getConnection();
    $sql = 'update events 
            set event_name = ?,
            start_date = ?,
            stop_date = ?,
            description = ?,
            amount = ?
            where event_id = ?';
            
    $stmt = $conn->prepare($sql);

    $startDate = !empty(trim($startDate)) ? $startDate : null;
    $stopDate = !empty(trim($stopDate)) ? $stopDate : null;

    $stmt->bind_param('ssssii', $name_event, $startDate, $stopDate, $description, $amount, $event_id);
    
    $result = $stmt->execute();

    return $stmt->affected_rows > 0;
}

function deleteEvent($event_Id)
{
    $conn = getConnection();
    $sql = 'delete from events where event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_Id);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

function getEventByKeyword($keyword, $startDate, $stopDate)
{
    $conn = getConnection();
    $sql = '';

    if ($keyword != '' && $startDate != '' && $stopDate != '') {
        $sql = 'SELECT * FROM events WHERE event_name LIKE ? AND start_date BETWEEN ? AND ?';
        $stmt = $conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param('sss', $keyword, $startDate, $stopDate);
    } else if ($startDate != '' && $stopDate != '') {
        $sql = 'SELECT * FROM events WHERE start_date BETWEEN ? AND ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $startDate, $stopDate);
    } else if ($startDate != '') {
        $sql = 'SELECT * FROM events WHERE start_date >= ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $startDate);
    } else if ($stopDate != '') {
        $sql = 'SELECT * FROM events WHERE stop_date <= ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $stopDate);
    } else {
        $sql = 'SELECT * FROM events WHERE event_name LIKE ?';
        $stmt = $conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param('s', $keyword);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function searchAllYourEventByUserId($user_id, $keyword, $startDate, $stopDate)
{

    $conn = getConnection();
    $sql = '';

    if ($keyword != '' && $startDate != '' && $stopDate != '') {
        $sql = 'select events.* from events 
                JOIN users ON events.creator_id = users.user_id 
                where events.creator_id = ? and events.event_name like ? and events.start_date BETWEEN ? AND ?';
        $stmt = $conn->prepare($sql);
        $keyword = '%' . $keyword . '%';
        $stmt->bind_param('isss', $user_id, $keyword, $startDate, $stopDate);
    } else if ($startDate != '' && $stopDate != '') {
        $sql = 'select events.* from events 
                JOIN users ON events.creator_id = users.user_id 
                where events.creator_id = ? and events.start_date BETWEEN ? AND ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('iss', $user_id, $startDate, $stopDate);
    } else if ($startDate != '') {
        $sql = 'select events.* from events 
                JOIN users ON events.creator_id = users.user_id 
                where events.creator_id = ? and events.start_date >= ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $user_id, $startDate);
    } else if ($stopDate != '') {
        $sql = 'select events.* from events 
                JOIN users ON events.creator_id = users.user_id 
                where events.creator_id = ? and events.start_date <= ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('is', $user_id, $stopDate);
    } else {
        $sql = 'select events.* from events 
                JOIN users ON events.creator_id = users.user_id 
                where events.creator_id = ? and events.event_name like ?';
        $stmt = $conn->prepare($sql);
        $keyword = '%' . $keyword . '%';
        $stmt->bind_param('is', $user_id, $keyword);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getNameCreatorByEventId($event_id) {
    $conn = getConnection();
    $sql = 'select users.name from users
            join events on events.creator_id = users.user_id
            where events.event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function checkOwnerEventOnDetail($event_id, $user_id) {
    $conn = getConnection();
    $sql = 'select events.* from events 
            join users on events.creator_id = users.user_id
            where events.event_id = ? and events.creator_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $event_id, $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc() ? true : false;
}
