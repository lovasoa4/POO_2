<?php
namespace App\Controllers;

use App\Models\User;
use App\Models\Transaction;
use App\Models\Model_dashboard;

class UserController
{
    // 🔹 Constructeur pour démarrer la session
    public function __construct() {
        if(session_status() === PHP_SESSION_NONE){
            session_start();
        }
    }

    // 🔹 Affiche la page de login
    public function index() {
        $this->view('login', ['Erreur' => '']);
    }

    // 🔹 Affiche le formulaire de création d'utilisateur
    public function createUser() {
        $this->view('createUser');
    }

    // 🔹 Tableau de bord utilisateur
    public function dashboard() {
        $userId = $_SESSION['id'] ?? null;

        // Redirige vers login si l'utilisateur n'est pas connecté
        if(!$userId) {
            header("Location: /login");
            exit;
        }

        $dashboard = new Model_dashboard();

        // Récupère les totaux mensuels
        $totalMonth = $dashboard->getTotalCreditDebitByMonth($userId);

        // Calcul total crédit, total débit et solde total
        $totalCredit = array_sum(array_column($totalMonth, 'total_credit'));
        $totalDebit  = array_sum(array_column($totalMonth, 'total_debit'));
        $soldeTotal  = $totalCredit - $totalDebit;

        // Solde actuel et dernières transactions
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

    // 🔹 Connexion utilisateur
    public function Connection() {
        if(!empty($_POST["email"]) && !empty($_POST["mdp"])) {
            $user = User::se_connecter($_POST["email"], $_POST["mdp"]);
            if($user) {
                // Stocke les infos de session
                $_SESSION['id'] = $user['id'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['email'] = $user['email'];

                // Redirige vers dashboard
                $this->dashboard();
            } else {
                $this->view("login", ['Erreur' => 'Email ou mot de passe incorrect']);
            }
        } else {
            $this->view("login", ['Erreur' => 'Veuillez remplir tous les champs']);
        }
    }

    // 🔹 Création d'un nouvel utilisateur
    public function insertion() {
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            if(!empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["mdp"])) {
                User::create_User($_POST["nom"], $_POST["email"], $_POST["mdp"]);
                $this->view("login");
            } else {
                $this->view("createUser", ['Erreur' => 'Veuillez remplir tous les champs']);
            }
        } else {
            $this->view("createUser");
        }
    }

    // 🔹 Méthode interne pour afficher les vues
    private function view($viewName, $data = []) {
        extract($data);
        $viewPath = APP . '/Views/' . $viewName . '.php';
        if(file_exists($viewPath)) {
            require_once $viewPath;
        } else {
            die("Vue {$viewName} introuvable");
        }
    }
public function logout()
{
    // Démarre la session uniquement si elle n'est pas déjà active
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Supprime toutes les variables de session
    $_SESSION = [];

    // Supprime le cookie de session s'il existe
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600, 
            $params["path"], $params["domain"], 
            $params["secure"], $params["httponly"]
        );
    }

    // Détruit la session
    session_destroy();

    // ⚠️ Supprime les tampons de sortie uniquement s'ils existent
    if (ob_get_length()) {
        ob_end_clean();
    }

    // Redirige proprement vers la page de login
    header("Location: /login?logout=1");
    exit;
}

}
