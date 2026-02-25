<?php

function generateAndSaveOtp($join_id) {
    $conn = getConnection();

    date_default_timezone_set('Asia/Bangkok');

    $now = date('Y-m-d H:i:s');

    $sql = 'select otp_hash from otp where join_id = ? and expire_at > ? order by otp_id limit 1';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $join_id, $now);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    
    if ($row) {
        return $row['otp_hash'];
    }

    $random_number = random_int(0, 999999);
    $otp = str_pad($random_number, 6, '0', STR_PAD_LEFT);

    $expire_at = date('Y-m-d H:i:s', strtotime('+30 minutes'));

    $sql = 'INSERT INTO otp (join_id, otp_hash, expire_at) VALUES (?, ?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iss', $join_id, $otp, $expire_at);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        return $otp;
    } else {
        return false;
    }
}

function checkVerify($eventId, $otp) {
    $conn = getConnection();
    $sql = 'select * from otp 
            join event_join on otp.join_id = event_join.join_id 
            where event_join.event_id = ? and otp.otp_hash = ? and otp.is_used = 0';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $eventId, $otp);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();

    if ($row) {
        $sql = 'update otp set is_used = 1 where otp_hash = ?';
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('s', $otp);
        $stmt->execute();
        return true;
    } else {
        return false;
    }

}
