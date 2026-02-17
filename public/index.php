<?php
session_start();

const DATABASE_DIR_  = __DIR__ . '/../databases/';
const INCLUDES_DIR_ = __DIR__ . '/../includes/';
const VIEWS_DIR_    = __DIR__ . '/../views/';
const ROUTES_DIR_   = __DIR__ . '/../routes/';

require_once INCLUDES_DIR_ . 'router.php';
require_once INCLUDES_DIR_ . 'views.php';
require_once INCLUDES_DIR_ . 'database.php';

dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
