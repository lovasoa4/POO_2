<?php

namespace App\Controllers;

use App\Models\Transaction;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once ROOT . '/vendor/autoload.php';

class TransactionController
{
    // Afficher le formulaire d'ajout
    public function formTransaction()
    {
        $this->view('Ajout_Transaction');
    }

    // Ajouter une transaction
    public function ajout()
    {
        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['id'])) {
            echo "<script>alert('Veuillez vous connecter avant d’ajouter une transaction.'); window.location.href='/login';</script>";
            return;
        }

        // Vérifie que tous les champs sont remplis
        if (!empty($_POST["description"]) &&
            !empty($_POST["type"]) &&
            !empty($_POST["montant"]) &&
            !empty($_POST["date_transaction"])
        ) {
            $description      = trim($_POST["description"]);
            $type             = ucfirst(strtolower($_POST["type"])); // Crédit ou Débit
            $montant          = floatval($_POST["montant"]);
            $date_transaction = $_POST["date_transaction"];
            $id_user          = $_SESSION["id"];

            // Récupérer l'email et le nom de l'utilisateur connecté
            $user_email = $_SESSION['email'] ?? null;
            $user_name  = $_SESSION['nom'] ?? "Utilisateur";

            // Ajouter la transaction en base
            $success = Transaction::create_transaction($type, $date_transaction, $montant, $description, $id_user);


            if ($success) {
                // Envoyer l'email uniquement si l'email de l'utilisateur est défini
                if ($user_email) {
                    $this->envoyerEmailTransaction(
                        $user_email,
                        $user_name,
                        $type,
                        $description,
                        $montant,
                        $date_transaction
                    );
                }

                echo "<script>alert('Transaction ajoutée et email envoyé !'); window.location.href='/transaction';</script>";
            } else {
                echo "<script>alert('Erreur lors de l’ajout de la transaction.');</script>";
                echo "<script>alert('Erreur lors de l’ajout de la transaction.');</script>";
            }
        } else {
            echo "<script>alert('Veuillez remplir tous les champs.');</script>";
        }
    }

    // Fonction privée pour envoyer l'email
    private function envoyerEmailTransaction($email, $nom, $type, $desc, $montant, $date)
    {
        $mail = new PHPMailer(true);

        try {
            // Configuration SMTP Gmail
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cashtrack@gmail.com';  // ton email Gmail
            $mail->Password   = 'mot_de_passe_app';    // mot de passe d’application Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('cashtrack@gmail.com', 'CashTrack');
            $mail->addAddress($email, $nom);

            $mail->isHTML(true);
            $mail->Subject = "Nouvelle transaction ajoutée";
            $mail->Body    = "
                <p>Salut <b>$nom</b>,</p>
                <p>Une nouvelle transaction a été enregistrée :</p>
                <ul>
                    <li>Type : $type</li>
                    <li>Description : $desc</li>
                    <li>Montant : ".number_format($montant,0,',',' ')." Ar</li>
                    <li>Date : $date</li>
                </ul>
                <p>Merci d’utiliser CashTrack !</p>
            ";

            $mail->send();
        } catch (Exception $e) {
            // Log l'erreur pour debug si l'email n'a pas pu être envoyé
            error_log("Erreur PHPMailer: " . $mail->ErrorInfo);
        }
    }

    // Afficher toutes les transactions de l'utilisateur connecté
    public function afficher()
    {
        if (!isset($_SESSION['id'])) {
            echo "<script>alert('Veuillez vous connecter pour voir vos transactions.');</script>";
            return;
        }

        $userId = $_SESSION['id'];
        $transactions = Transaction::selectAllData($userId);

        $tableau = [];
        if ($transactions) {
            foreach ($transactions as $t) {
                $tableau[] = [
                    'id' => $t['id'],
                    'description' => $t['description'],
                    'credit' => $t['type'] === 'Crédit' ? $t['montant'] : null,
                    'debit' => $t['type'] === 'Débit' ? $t['montant'] : null,
                    'date_transaction' => $t['date_transaction']
                ];
            }
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
            
            exit;
        }
    }

    // Affichage de la vue
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

    // Recherche par date
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

    // Afficher uniquement les Crédits
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

    // Afficher uniquement les Débits
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
