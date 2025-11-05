<?php
// public/index.php

// Définir les chemins racine
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('CORE', ROOT . '/core');

// Charger l'autoloader (adapte selon ton autoloader)
require_once CORE . '/Autoloader.php';
Core\Autoloader::register();

// Démarrer la session UNE SEULE FOIS
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Créer le router
$router = new Core\Router();

// ==========================
// Définition des routes
// ==========================

// --- Routes utilisateur ---
$router->get('/', 'UserController@index');
$router->get('/login', 'UserController@index');
$router->post('/login', 'UserController@Connection');

$router->get('/createUser', 'UserController@createUser');
$router->post('/createUser', 'UserController@insertion');

$router->get('/dashboard', 'UserController@dashboard');
$router->get('/dashboard1', 'UserController@dashboard');
$router->get('/logout', 'UserController@logout');

// --- Routes transaction ---
$router->get('/afficher', 'TransactionController@afficher');
$router->get('/ajout', 'TransactionController@formTransaction');
$router->post('/ajout_Transaction', 'TransactionController@ajout');
$router->post('/recherche', 'TransactionController@recherche');
$router->get('/transaction_Credit', 'TransactionController@afficherCredit');
$router->get('/transaction_Debit', 'TransactionController@afficherDebit');
$router->post('/delete', 'TransactionController@delete');

// Exécuter le router
$router->run();
