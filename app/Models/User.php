<?php
namespace App\Models;

use Core\Database;
use PDO;
use PDOException;

class User{

    protected string $nom;
    protected string $email;
    protected string $mdp;

    public function __construct($nom, $email, $mdp) {
        $this->nom = $nom;
        $this->email = $email;
        $this->mdp = $mdp;
    }
    
    //getter
    public function getNom(){
        return $this->nom;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getMdp(){
        return $this->mdp;
    }

    //Setter
    public function setNom ($nom){
        $this->nom = $nom;
    }

    public function setEmail ($email){
        $this->email = $email;
    }

    public function setMdp ($mdp){
        $this->mdp = $mdp;
    }

    public static function create_User($nom, $email, $mdp){
            $db = new Database();
            $pdo = $db->getConnection();
        try{
            $stmt = $pdo->prepare("INSERT INTO users (nom, email, mdp) VALUES(?, ?, ?)");
            return $stmt->execute([$nom, $email, $mdp]);
        }
        catch(PDOException $e){
            return("Insersion echoué". $e->getMessage());
        }
    }

public static function se_connecter($email, $mdp){
    $db = new Database();
    $pdo = $db->getConnection();

    try {
        $stmt = $pdo->prepare("SELECT * FROM user WHERE email = :email AND mdp = :mdp");
        $stmt->execute([':email' => $email, ':mdp' => $mdp]);
        $con = $stmt->fetch(PDO::FETCH_ASSOC);
        return $con ? $con : false;
    } catch (PDOException $e) {
        error_log("Erreur DB se_connecter: " . $e->getMessage());
        return false;
    }
}

}