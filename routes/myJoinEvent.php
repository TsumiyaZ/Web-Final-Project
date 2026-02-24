<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

$keyword = '';
$allEvent = [];
$startDate = '';
$stopDate = '';

if (isset($_GET['search']) || isset($_GET['start_date']) || isset($_GET['stop_date'])) {
    $startDate = $_GET['start_date'] ?? '';
    $stopDate = $_GET['stop_date'] ?? '';
    $keyword = $_GET['search'] ?? '';
    $allEvent = searchAllMyJoinEvent($_SESSION['user']['user_id'], $keyword, $startDate, $stopDate);
} else {
    $allEvent = getJoinedEventsByUserId($_SESSION['user']['user_id']);
}

renderView('/myJoinEvent', [
    'keyword' => $keyword,
    'allEvent' => $allEvent,
    'start_date' => $startDate,
    'stop_date' => $stopDate
]);