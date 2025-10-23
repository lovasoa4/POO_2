<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Model_dashboard;

class UserController
{
    public function __construct() {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    public function index() {
        $this->view('login', ['Erreur' => '']);
    }

    public function createUser() {
        $this->view('createUser');
    }

    public function dashboard() {
        $userId = $_SESSION['id'] ?? null;
        if(!$userId) {
            header("Location: /login");
            exit;
        }

        $dashboard = new Model_dashboard();
        $totalMonth = $dashboard->getTotalCreditDebitByMonth($userId);
        $totalCredit = array_sum(array_column($totalMonth, 'total_credit'));
        $totalDebit  = array_sum(array_column($totalMonth, 'total_debit'));
        $soldeTotal  = $totalCredit - $totalDebit;
        $soldeActuel = $dashboard->getSoldeActuel($userId);
        $lastTransactions = $dashboard->getLastTransactions($userId, 10);

        $data = [
            'nom' => $_SESSION['nom'] ?? 'Invité',
            'totalMonth' => $totalMonth,
            'totalCredit' => $totalCredit,
            'totalDebit' => $totalDebit,
            'soldeTotal' => $soldeTotal,
            'soldeActuel' => $soldeActuel,
            'lastTransactions' => $lastTransactions
        ];

        $this->view('dashboard', $data);
    }

    public function Connection() {
        if(!empty($_POST["email"]) && !empty($_POST["mdp"])) {
            $user = User::se_connecter($_POST["email"], $_POST["mdp"]);
            if($user) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['email'] = $user['email'];
                $this->dashboard();
            } else {
                $this->view("login", ['Erreur' => 'email ou mot de passe incorrect']);
            }
        } else {
            $this->view("login", ['Erreur' => 'Veuillez remplir tous les champs']);
        }
    }

    public function insertion() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["mdp"])) {
                User::create_User($_POST["nom"], $_POST["email"], $_POST["mdp"]);
                $this->view("login");
            } else {
                $this->view("createUser");
            }
        }
    }

    private function view($viewName, $data = []) {
        extract($data);
        $viewPath = APP . '/Views/' . $viewName . '.php';
        if(file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Vue {$viewName} introuvable");
        }
    }
}
