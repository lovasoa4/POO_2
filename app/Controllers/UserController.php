<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Transaction;

/**
 * CONTRÔLEUR USER
 * ===============
 * Gère la logique métier et fait le lien entre Modèle et Vue
 */
class UserController
{
    private $userModel;
    private $transactionModel;
    
    public function __construct()
    {
        $this->userModel = new User();
        $this->transactionModel = new Transaction();
    }
    
    /**
     * Afficher la liste des utilisateurs
     */
    public function index()
    {
        $users = $this->userModel->getAll();
        $this->view('list', ['users' => $users,'harena'=> 'Cousine Nay']);
    }

    public function testAffiche(){
        die("Henintsoa seth");
    }

    
    
    /**
     * Afficher le formulaire
     */
    public function form()
    {
        $this->view('form',['vola'=>'1 tapoitrisa AR']);
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

    public function store(){
        var_dump($_POST);
        die("Amiele");
    }


////////
    public function transactions()
    {
        $message = $this->transactionModel->getMessage();

        // Envoie la donnée à la vue
        $this->view('transactions', [
            'message' => $message
        ]);
    }



}