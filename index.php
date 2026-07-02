<?php

session_start();

require "vendor/autoload.php";

$router = new Router();
$router->handleRequest();