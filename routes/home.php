<?php

if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
} else {
    renderView('home');
}
