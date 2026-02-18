<?php

const INDEX_HOME = 'home';
function normalizePath(string $path): string {
    $path = strtok($path, '?');
    $path = ltrim($path, '/');
    $path = rtrim($path, '/');      
    
    return $path === '' ? INDEX_HOME : $path;
}

function getPathSegments(string $path) {
    $path = normalizePath($path);
    return ROUTES_DIR_ . $path . '.php';
}

function dispatch(string $method, string $path) {
    $path = getPathSegments($path);
    if (file_exists($path)) {
        include $path;
    } else {
        http_response_code(404);
        echo '404 Not Founsdfsfdd';
    }
}