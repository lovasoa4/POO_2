<?php
namespace App\Models;

use pdo;
use PDOException;
use Core\Database; 

class Transaction {
    protected int $id;
    protected string $type;
    protected string $date_transaction;
    protected float $montant;
    protected string $description;
    protected int $id_user;

    public function __construct($id, $type, $date_transaction, $montant, $description, $id_user) {
        $this->id = $id;
        $this->type = $type;
        $this->date_transaction = $date_transaction;
        $this->montant = $montant;
        $this->description = $description;
        $this->id_user = $id_user;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getType() { return $this->type; }
    public function getDateTransaction() { return $this->date_transaction; }
    public function getMontant() { return $this->montant; }
    public function getDescription() { return $this->description; }
    public function getIdUser() { return $this->id_user; }

    // Sélection de toutes les transactions
    public static function select_transaction() {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("SELECT id, type, date_transaction, montant, description, id_user FROM transaction ORDER BY id ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur d'affichage: " . $e->getMessage());
        }
    }

    // Création d'une transaction
    public static function create_transaction($type, $date_transaction, $montant, $description, $id_user) {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("INSERT INTO transaction (type, date_transaction, montant, description, id_user) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$type, $date_transaction, $montant, $description, $id_user]);
        } catch (PDOException $e) {
            die("Erreur d' insertion: " . $e->getMessage());
        }
    }
    //fonction supprimer 
    public static function delete_transaction($id){
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("DELETE FROM transaction WHERE id = ? ");
            return $stmt->execute([$id]);
        } catch (PDOException $e) {
            die("Erreur de la suppression: " . $e->getMessage());
        }
    }

    //affichage de crédit 
        public static function select_credit() {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("SELECT id, type, date_transaction, montant, description, id_user FROM transaction WHERE type = Crédit  ORDER BY id ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur d'affichage: " . $e->getMessage());
        }
    }
}
?>