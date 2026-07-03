<?php

require_once __DIR__ . '/../vendor/autoload.php';

define('ROOT_PATH', dirname(__DIR__));

session_start();

date_default_timezone_set('Europe/Paris');

$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
$dotenv->load();

$router = new Router();
$router->handleRequest();