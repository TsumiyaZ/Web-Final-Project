<?php

$host = 'localhost';
$db = 'enrollment';
$user = 'demo';
$pass = 'abc123';

$con = new mysqli($host, $user, $pass, $db);

function getConnection() {
    global $con;
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    return $con;
}