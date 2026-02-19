<?php 

function uploadImg($event_id, $path) {
    $conn = getConnection();
    $sql = 'insert into event_imgs (event_id, img_path) values (?, ?)';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('is', $event_id, $path);
    $stmt->execute();

    return $stmt->affected_rows > 0;
}

function getImgById($event_id) {
    $conn = getConnection();
    $sql = 'select * from event_imgs where event_id = ?';
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $event_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}