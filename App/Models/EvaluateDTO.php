<?php

namespace App\Models;

use \Config\Config;
use PDO;

class EvaluateDTO extends \Core\Model
{

    public function getAlllEvaluateByProductId($pro_id){
        $sql = 'SELECT * from evalute
        INNER JOIN user_account ON evalute.user_id = user_account.user_id

         WHERE pro_id =  ' . $pro_id ;

        $db = static::getDB();
        $data = $db->query($sql);

        return $data->fetchAll();
    }

    public function getAllGroupProduct($currentPage , $pro_id){

        if ($currentPage <= Config::getCeil(count($this->getAlllEvaluateByProductId($pro_id)) / 5) ){
            $sql = 'SELECT * from evalute WHERE pro_id = ' . $pro_id . ' ORDER BY create_date DESC LIMIT ' . Config::getPage($currentPage , 5) . ' , 5 ' ;
        }else{
            $sql = 'SELECT * from evalute WHERE pro_id = ' . $pro_id . ' ORDER BY create_date DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAlllEvaluateByProductId($pro_id)) / 5) , 5) . ' , 5 ' ;
        }
        
        $db = static::getDB();
        $data = $db->query($sql);

        return $data->fetchAll();
    }
    
    public function add(){

        $sql = 'INSERT INTO evalute (user_id ,pro_id , rate , comment )
                VALUES (:user_id , :pro_id , :rate , :comment )';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $_POST["user_id"], PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $_POST["pro_id"], PDO::PARAM_INT);
        $stmt->bindValue(':rate', $_POST["rate"], PDO::PARAM_INT);
        $stmt->bindValue(':comment', $_POST["comment"], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

}