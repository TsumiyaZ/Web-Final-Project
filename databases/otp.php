<?php

function generateAndSaveOtp($join_id) {
    $conn = getConnection();

    date_default_timezone_set('Asia/Bangkok');

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