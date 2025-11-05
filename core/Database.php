<?php
namespace Core;

use PDO;
use PDOException;

class Database {
    private $host = 'localhost';
    private $dbName = 'cash_track';
    private $user = 'root';
    private $password = '';

    private static $instance = null;
    private $connection;

    // 🔒 Constructeur privé → empêche "new Database()"
    private function __construct() {
        try {
            $this->connection = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName};charset=utf8",
                $this->user,
                $this->password
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base : ' . $e->getMessage());
        }
    }

    // 🧩 Retourne l’unique instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // 🔹 Retourne la connexion PDO
    public static function getConnection() {
        return self::getInstance()->connection;
    }

    // 🔐 Empêche clonage et désérialisation
    private function __clone() {}
    public function __wakeup() {} // ⚠️ doit être public (sinon Warning)
}
