<?php
namespace App\Controllers;

class Fonction{

    protected function view($viewName, $data = [])
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


    public function index(){
        $this->view('login',['erreur' => '']);
    }

    public function createUser(){
        $this->view('createUser');
    }

    
    public function dashboard(){
        $this->view('view_dashboard');
    }
    
   public function transaction(){
        $this->view('view_transaction');
    } 

     public function createTransaction(){
        $this->view('createTransaction');
    }
    
}
?>