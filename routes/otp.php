<?php

if (!isset($_SESSION['user'])) {
    header("Location: /home");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $join_id = $_POST['join_id'];
    $otp = generateAndSaveOtp($join_id);
    header('Location: /myJoinEvent');
    exit();
} else {
    header('Location: /myJoinEvent');
    exit();
}
