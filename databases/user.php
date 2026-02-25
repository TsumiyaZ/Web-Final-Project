<?php 

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

