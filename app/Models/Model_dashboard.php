<?php
namespace App\Models;

use Core\Database;

class Model_dashboard{
    private $debit;
    private $credit;
    private $mois;
    private $annee;
    private $evolution;
    private $evaluation;

    private $id_User;


    public function __construct($credit,$debit,$mois,$annee,$id_User){
        $this->credit=$credit;
        $this->debit=$debit;
        $this->mois=$mois;
        $this->annee=$annee; 
        $this->id_User=$id_User;
        $total=$debit + $credit;
        if($debit > $credit){
            $this->evaluation='perte';
            $this->evolution= ($debit/$total) * 100;
        }if($debit < $credit){
            $this->evaluation='benefice';
            $this->evolution= ($credit/$total) * 100;
        }if($debit==$credit){
            $this->evolution='constant';
            $this->evaluation=0;
        }
        
    }

    public function getDebit(){
        return $this->debit;
    }
     public function getCredit(){
        return $this->credit;
    }
    public function getMois(){
        return $this->mois;
    }
     public function getAnnee(){
        return $this->annee;
    }
     public function getEvolution(){
        return $this->evolution;
    }
     public function getEvaluation(){
        return $this->evaluation;
    }
       public function getIdUser(){
        return $this->id_User;
    }




    public static function selectAllData($id_User){
        $pdo = new Database();
        $db = $pdo->getConnection();

        $sql='select vtc.mois , vtc.annee ,vtc.total as credit , vtd.total as debit ,vtd.id_user
                from view_total_credit as vtc
                inner join view_total_debit as vtd
                on vtc.annee=vtd.annee and vtc.mois=vtd.mois and vtc.id_user=vtd.id_user
                where vtc.id_user= :id_User and vtd.id_user= :id_User
                order by annee desc , mois desc';
        $statement=$db->prepare($sql);
        $statement->execute([
                 ":id_User" =>$id_User
            ]);
        return $statement->fetchAll();
    }

      public static function TransactionDansUnMois($mois,$annee,$idUser,$db){
        $sql="SELECT * FROM `view_transaction` 
              WHERE mois= :mois  and  annee= :annee and id_USer= :idUser";
        $statement =$db->prepare($sql);
        $statement->execute([
            ':mois' => $mois,
            ':annee' => $annee,
            ':idUser' => $idUser
        ]);
        return $statement->fetchAll();
    }
}


?>