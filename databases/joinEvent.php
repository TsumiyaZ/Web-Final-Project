<?php

function joinEvent($event_id, $user_id)
{
    $conn = getConnection();
    $sql = 'INSERT INTO event_join (user_id, event_id) VALUES (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

function getJoinedEventsByUserId($user_id)
{
    $conn = getConnection();
    $sql = 'SELECT events.* FROM events 
            JOIN event_join ON events.event_id = event_join.event_id 
            WHERE event_join.user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getAllJoinMember($event_id)
{
    $conn = getConnection();
    $sql = 'SELECT users.* FROM users 
        JOIN event_join ON users.user_id = event_join.user_id
        WHERE event_join.event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();

    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function approveMember($eventId, $userId)
{
    $conn = getConnection();
    $now = new DateTime();
    $approved_date = $now->format('Y-m-d H:i:s');
    $sql = 'UPDATE event_join 
            SET status = "approved", approved_date = ? 
            WHERE event_id = ? AND user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $approved_date, $eventId, $userId);
    $stmt->execute();
    $result = $stmt->affected_rows > 0;
    $stmt->close();

    return $result;
}

function rejectMember($eventId, $userId)
{
    $conn = getConnection();
    $sql = 'update event_join
            set status = "rejected"
            where event_id = ? and user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $eventId, $userId);
    $stmt->execute();
    $result = $stmt->affected_rows > 0;
    $stmt->close();

    return $result;
}

function getAllApprovedByEventId($eventId)
{
    $conn = getConnection();
    $sql = 'SELECT users.*, event_join.status 
            FROM users 
            JOIN event_join ON users.user_id = event_join.user_id
            LEFT JOIN otp ON event_join.join_id = otp.join_id AND otp.is_used = 1
            WHERE event_join.event_id = ? AND event_join.status = "approved" AND otp.join_id IS NULL';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $data ? $data : [];
}

function getAllRejectedByEventId($eventId)
{
    $conn = getConnection();
    $sql = 'SELECT users.*, event_join.status 
            FROM users 
            JOIN event_join ON users.user_id = event_join.user_id
            WHERE event_join.event_id = ? AND event_join.status = "rejected"';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $data ? $data : [];
}

function getAllPendingByEventId($eventId)
{
    $conn = getConnection();
    $sql = 'SELECT users.*, event_join.status 
            FROM users 
            JOIN event_join ON users.user_id = event_join.user_id
            WHERE event_join.event_id = ? AND event_join.status = "pending"';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();

    $result = $stmt->get_result();

    $data = $result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();

    return $data ? $data : [];
}

function countApprovedMember($eventId)
{
    $conn = getConnection();
    $sql = 'select count(*) as total from event_join where event_id = ? and status = "approved"';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['total'] ?? 0;
}

function countRejectedMember($eventId)
{
    $conn = getConnection();
    $sql = 'select count(*) as total from event_join where event_id = ? and status = "rejected"';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['total'] ?? 0;
}

function countPendingMember($eventId)
{
    $conn = getConnection();
    $sql = 'select count(*) as total from event_join where event_id = ? and status = "pending"';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['total'] ?? 0;
}

function countAllMemberByEventId($eventId)
{
    $pending = countPendingMember($eventId);
    $approved = countApprovedMember($eventId);
    $rejected = countRejectedMember($eventId);
    return $pending + $approved + $rejected;
}

function countAllCheckInMember($event_id) {
    $conn = getConnection();
    $sql = 'select count(*) as total from event_join join otp on event_join.join_id = otp.join_id where event_join.event_id = ? and otp.is_used = 1';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc()['total'] ?? 0;
}

function checkStatus($user_id, $event_id)
{
    $conn = getConnection();
    $sql = 'select status from event_join where user_id = ? and event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    $stmt->execute();

    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    return $result['status'] ?? 'null';
}

function searchAllMyJoinEvent($user_id, $keyword, $startDate, $stopDate)
{
    $conn = getConnection();
    $sql = '';

    if ($keyword != '' && $startDate != '' && $stopDate != '') {
        $sql = 'SELECT events.* FROM events 
        JOIN event_join ON events.event_id = event_join.event_id
        WHERE event_join.user_id = ? and events.event_name like ? and events.start_date BETWEEN ? and ?';
        $stmt = $conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param('ssss', $user_id, $keyword, $startDate, $stopDate);
    } else if ($startDate != '' && $stopDate != '') {
        $sql = 'SELECT events.* FROM events 
        JOIN event_join ON events.event_id = event_join.event_id
        WHERE event_join.user_id = ? and events.start_date BETWEEN ? and ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $user_id, $startDate, $stopDate);
    } else if ($startDate != '') {
        $sql = 'SELECT events.* FROM events 
        JOIN event_join ON events.event_id = event_join.event_id
        WHERE event_join.user_id = ? and events.start_date >= ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $user_id, $startDate);
    } else if ($stopDate != '') {
        $sql = 'SELECT events.* FROM events 
        JOIN event_join ON events.event_id = event_join.event_id
        WHERE event_join.user_id = ? and events.start_date <= ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ss', $user_id, $stopDate);
    } else {
        $sql = 'SELECT events.* FROM events 
        JOIN event_join ON events.event_id = event_join.event_id
        WHERE event_join.user_id = ? and events.event_name like ?';
        $stmt = $conn->prepare($sql);
        $keyword = "%$keyword%";
        $stmt->bind_param('ss', $user_id, $keyword);
    }

    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getJoinIdByEventId($event_id, $user_id) {
    $conn = getConnection();
    $sql = 'SELECT * FROM event_join WHERE user_id = ? AND event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $user_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    $stmt->close();
    return $result;
}

