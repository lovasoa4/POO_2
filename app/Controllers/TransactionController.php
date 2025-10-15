<?php
namespace App\Controllers;
use App\Models\Transaction;


class TransactionController
{   
        //  Ajouter une transaction
        public function formTransaction(){
             $this->view('Ajout_Transaction');
        }
    public function ajout() {
        if (

            !empty($_POST["description"]) &&
            !empty($_POST["type"]) &&
            !empty($_POST["montant"]) &&
            !empty($_POST["date_transaction"]) &&
            !empty($_POST["id_user"])
        ) {
            $description = $_POST["description"];
            $type = $_POST["type"];
            $montant = $_POST["montant"];
            $date_transaction = $_POST["date_transaction"];
            $id_user = $_POST["id_user"];

            $success = Transaction::create_transaction($type, $date_transaction, $montant, $description, $id_user);
            if ($success) {
                echo " <script>alert('Transaction ajoutée avec succès !');</script>";
            } else {
                echo " <script>alert('Erreur lors de l'ajout de la transaction.');</script>";
            }

            // Redirection après ajout
            $this->view('dashboard');
            exit;
        }
    }
    //Affichage de tous les transaction
    public function afficher()
    {
       
        $transactions = Transaction::select_transaction();
        $tableau = [];

        foreach ($transactions as $trans) {
            $tableau[] = new Transaction(
                $trans['id'],
                $trans['type'],
                $trans['date_transaction'],
                $trans['montant'],
                $trans['description'],
                $trans['id_user']
            );
        }
              include(ROOT . '/app/Views/transaction.php');

    }

        // Supprimer une transaction
    public function delete() {
        if (!empty($_POST["id_delete"])) {
            $id = $_POST["id_delete"];
            $success = Transaction::delete_transaction($id);

            if ($success) {
                echo "<script>alert('Transaction supprimée avec succès !');</script>";
            } else {
                echo "<script>alert('Erreur lors de la suppression de la transaction.');</script>";
            }
                header("location:../view/ListeTransaction.php") ;
            exit;
        }
    }

    //view 
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
}
