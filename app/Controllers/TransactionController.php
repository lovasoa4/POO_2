<?php

namespace App\Controllers;

use App\Models\Transaction;

class TransactionController
{
    // Afficher le formulaire
    public function formTransaction()
    {
        $this->view('Ajout_Transaction');
    }

    // Ajouter une transaction
    public function ajout()
    {
        if (!isset($_SESSION['id'])) {
            echo "<script>
            alert('Veuillez vous connecter avant d’ajouter une transaction.');
            window.location.href = '/login';
        </script>";
            return;
        }

        if (
            !empty($_POST["description"]) &&
            !empty($_POST["type"]) &&
            !empty($_POST["montant"]) &&
            !empty($_POST["date_transaction"])
        ) {

            $description      = trim($_POST["description"]);
            $type             = ucfirst(strtolower($_POST["type"])); // Crédit ou Débit
            $montant          = floatval($_POST["montant"]);
            $date_transaction = $_POST["date_transaction"];
            $id_user          = $_SESSION["id"];

            // Ajout + déclenchement Observer si Débit
            $success = Transaction::create_transaction($type, $date_transaction, $montant, $description, $id_user);

            if ($success) {
                echo "<script>
                alert('Transaction ajoutée avec succès !');
                window.location.href = '/dashboard';
            </script>";
                exit;
            } else {
                echo "<script>
                alert('Erreur lors de l’ajout de la transaction.');
                window.location.href = '/dashboard';
            </script>";
                exit;
            }
        } else {
            echo "<script>
            alert('Veuillez remplir tous les champs.');
            window.history.back();
        </script>";
        }
    }

    // Affichage des transactions utilisateur
    public function afficher()
    {
        if (!isset($_SESSION['id'])) {
            echo "<script>alert('Veuillez vous connecter pour voir vos transactions.');</script>";
            return;
        }

        $userId = $_SESSION['id'];
        $transactions = Transaction::selectAllData($userId);

        $this->view('transaction', ['tableau' => $transactions]);
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
                echo "<script>alert('Erreur lors de la suppression.');</script>";
            }
        }
    }

    // Méthode pour afficher une vue
    private function view($viewName, $data = [])
    {
        extract($data);
        $viewPath = APP . '/Views/' . $viewName . '.php';
        if (file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Vue {$viewName} introuvable");
        }
    }
    public function afficherDebit()
    {
        if (!isset($_SESSION['id'])) {
            echo "<script>alert('Veuillez vous connecter pour voir vos transactions.');</script>";
            return;
        }

        $userId = $_SESSION['id'];
        $search = $_GET['search'] ?? '';
        $debits = Transaction::getDebit($userId, $search);
        $this->view('transaction', ['tableau' => $debits]);
    }

    public function afficherCredit()
    {
        if (!isset($_SESSION['id'])) {
            echo "<script>alert('Veuillez vous connecter pour voir vos transactions.');</script>";
            return;
        }

        $userId = $_SESSION['id'];
        $search = $_GET['search'] ?? '';
        $credits = Transaction::getCredit($userId, $search);
        $this->view('transaction', ['tableau' => $credits]);
    }
}
