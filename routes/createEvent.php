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

            if ($error === 0) {

                $newName = uniqid() . '_' . $fileName;
                $path    = 'uploads/' . $newName;

                if (move_uploaded_file($tmp_name, $path)) {
                    uploadImg($event_id, $path);
                }
            }
        }

        $_SESSION['success'] = 'สร้าง event เสร็จแล้ว';
        $_POST = [];

        header('Location: /myEvent');
        exit();

    } else {
        $_SESSION['error'] = 'กรุณาใส่รูปอย่างน้อย 1 รูป';
        header('Location: /myEvent');
        exit();
    }
}

renderView('/createEvent');