<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

$event_id = $_POST['event_id'] ?? $_GET['event_id'] ?? 0;
$user_id = $_POST['user_id'] ?? $_SESSION['user']['user_id'] ?? 0;

$event = getEventByEventId($event_id, $user_id);

if ($event) {
    $data = [
        'event'           => $event,
        'allMember'       => getAllJoinMember($event_id),
        'approvedMember'  => getAllApprovedByEventId($event_id),
        'rejectedMember'  => getAllRejectedByEventId($event_id),
        'pendingMember'   => getAllPendingByEventId($event_id),
        'isUsed_1_Member' => getAllIs_used_1_ByEventId($event_id),
        'genderStats'     => getGenderStatsByEventId($event_id),
        'ageStats'        => getAgeStatsByEventId($event_id)
    ];

    renderView('/manageEvent', $data);
} else {
    header('Location: ' . ($event_id ? '/myCreateEvent' : '/home'));
    exit();
}