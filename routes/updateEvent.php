<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

$event_name = $_POST['eventName'] ?? '';
$startDate = $_POST['startDate'] ?? '';
$stopDate = $_POST['stopDate'] ?? '';
$description = $_POST['description'] ?? '';
$amount = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;
$event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;

if ($event_id <= 0) {
    $_SESSION['error'] = 'ไม่พบรหัสกิจกรรม';
    header('Location: /myCreateEvent');
    exit();
}

$updateEvent1 = updateEventByEventId($event_name, $startDate, $stopDate, $description, $amount, $event_id);
$updateImg = false;
$deleImg = false;

if (!empty($_POST['deleteImages'])) {
    $deleteIds = explode(',', $_POST['deleteImages']);

    foreach ($deleteIds as $imgId) {
        if (!empty($imgId)) {
            deleteImgByImgId($imgId);
            $deleImg = true;
        }
    }
}

if (!empty($_FILES['picture']['name'][0])) {

    foreach ($_FILES['picture']['name'] as $index => $fileName) {

        if ($fileName == '') {
            continue;
        }

        $tmp_name = $_FILES['picture']['tmp_name'][$index];
        $error    = $_FILES['picture']['error'][$index];
        $fileSize = $_FILES['picture']['size'][$index];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($error !== 0) {
            continue;
        }

        if (!in_array($fileType, ['png', 'jpg', 'jpeg'])) {
            continue;
        }

        if ($fileSize > 2 * 1024 * 1024) {
            continue;
        }

        $newName = uniqid() . '_' . $fileName;
        $path    = 'uploads/' . $newName;

        if (move_uploaded_file($tmp_name, $path)) {
            uploadImg($event_id, $path);
            $updateImg = true;
        }
    }
}

if ($updateEvent1 || $updateImg || $deleImg) {
    $_SESSION['success'] = 'อัพเดทข้อมูลเสร็จ';
    header('Location: /myCreateEvent');
    exit();
} else {
    $_SESSION['error'] = 'อัพเดทข้อมูลไม่สําเร็จ';
    header('Location: /myCreateEvent');
    exit();
}
