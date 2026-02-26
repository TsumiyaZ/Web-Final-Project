<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nameEvent   = $_POST['nameEvent'] ?? '';
    $startDate   = $_POST['startDate'] ?? '';
    $stopDate    = $_POST['stopDate'] ?? '';
    $description = $_POST['description'] ?? '';
    $amount      = isset($_POST['amount']) ? (int)$_POST['amount'] : 0;

    // Validate date range
    if (strtotime($startDate) >= strtotime($stopDate)) {
        $_SESSION['error'] = 'วันที่สิ้นสุดกิจกรรมต้องมากกว่าวันที่เริ่มกิจกรรม';
        header('Location: /createEvent');
        exit();
    }

    if (!empty($_FILES['picture']['name'][0])) {

        $event_id = createEvent(
            $_SESSION['user']['user_id'],
            $nameEvent,
            $startDate,
            $stopDate,
            $description,
            $amount
        );

        foreach ($_FILES['picture']['name'] as $index => $fileName) {

            $tmp_name = $_FILES['picture']['tmp_name'][$index];
            $error    = $_FILES['picture']['error'][$index];
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if ($error === 0) { 
                if (!in_array($fileType, ['png', 'jpg', 'jpeg'])) {
                    continue;
                }

                $newName = uniqid() . '_' . $fileName;
                $path    = 'uploads/' . $newName;

                if (move_uploaded_file($tmp_name, $path)) {
                    uploadImg($event_id, $path);
                }
            }
        }

        $_SESSION['success'] = 'สร้าง event เสร็จแล้ว';
        $_POST = [];

        header('Location: /myCreateEvent');
        exit();

    } else {
        $_SESSION['error'] = 'กรุณาใส่รูปอย่างน้อย 1 รูป';
        header('Location: /myCreateEvent');
        exit();
    }
}

renderView('/CreateEvent');