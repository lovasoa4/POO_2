<?php
namespace App\Models;

use PDO;
use Core\Database;

class Model_dashboard {

    private $pdo;

    public function __construct() {
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    public function getTotalCreditDebitByMonth($userId) {
        $sql = "
        SELECT 
            COALESCE(vtc.annee, vtd.annee) AS annee,
            COALESCE(vtc.mois, vtd.mois) AS mois,
            IFNULL(vtc.total,0) AS total_credit,
            IFNULL(vtd.total,0) AS total_debit
        FROM view_total_credit vtc
        LEFT JOIN view_total_debit vtd
        ON vtc.annee = vtd.annee AND vtc.mois = vtd.mois AND vtc.id_user = vtd.id_user
        WHERE vtc.id_user = :id_user
        ORDER BY vtc.annee DESC, vtc.mois DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_user' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function getSoldeActuel($userId) {
        $sql = "
        SELECT 
            SUM(CASE WHEN type='credit' THEN montant ELSE 0 END) -
            SUM(CASE WHEN type='debit' THEN montant ELSE 0 END) AS solde
        FROM transaction
        WHERE id_user = :id_user
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id_user' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['solde'] ?? 0;
    }

    public function getLastTransactions($userId, $limit = 10) {
        $sql = "
        SELECT date_transaction, type, montant, description
        FROM transaction
        WHERE id_user = :id_user
        ORDER BY date_transaction DESC
        LIMIT :limit
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_user', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }
    // 🔹 Totaux crédit et débit par jour pour un mois donné
public function getDailyTransactions($userId, $mois, $annee) {
    $sql = "
        SELECT 
            DAY(date_transaction) AS jour,
            SUM(CASE WHEN type='credit' THEN montant ELSE 0 END) AS total_credit,
            SUM(CASE WHEN type='debit' THEN montant ELSE 0 END) AS total_debit
        FROM transaction
        WHERE id_user = :id_user
          AND MONTH(date_transaction) = :mois
          AND YEAR(date_transaction) = :annee
        GROUP BY DAY(date_transaction)
        ORDER BY DAY(date_transaction)
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute([
        'id_user' => $userId,
        'mois'    => $mois,
        'annee'   => $annee
    ]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
}

// 🔹 Récupérer les mois existants pour l'utilisateur
public function getExistingMonths($userId) {
    $sql = "
        SELECT DISTINCT MONTH(date_transaction) AS mois, YEAR(date_transaction) AS annee
        FROM transaction
        WHERE id_user = :id_user
        ORDER BY annee DESC, mois DESC
    ";
    $stmt = $this->pdo->prepare($sql);
    $stmt->execute(['id_user' => $userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
}

}
