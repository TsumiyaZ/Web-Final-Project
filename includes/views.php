<?php

function renderView($view, $data = []) {
    include VIEWS_DIR_ . $view . '.php';
}