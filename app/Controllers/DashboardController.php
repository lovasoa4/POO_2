<?php
namespace App\Controllers;
use App\Controllers\Fonction;
use App\Models\Model_dashboard;
use Core\ConnectionDB;

class DashboardController extends Fonction{
    public function getAllDataDashboard(){
        $db = ConnectionDB::getInstance();
        $id=$_SESSION['id'];
        $tabData=array();
        $datas=Model_dashboard::selectAllData($db,$id);
        foreach($datas as $data){
            $element=new Model_dashboard($data['credit'],$data['debit'],$data['mois'],$data['annee'],$data['id_user']);
            array_push($tabData,$element);
        }
        $this->view('navbar');
       $this->view('view_dashboard', ['tabData' => $tabData]);
    }
}
?>