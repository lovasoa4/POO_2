<?php

namespace App\Controllers;

use core\Database;
use PDO;
use PDOException;
use App\Models\User;
//use App\Models\Transaction;


/**
 * CONTRÔLEUR USER
 * ===============
 * Gère la logique métier et fait le lien entre Modèle et Vue
 */
class UserController
{
    private $userModel;


    public function __construct() {}

    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        $this->view('login');
    }



    /**
     * Afficher le formulaire
     */
    public function form()
    {
        $this->view('form');
    }

    public function createUser()
    {
        $this->view('createUser');
    }

    public function dashboard()
    {
        $this->view('dashboard');
    }


    /**
     * Charger une vue
     */
    private function view($viewName, $data = [])
    {
        // Extraire les données pour les rendre accessibles dans la vue
        extract($data);

        // Charger la vue
        $viewPath = APP . '/Views/' . $viewName . '.php';

        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Vue {$viewName} introuvable");
        }
    }

    public function store()
    {
        var_dump($_POST);
    }

    /////////////////////////////////////////////////

    public function css($filename)
    {
        $path = ROOT . '/public/assets/css/' . basename($filename);

        if (file_exists($path)) {
            header('Content-Type: text/css');
            readfile($path);
            exit;
        } else {
            http_response_code(404);
            echo "Fichier CSS introuvable";
        }
    }

        public function Connection()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["email"]) && !empty($_POST["mdp"])) {
            $email = $_POST["email"];
            $mdp = $_POST["mdp"];
            User::se_connecter($email, $mdp);
            header("location: /dashboard");
        } else {
            echo "non reussit ";
        }
    }
    $this->view("dashboard");
    }
    

    public function insertion()
    {
        if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["mdp"])) {
            $nom = $_POST["nom"];
            $email = $_POST["email"];
            $mdp = $_POST["mdp"];
            User::create_User($nom, $email, $mdp);
            header("location: /login");
        } else {
            echo "non reussit ";
        }
    }
    $this->view("login");
    }
}
