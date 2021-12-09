<?php

require_once './config/config.php';
require_once '../../vendor/autoload.php';

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '':
    case '/' :
        require __DIR__ . '/views/homepage.php';
        break;
    case '/register' :
        require __DIR__ . '/views/register.php';
        break;
    case '/test' :
        require __DIR__ . '/views/test.html';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}