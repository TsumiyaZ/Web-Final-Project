<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}


if (isset($_SESSION['user'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nameEvent = $_POST['nameEvent'] ?? '';
        $startDate = $_POST['startDate'] ?? '';
        $stopDate = $_POST['stopDate'] ?? '';
        $description = $_POST['description'] ?? '';
        $amount = (int)$_POST['amount'] ?? '';
        
        
        if (!empty($_FILES['picture']['name'][0])) {
            $createEvent = createEvent($_SESSION['user']['user_id'], $nameEvent, $startDate, $stopDate, $description, $amount);
            foreach ($_FILES['picture']['name'] as $index => $files) {
                $tmp_name = $_FILES['picture']['tmp_name'][$index];
                $error = $_FILES['picture']['error'][$index];

                if ($error == 0) {
                    $newPath = time() . '_' . $files;
                    $path = 'uploads/' . $newPath;
                }

                if (move_uploaded_file($tmp_name, $path)) {
                    uploadImg($createEvent, $path);
                }
            }
            $_SESSION['success'] = 'สร้าง event เสร็จเเล้วโบร๋';
        } else {
            $_SESSION['error'] = 'ใส่รูปด้วยไอสัส';
        }
    }
    
}
renderView('/createEvent');