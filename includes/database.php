<?php

$host = 'eventeiei.k1god.com';
$db = 'k1god_eventEiEi';
$user = 'k1god_eventEiEi';
$pass = '$UR823~gLyjfxeih';

$con = new mysqli($host, $user, $pass, $db);

function getConnection() {
    global $con;
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    return $con;
}

require_once DATABASE_DIR_ . 'user.php';
require_once DATABASE_DIR_ . 'imgEvent.php';
require_once DATABASE_DIR_ . 'events.php';
require_once DATABASE_DIR_ . 'joinEvent.php';
require_once DATABASE_DIR_ . 'otp.php';