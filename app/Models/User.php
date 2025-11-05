<?php
namespace App\Models;

use Core\Database;
use PDO;
use PDOException;

class User {

    protected string $nom;
    protected string $email;
    protected string $mdp;

    public function __construct($nom, $email, $mdp) {
        $this->nom = $nom;
        $this->email = $email;
        $this->mdp = $mdp;
    }

    // --- Getters ---
    public function getNom() { return $this->nom; }
    public function getEmail() { return $this->email; }
    public function getMdp() { return $this->mdp; }

    // --- Setters ---
    public function setNom($nom) { $this->nom = $nom; }
    public function setEmail($email) { $this->email = $email; }
    public function setMdp($mdp) { $this->mdp = $mdp; }

    // 🔹 Créer un utilisateur
    public static function create_User($nom, $email, $mdp) {
        $pdo = Database::getConnection();

        try {
            $stmt = $pdo->prepare("INSERT INTO users (nom, email, mdp) VALUES (?, ?, ?)");
            return $stmt->execute([$nom, $email, $mdp]);
        } catch (PDOException $e) {
            die("Insertion échouée : " . $e->getMessage());
        }
    }

    // 🔹 Connexion utilisateur
    public static function se_connecter($email, $mdp) {
        $pdo = Database::getConnection();

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email AND mdp = :mdp");
            $stmt->execute([':email' => $email, ':mdp' => $mdp]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur DB se_connecter: " . $e->getMessage());
            return false;
        }
    }

    // 🔹 Sélection par ID
    public static function select_by_id($id_user) {
        $pdo = Database::getConnection();

        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id_user]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur select_by_id: " . $e->getMessage());
            return null;
        }
    }
}
?>
