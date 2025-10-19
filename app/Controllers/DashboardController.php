<?php
namespace App\Controllers;

use App\Models\Model_dashboard;
use Core\Database;

class DashboardController extends Fonction
{
    /**
     * Affiche les données du tableau de bord
     */
    public function getAllDataDashboard()
    {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['id'])) {
            header('Location: /');
            exit;
        }

        $id = $_SESSION['id'];
        $tabData = [];

        try {
            // Connexion à la base
            $db = new Database();
            $pdo = $db->getConnection();

            // Récupération des données
            $datas = Model_dashboard::selectAllData($pdo, $id);

            // Construction des objets du modèle
            if (!empty($datas)) {
                foreach ($datas as $data) {
                    $tabData[] = new Model_dashboard(
                        $data['credit'] ?? 0,
                        $data['debit'] ?? 0,
                        $data['mois'] ?? '',
                        $data['annee'] ?? '',
                        $data['id_user'] ?? ''
                    );
                }
            }
        } catch (\PDOException $e) {
            echo '<h3 style="color:red;">Erreur base de données : ' . htmlspecialchars($e->getMessage()) . '</h3>';
        } catch (\Exception $e) {
            echo '<h3 style="color:red;">Erreur interne : ' . htmlspecialchars($e->getMessage()) . '</h3>';
        }

        // Appel des vues
        $this->view('navbar');
        $this->view('view_dashboard', ['tabData' => $tabData]);
    }
}
