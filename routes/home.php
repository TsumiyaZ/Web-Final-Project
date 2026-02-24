<?php

$keyword = '';
$allEvent = [];
$startDate = '';
$stopDate = '';

if (isset($_GET['search']) || isset($_GET['start_date']) || isset($_GET['stop_date'])) {
    $keyword = $_GET['search'];
    $startDate = $_GET['start_date'];
    $stopDate = $_GET['stop_date'];
    $allEvent = getEventByKeyword($keyword, $startDate, $stopDate);
} else {
    $allEvent = getAllEvents();
}

renderView('home', ['keyword' => $keyword, 'allEvent' => $allEvent, 'start_date' => $startDate, 'stop_date' => $stopDate]);