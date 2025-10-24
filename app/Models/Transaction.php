<?php
namespace App\Models;

use pdo;
use PDOException;
use Core\Database; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

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
    public static function create_transaction($type, $date_transaction, $montant, $description, $id_user)
        {
            $db = new Database();
            $pdo = $db->getConnection();

            try {
                // ✅ Étape 1 : Insertion de la transaction
                $stmt = $pdo->prepare("
                    INSERT INTO transaction (type, date_transaction, montant, description, id_user)
                    VALUES (?, ?, ?, ?, ?)
                ");
                $stmt->execute([$type, $date_transaction, $montant, $description, $id_user]);

                // ✅ Étape 2 : Récupérer l'email de l'utilisateur
                $userStmt = $pdo->prepare("SELECT email, nom FROM users WHERE id_user = ?");
                $userStmt->execute([$id_user]);
                $user = $userStmt->fetch(PDO::FETCH_ASSOC);

                if (!$user) {
                    throw new Exception("Utilisateur non trouvé !");
                }

                // ✅ Étape 3 : Envoi de mail si c’est un débit
                if (strtolower($type) === 'debit') {
                    $mail = new PHPMailer(true);

                    try {
                        // Configuration SMTP
                        $mail->isSMTP();
                        $mail->Host = 'smtp.gmail.com';
                        $mail->SMTPAuth = true;
                        $mail->Username = 'tonemail@gmail.com'; // 👉 ton adresse Gmail
                        $mail->Password = 'ton_mot_de_passe_application'; // ⚠️ mot de passe d’application Gmail
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port = 587;

                        // Expéditeur et destinataire
                        $mail->setFrom('tonemail@gmail.com', 'Banque Virtuelle');
                        $mail->addAddress($user['email'], $user['nom']);

                        // Contenu du mail
                        $mail->isHTML(true);
                        $mail->Subject = 'Notification de débit';
                        $mail->Body = "
                            <h2>Bonjour {$user['nom']},</h2>
                            <p>Une nouvelle transaction a été enregistrée sur votre compte :</p>
                            <ul>
                                <li><b>Type :</b> $type</li>
                                <li><b>Montant :</b> $montant Ar</li>
                                <li><b>Date :</b> $date_transaction</li>
                                <li><b>Description :</b> $description</li>
                            </ul>
                            <p>Merci d’avoir utilisé notre service.</p>
                        ";

                        $mail->send();
                        // echo "Email envoyé à {$user['email']}";
                    } catch (Exception $e) {
                        error_log("Erreur d'envoi du mail : {$mail->ErrorInfo}");
                    }
                }

                return true;

            } catch (PDOException $e) {
                die("Erreur d'insertion : " . $e->getMessage());
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

    // Sélection des transactions de type Débit uniquement
public static function select_debit() {
    $db = new Database();
    $pdo = $db->getConnection();
    try {
        $stmt = $pdo->prepare("SELECT id, type, date_transaction, montant, description, id_user 
                               FROM transaction 
                               WHERE type = 'Débit' 
                               ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la sélection des débits: " . $e->getMessage());
    }
}

// Sélection des transactions de type Crédit uniquement
public static function select_credit() {
    $db = new Database();
    $pdo = $db->getConnection();
    try {
        $stmt = $pdo->prepare("SELECT id, type, date_transaction, montant, description, id_user 
                               FROM transaction 
                               WHERE type = 'Crédit' 
                               ORDER BY id ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erreur lors de la sélection des crédits: " . $e->getMessage());
    }
}
//miaffiche debit par recherche ou auto 
public static function getDebit($search = "")
{
    $db = new Database();
    $pdo = $db->getConnection();

    if (!empty($search)) {
        // Recherche uniquement par description (ou designation)
        $sql = "SELECT * FROM transaction
                WHERE type = 'Débit'
                AND description LIKE :search
                ORDER BY date_transaction DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => "%$search%"]);
    } else {
        // Sans recherche, afficher tous les Débits
        $sql = "SELECT * FROM transaction
                WHERE type = 'Débit'
                ORDER BY date_transaction DESC";
        $stmt = $pdo->query($sql);
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// credit //

public static function getCredit($search = "")
{
    $db = new Database();
    $pdo = $db->getConnection();

    if (!empty($search)) {
        $sql = "SELECT * FROM transaction
                WHERE type = 'Crédit'
                AND description LIKE :search
                ORDER BY date_transaction DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['search' => "%$search%"]);
    } else {
        $sql = "SELECT * FROM transaction
                WHERE type = 'Crédit'
                ORDER BY date_transaction DESC";
        $stmt = $pdo->query($sql);
    }

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// total credit//



   public static function getTotalCredit()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("SELECT SUM(montant) AS total_credit FROM transaction WHERE type = 'Crédit'");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total_credit'] ?? 0;
        } catch (PDOException $e) {
            die("Erreur lors du calcul du total crédit : " . $e->getMessage());
        }
    }

    // ====================================================
    // 2️⃣ Total des débits
    // ====================================================
    public static function getTotalDebit()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("SELECT SUM(montant) AS total_debit FROM transaction WHERE type = 'Débit'");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total_debit'] ?? 0;
        } catch (PDOException $e) {
            die("Erreur lors du calcul du total débit : " . $e->getMessage());
        }
    }

    // ====================================================
    // 3️⃣ Solde actuel (crédit - débit)
    // ====================================================
    public static function getSoldeActuel()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("
                SELECT 
                    (SELECT SUM(montant) FROM transaction WHERE type = 'Crédit') -
                    (SELECT SUM(montant) FROM transaction WHERE type = 'Débit')
                AS solde_actuel
            ");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['solde_actuel'] ?? 0;
        } catch (PDOException $e) {
            die("Erreur lors du calcul du solde actuel : " . $e->getMessage());
        }
    }

    // ====================================================
    // 4️⃣ Dernières transactions (5 dernières)
    // ====================================================
    public static function getDernieresTransactions()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("
                SELECT id, type, date_transaction, montant, description
                FROM transaction
                ORDER BY date_transaction DESC
                LIMIT 5
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des dernières transactions : " . $e->getMessage());
        }
    }

    // ====================================================
    // 5️⃣ Totaux par type (pour graphiques)
    // ====================================================
    public static function getTotalParType()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("
                SELECT type, SUM(montant) AS total_par_type
                FROM transaction
                GROUP BY type
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors du calcul du total par type : " . $e->getMessage());
        }
    }


    // 6️⃣ Totaux mensuels (pour graphique d’évolution)

    public static function getTotalMensuel()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("
                SELECT 
                    DATE_FORMAT(date_transaction, '%Y-%m') AS mois,
                    SUM(montant) AS total_mensuel
                FROM transaction
                GROUP BY mois
                ORDER BY mois ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erreur lors du calcul du total mensuel : " . $e->getMessage());
        }
    }

  
    // 7️⃣ Nombre total de transactions

    public static function getNombreTotalTransactions()
    {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) AS total_transactions FROM transaction");
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC)['total_transactions'] ?? 0;
        } catch (PDOException $e) {
            die("Erreur lors du comptage des transactions : " . $e->getMessage());
        }
    }
    //maka valeur amle date 
     public static function getValue($row, string $key)
    {
        if (is_array($row) && array_key_exists($key, $row)) {
            return $row[$key];
        }

        if (is_object($row)) {
            if (property_exists($row, $key)) {
                return $row->$key;
            }
            $getter = 'get' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($row, $getter)) {
                return $row->$getter();
            }
        }

        return null;
    }
       public static function select_by_date($date)
{
    $db = new Database();
    $pdo = $db->getConnection();

    try {
        // Requête : on compare uniquement la date (sans l'heure)
     
        $stmt = $pdo->prepare("
            SELECT id, type, date_transaction, montant, description, id_user
            FROM transaction
            WHERE CAST(date_transaction AS DATE) = :date
            ORDER BY id ASC
        ");

        // Sécuriser le paramètre et lier avec PDO
        $stmt->bindValue(':date', $date, PDO::PARAM_STR);
        $stmt->execute();
        // Retourner toutes les lignes sous forme de tableau associatif
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        die("❌ Erreur lors de la recherche : " . $e->getMessage());
    }
}

//
  public static function select_all_with_credit_debit() {
        $db = new Database();
        $pdo = $db->getConnection();
        try {
            $stmt = $pdo->prepare("
                SELECT 
                    id,
                    type,
                    date_transaction,
                    description,
                    id_user,
                    CASE WHEN type = 'Crédit' THEN montant ELSE NULL END AS credit,
                    CASE WHEN type = 'Débit' THEN montant ELSE NULL END AS debit
                FROM transaction
                ORDER BY date_transaction DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Erreur de sélection : ' . $e->getMessage());
        }
    }

        public static function selectAllData($userId)
    {
        $db = new Database();
        $pdo = $db->getConnection();

        $sql = "SELECT *
                FROM transaction
                WHERE id_user = :id_user
                ORDER BY date_transaction DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_user' => $userId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }





}
?>






