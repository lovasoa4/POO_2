<?php
// ============================================
// 1. public/index.php (Point d'entrée principal)
// ============================================

// Définir les chemins racine
define('ROOT', dirname(__DIR__));
define('APP', ROOT . '/app');
define('CORE', ROOT . '/core');

// Charger l'autoloader
require_once CORE . '/Autoloader.php';
Core\Autoloader::register();

// Démarrer la session
session_start();

// Créer le router
$router = new Core\Router();

// ==========================
// Définition des routes
// ==========================

// --- Routes utilisateur ---
$router->get('/', 'UserController@index');
$router->get('/users', 'UserController@index');
$router->get('/users/form', 'UserController@form');
$router->get('/createUser', 'UserController@createUser');
$router->post('/createUser', 'UserController@insertion');
$router->post('/login', 'UserController@Connection');

// --- Routes transaction ---
$router->get('/afficher', 'TransactionController@afficher');
$router->get('/ajout', 'TransactionController@formTransaction');
$router->post('/ajout_Transaction', 'TransactionController@ajout');
$router->post('/recherche', 'TransactionController@recherche');
$router->get('/transaction_Credit', 'TransactionController@afficherCredit');
$router->get('/transaction_Debit', 'TransactionController@afficherDebit');
$router->get('/delete', 'TransactionController@delete');

// --- Dashboard ---
$router->get('/dashboard', 'DashboardController@getAllDataDashboard');
$router->get('/dashboard1', 'UserController@dashboard');

// Exécuter le router
$router->run();
