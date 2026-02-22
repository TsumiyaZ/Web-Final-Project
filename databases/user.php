<?php 

function getUserByEmail($email) {
    $conn = getConnection();
    $sql = 'select * from users where email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}



function checkEmailExists($email) {
    $conn = getConnection();
    $sql = 'select email from users where email = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    
    return $stmt->get_result()->num_rows > 0;
    
}