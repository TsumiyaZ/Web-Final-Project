<?php 

function getUserById($user_id) {
    $conn = getConnection();
    $sql = 'select * from users where user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function updateUserProfile($user_id, $name, $email) {
    $conn = getConnection();
    $sql = 'update users set name = ?, email = ? where user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssi', $name, $email, $user_id);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

function updateUserPassword($user_id, $password) {
    $conn = getConnection();
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = 'update users set password = ? where user_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $hashPassword, $user_id);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

function getUserByEmail($email) {
    $conn = getConnection();
    $sql = 'select * from users where email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function insertUser($name, $birthday, $email, $password, $gender) {
    $conn = getConnection();
    $hashPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = 'insert into users (name, birthday, email, password, gender) values (?, ?, ?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $name, $birthday, $email, $hashPassword, $gender);
    $stmt->execute();

    if ($stmt->affected_rows > 0 ) {
        return true;
    } else {
        return false;
    }
}

function checkEmailExists($email) {
    $conn = getConnection();
    $sql = 'select email from users where email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    
    return $stmt->get_result()->num_rows > 0;
}

function getAge($birthday) {
    if (!$birthday || $birthday == '0000-00-00') return '-';

    $today = new DateTime();
    $birthday = new DateTime($birthday);

    $diff = $today->diff($birthday);

    return $diff->y;
}

function getAllUserJoinedEvent($user_id) {
    $conn = getConnection();
    $sql = 'select count(*) as total from event_join 
            join otp on event_join.join_id = otp.join_id 
            where event_join.user_id = ? and otp.is_used = 1';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();
    
    return $result['total'];
}

