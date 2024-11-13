<?php

use App\Router\Route;
use App\Controller\MediaController;
use App\Controller\AuthController;

// Création de l'instance du Router
$router = new App\Router\Router();

// Liste des routes

$router->addRoute(new Route('/', AuthController::class, 'loginPage'));
$router->addRoute(new Route('/login', AuthController::class, 'login'));
$router->addRoute(new Route('/logout', AuthController::class, 'logout'));
$router->addRoute(new Route('/dashboard', MediaController::class, 'index'));

$router->addRoute(new Route('/media/add', MediaController::class, 'addMedia'));
$router->addRoute(new Route('/media/save', MediaController::class, 'saveMedia', "POST"));
$router->addRoute(new Route('/media/edit/{id}', MediaController::class, 'edit'));
$router->addRoute(new Route('/media/update', MediaController::class, 'update', 'POST'));
$router->addRoute(new Route('/media/delete/{id}', MediaController::class, 'delete', 'POST'));
$router->addRoute(new Route('/media/search', MediaController::class, 'search'));
$router->addRoute(new Route('/media/details', MediaController::class, 'details'));
$router->addRoute(new Route('/media/toggleAvailability', MediaController::class, 'toggleAvailability', 'POST'));

return $router;
