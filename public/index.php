<?php

require_once '../config/autoloader.php'; 
$router = require_once '../config/routes.php';

session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    echo $router->resolve();
} catch (Exception $e) {
    http_response_code(500); 
    echo 'Erreur : ' . $e->getMessage();
}
