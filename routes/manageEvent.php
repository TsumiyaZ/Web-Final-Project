<?php

if (!isset($_SESSION['user'])) {
    header('Location: /home');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $event_id = $_POST['event_id'];
    $user_id = $_POST['user_id'];

    $event = getEventByEventId($event_id, $user_id);
    
    if (!$event) {
        header('Location: /myCreateEvent');
        exit();
    }
    
    $allMember = getAllJoinMember($event_id);
    $approvedMember = getAllApprovedByEventId($event_id);
    $rejectedMember = getAllRejectedByEventId($event_id);
    $pendingMember = getAllPendingByEventId($event_id);

    renderView('/manageEvent', ['event' => $event, 'allMember' => $allMember, 'approvedMember' => $approvedMember, 'rejectedMember' => $rejectedMember, 'pendingMember' => $pendingMember]);
    
} else {
    $event_id = $_GET['event_id'] ?? 0;
    $user_id = $_SESSION['user']['user_id'] ?? 0;
    
    if ($event_id) {
        $event = getEventByEventId($event_id, $user_id);
        
        if ($event) {
            $allMember = getAllJoinMember($event_id);
            $approvedMember = getAllApprovedByEventId($event_id);
            $rejectedMember = getAllRejectedByEventId($event_id);
            $pendingMember = getAllPendingByEventId($event_id);

            renderView('/manageEvent', ['event' => $event, 'allMember' => $allMember, 'approvedMember' => $approvedMember, 'rejectedMember' => $rejectedMember, 'pendingMember' => $pendingMember]);
        } else {
            header('Location: /myCreateEvent');
            exit();
        }
    } else {
        header('Location: /home');
        exit();
    }
}