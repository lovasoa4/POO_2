<?php

namespace App\Models;

use PDO;
use PDOException;
use Core\Database;
use App\Helper\EmailObserver;

class Transaction implements \SplSubject
{
    // === Attributs ===
    public $id;
    public $type;
    public $date_transaction;
    public $montant;
    public $description;
    public $id_user;
    public $user_email;
    public $user_name;

    /** @var \SplObjectStorage */
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

    // === Méthodes du pattern Observer ===
    public function attach(\SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    // === CRUD ===

    // 🔹 Ajouter une transaction et notifier l’observateur
    public static function create_transaction($type, $date_transaction, $montant, $description, $id_user)
    {
        $pdo = Database::getConnection();

        try {
            $stmt = $pdo->prepare("
                INSERT INTO transaction (type, date_transaction, montant, description, id_user)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$type, $date_transaction, $montant, $description, $id_user]);

            //  Crée un objet Transaction pour déclencher l’observer
            $t = new self();
            $t->type = $type;
            $t->date_transaction = $date_transaction;
            $t->montant = $montant;
            $t->description = $description;
            $t->id_user = $id_user;

            // Récupère les infos utilisateur
            $stmtUser = $pdo->prepare("SELECT nom, email FROM users WHERE id = ?");
            $stmtUser->execute([$id_user]);
            $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                $t->user_name = $user['nom'];
                $t->user_email = $user['email'];
            }

            // Attacher et notifier l’observateur
            $t->attach(new EmailObserver());
            $t->notify();

            return true;
        } catch (PDOException $e) {
            error_log("Erreur create_transaction : " . $e->getMessage());
            return false;
        }
    }

    // 🔹 Supprimer une transaction
    public static function delete_transaction($id)
    {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("DELETE FROM transaction WHERE id = ?");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            error_log("Erreur delete_transaction : " . $e->getMessage());
            return false;
        }
    }

    // 🔹 Sélectionner toutes les transactions d’un utilisateur
    public static function selectAllData($userId)
    {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("
            SELECT * FROM transaction 
            WHERE id_user = :id_user 
            ORDER BY date_transaction DESC
        ");
            $stmt->execute(['id_user' => $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur selectAllData : " . $e->getMessage());
            return [];
        }
    }


    // 🔹 Sélection par date
    public static function select_by_date($date)
    {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->prepare("
                SELECT * FROM transaction
                WHERE CAST(date_transaction AS DATE) = :date
                ORDER BY id DESC
            ");
            $stmt->execute(['date' => $date]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur select_by_date : " . $e->getMessage());
            return [];
        }
    }

    // 🔹 Sélection toutes transactions
    public static function select_transaction()
    {
        $pdo = Database::getConnection();
        try {
            $stmt = $pdo->query("SELECT * FROM transaction ORDER BY id DESC");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur select_transaction : " . $e->getMessage());
            return [];
        }
    }


    // Crédits
    public static function getCredit($userId, $search = "")
    {
        $pdo = Database::getConnection();
        try {
            $sql = "SELECT * FROM transaction WHERE type='Crédit' AND id_user = :id_user";
            $params = ['id_user' => $userId];
            if (!empty($search)) {
                $sql .= " AND description LIKE :search";
                $params['search'] = "%$search%";
            }
            $sql .= " ORDER BY date_transaction DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getCredit : " . $e->getMessage());
            return [];
        }
    }

    // Débits
    public static function getDebit($userId, $search = "")
    {
        $pdo = Database::getConnection();
        try {
            $sql = "SELECT * FROM transaction WHERE type='Débit' AND id_user = :id_user";
            $params = ['id_user' => $userId];
            if (!empty($search)) {
                $sql .= " AND description LIKE :search";
                $params['search'] = "%$search%";
            }
            $sql .= " ORDER BY date_transaction DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur getDebit : " . $e->getMessage());
            return [];
        }
    }
}
