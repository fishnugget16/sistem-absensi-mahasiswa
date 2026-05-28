<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once '../config/config.php';
require_once '../app/core/Database.php';
require_once '../app/core/Controller.php';
require_once '../app/models/User.php';

$url = isset($_GET['url']) ? $_GET['url'] : '';

if ($url === 'AuthController/registerForm') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->registerForm();
    exit;
}

if ($url === 'AuthController/register') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->register();
    exit;
}

if ($url === 'AuthController/login') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->login();
    exit;
}

if ($url === 'AuthController/logout') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->logout();
    exit;
}

if ($url === 'AuthController/dashboard') {
    require_once '../app/controllers/AuthController.php';
    $controller = new AuthController();
    $controller->dashboard();
    exit;
}

require_once '../app/controllers/AuthController.php';
$controller = new AuthController();
$controller->index();