function getIsUsedByJoinId($join_id) {
    $conn = getConnection();
    $sql = 'select * from otp where join_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $join_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function checkExpireAt($expire_at) {
    $conn = getConnection();
    $sql = 'select * from otp where expire_at < ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $expire_at);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getAllIs_used_1_ByEventId($eventId){
    $conn = getConnection();
    $sql = 'select users.* from users 
            join event_join on users.user_id = event_join.user_id
            join otp on event_join.join_id = otp.join_id
            where event_join.event_id = ? and otp.is_used = 1';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

function getGenderStatsByEventId($eventId) {
    $conn = getConnection();
    $sql = 'SELECT users.gender, COUNT(*) as count 
            FROM users 
            JOIN event_join ON users.user_id = event_join.user_id 
            JOIN otp ON otp.join_id = event_join.join_id
            WHERE event_join.event_id = ? AND event_join.status = "approved" and otp.is_used = 1
            GROUP BY users.gender';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    $stats = ['male' => 0, 'female' => 0, 'other' => 0];
    while ($row = $result->fetch_assoc()) {
        if ($row['gender'] === 'male') $stats['male'] = $row['count'];
        else if ($row['gender'] === 'female') $stats['female'] = $row['count'];
        else $stats['other'] += $row['count'];
    }
    $stmt->close();
    return $stats;
}

function getAgeStatsByEventId($eventId) {
    $conn = getConnection();
    $sql = 'SELECT users.birthday 
            FROM users 
            JOIN event_join ON users.user_id = event_join.user_id 
            JOIN otp on otp.join_id = event_join.join_id
            WHERE event_join.event_id = ? AND event_join.status = "approved" AND otp.is_used = 1';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $eventId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $stats = ['not in' => 0, '18-25' => 0, '26-35' => 0, '36+' => 0];
    $today = new DateTime();
    
    while ($row = $result->fetch_assoc()) {
        $birthday = new DateTime(datetime: $row['birthday']);
        $age = $today->diff($birthday)->y;
        
        if ($age >= 18 && $age <= 25) $stats['18-25']++;
        else if ($age >= 26 && $age <= 35) $stats['26-35']++;
        else if ($age >= 36) $stats['36+']++;
        else $stats['not in']++;
    }
    $stmt->close();
    return $stats;
}

function isUsed_1($user_id, $event_id) {
    $conn = getConnection();
    $sql = 'select is_used from otp 
            join event_join on otp.join_id = event_join.join_id
            where event_join.event_id = ? and event_join.user_id = ? and otp.is_used = 1';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $event_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return ($row['is_used'] ?? 0 )== 1 ? true : false;
}

function cancelEvent($event_id, $user_id) {
    $conn = getConnection();
    $sql = 'delete from event_join where event_id = ? and user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ii', $event_id, $user_id);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}