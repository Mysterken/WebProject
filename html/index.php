<?php

use Html\Controller\FrontController;

require_once './config/config.php';
require_once '../vendor/autoload.php';

$request = str_replace('?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI']) ;
var_dump($_GET['id']);

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
    case '/posts' :
        $controller = new FrontController('index');
        break;
    case '/post':
        $id = 1;
        $controller = new FrontController('show', ['id' => $_GET['id']]);
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}