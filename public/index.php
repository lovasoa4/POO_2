<?php

// ============================================
// 1. public/index.php (Point d'entrée)
// ============================================

// Définir les chemins racine
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('CORE', ROOT . '/core');

// Charger l'autoloader
require_once CORE . '/Autoloader.php';

// Enregistrer l'autoloader
Core\Autoloader::register();


// Démarrer la session
session_start();

// Créer le router
$router = new Core\Router();

// Définir les routes
$router->get('/', 'UserController@index');
$router->get('/users', 'UserController@index');
$router->get('/users/form', 'UserController@form');
$router->get('/affiche', 'UserController@testAffiche');
$router->get('/createUser', 'UserController@createUser');
$router->get('/dashboard','UserController@dashboard');


$router->get('/afficher', 'TransactionController@afficher');
$router->get('/ajout', 'TransactionController@formTransaction');
$router->get('/delete', 'TransactionController@delete');
$router->post('/users/store', 'UserController@store');

$router->post('/ajout_Transaction', 'TransactionController@ajout');
// $router->post('/users/delete', 'UserController@delete');

// Exécuter le router
$router->run();