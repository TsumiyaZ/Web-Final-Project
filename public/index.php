<?php
session_start();

const DATABASE_DIR_  = __DIR__ . '/../databases/';
const INCLUDES_DIR_ = __DIR__ . '/../includes/';
const VIEWS_DIR_    = __DIR__ . '/../views/';
const ROUTES_DIR_   = __DIR__ . '/../routes/';

require_once INCLUDES_DIR_ . 'router.php';
require_once INCLUDES_DIR_ . 'views.php';
require_once INCLUDES_DIR_ . 'database.php';

const PUBLIC_ROUTES = ['/', '/home', '/login', '/register', '/logout'];
$requestUri = strtok($_SERVER['REQUEST_URI'], '?');

$isPublicRoute = in_array($requestUri, PUBLIC_ROUTES);

if (isset($_SESSION['timestamp']) && (time() - $_SESSION['timestamp'] > 3600)) {
    session_destroy();
    header('Location: /');
    exit();
}

if (isset($_SESSION['user'])) {
    $_SESSION['timestamp'] = time();
}

if ($isPublicRoute || isset($_SESSION['user'])) {
    dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
} else {
    header('Location: /');
    exit();
}
