<?php
namespace App\Controllers;

use App\Models\Model_dashboard;

class DashboardController {

    private $dashboardModel;

    public function __construct() {
        if(session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->dashboardModel = new Model_dashboard();
    }

    /**
     * Affiche le dashboard pour l'utilisateur connecté
     */
    public function getAllDataDashboard() {
        // 🔹 Récupérer l'ID et le nom depuis la session
        $userId = $_SESSION['id'] ?? null;
        $nom    = $_SESSION['nom'] ?? 'Invité';

        if(!$userId) {
            header("Location: /login");
            exit;
        }

        // 🔹 Totaux par mois
        $totalMonth = $this->dashboardModel->getTotalCreditDebitByMonth($userId);

        // 🔹 Totaux globaux
        $totalCredit = array_sum(array_column($totalMonth, 'total_credit'));
        $totalDebit  = array_sum(array_column($totalMonth, 'total_debit'));
        $soldeTotal  = $totalCredit - $totalDebit;

        // 🔹 Solde actuel
        $soldeActuel = $this->dashboardModel->getSoldeActuel($userId);

        // 🔹 Dernières transactions
        $lastTransactions = $this->dashboardModel->getLastTransactions($userId, 10);

        // 🔹 Préparer les données à passer à la vue
        $data = [
            'nom'              => $nom,
            'totalMonth'       => $totalMonth,
            'totalCredit'      => $totalCredit,
            'totalDebit'       => $totalDebit,
            'soldeTotal'       => $soldeTotal,
            'soldeActuel'      => $soldeActuel,
            'lastTransactions' => $lastTransactions
        ];

        // 🔹 Charger la vue
        extract($data);

    }
}
