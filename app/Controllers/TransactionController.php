<?php

namespace App\Controllers;

use App\Models\Transaction;
use App\Models\Model_dashboard;



class TransactionController
{
    //  Ajouter une transaction
    public function formTransaction()
    {
        $this->view('Ajout_Transaction');
    }

    public function ajout()
    {
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
                echo "<script>alert('Transaction ajoutée avec succès ! Un email a été envoyé.');</script>";
            } else {
                echo "<script>alert('Erreur lors de l’ajout de la transaction.');</script>";
            }

            // Recharge les données du tableau
            $vars = Transaction::selectAllData($_SESSION["id"]);
            $tabData = [];

            foreach ($vars as $var) {
                $elements = new Model_dashboard($var['debit'], $var['credit'], $var['mois'], $var['annee'], $var['id_user']);
                $tabData[] = $elements;
            }

            $this->view("dashboard", ["tabData" => $tabData]);
        }
    }
    //Affichage de tous les transaction
 public function afficher()
{
    $transactions = Transaction::select_all_with_credit_debit();
    $tableau = [];

    foreach ($transactions as $trans) {
        $tableau[] = $trans;
     

    }

    $this->view('transaction', ['tableau' => $tableau]);
}


    // Supprimer une transaction
    public function delete()
    {
        if (!empty($_POST["id_delete"])) {
            $id = $_POST["id_delete"];
            $success = Transaction::delete_transaction($id);

            if ($success) {
                echo "<script>alert('Transaction supprimée avec succès !');</script>";
            } else {
                echo "<script>alert('Erreur lors de la suppression de la transaction.');</script>";
            }
            header("location:../view/ListeTransaction.php");
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

    public function recherche()
    {
        if (isset($_POST['date']) && !empty($_POST['date'])) {
            $date = $_POST['date'];
            $tableau = Transaction::select_by_date($date);
        } else {
            $tableau = Transaction::select_transaction();
        }

        $this->view('transaction', ['tableau' => $tableau]);
    }


    ////   // Afficher uniquement les Crédits avec recherche

    public function afficherCredit()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : "";
        $transactions = Transaction::getCredit($search);
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

        $this->view('transaction_credit', [
            'tableau' => $tableau,
            'search' => $search
        ]);
    }
    // Afficher uniquement les Débits avec recherche
    public function afficherDebit()
    {
        $search = isset($_GET['search']) ? trim($_GET['search']) : "";
        $transactions = Transaction::getDebit($search);
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

        $this->view('transaction_debit', [
            'tableau' => $tableau,
            'search' => $search
        ]);
    }
}
