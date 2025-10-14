<?php
class Database{
    private $host = 'localhost';
    private $dbName = 'cash_track';
    private $user = 'root';
    private $password = '';

    public function getConnection(){
        try{
            
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName;charset=utf8", $this->user, $this->password );
            $pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            return $pdo;
        }
        catch( PDOException $e ){
            die('erreur de connexion à la base'. $e->getMessage() );
        }
    }
}
    ?>