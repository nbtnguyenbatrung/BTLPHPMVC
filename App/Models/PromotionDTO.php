<?php

namespace App\Models;

use \Config\Config;
use PDO;

class PromotionDTO extends \Core\Model
{

    public function getAllPromotionPage(){
        $sql = 'SELECT * from promotion WHERE status = 1 ';

        $db = static::getDB();
        $data = $db->query($sql);
        $promotion = $data->fetchAll();
        return $promotion;
    }

    public function getAllPromotion($currentPage){

            if ($currentPage <= Config::getCeil(count($this->getAllPromotionPage()) / 5) ){
                $sql = 'SELECT * , DATEDIFF(promotion.to_date,promotion.from_date) as diffdate from promotion WHERE status = 1 ORDER BY prom_id DESC LIMIT ' . Config::getPage($currentPage , 5) . ' , 5 ' ;
            }else{
                $sql = 'SELECT * , DATEDIFF(promotion.to_date,promotion.from_date) as diffdate from promotion WHERE status = 1 ORDER BY prom_id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllPromotionPage()) / 5) , 5) . ' , 5 ' ;
            }

        $db = static::getDB();
        $data = $db->query($sql);
        $promotion = $data->fetchAll();
        return $promotion;
    }

    public function getPromotion($id){
        
        $sql = 'SELECT * from promotion WHERE prom_id = :id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function delete($id){
        $sql = ' UPDATE promotion SET status = 0 WHERE prom_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function add(){

        $sql = 'INSERT INTO promotion (name , percent , from_date , to_date , image ,description , status)
                VALUES ( :name , :percent , :from_date , :to_date , :image , :description, 1)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        $stmt->bindValue(':percent', $_POST["percent"]);
        $stmt->bindValue(':from_date', $_POST["from_date"]);
        $stmt->bindValue(':to_date', $_POST["to_date"]);
        $stmt->bindValue(':image', Config::uploadFile('promotion/') , PDO::PARAM_STR);
        $stmt->bindValue(':description', $_POST["description"] ,  PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function update(){
        $sql = ' UPDATE promotion SET name = :name , percent = :percent , 
        from_date = :from_date , to_date = :to_date , image = :image , description = :description
          WHERE prom_id = :id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        $stmt->bindValue(':percent', $_POST["percent"]);
        $stmt->bindValue(':from_date', $_POST["from_date"]);
        $stmt->bindValue(':to_date', $_POST["to_date"]);
        $stmt->bindValue(':image', Config::uploadFile('promotion/') , PDO::PARAM_STR);
        $stmt->bindValue(':description', $_POST["description"]);

        return $stmt->execute();
    }

    public function getAllPromotionView(){
        $sql = 'SELECT * from promotion WHERE status = 1 AND to_date >=  CURDATE() ';

        $db = static::getDB();
        $data = $db->query($sql);
        $promotion = $data->fetchAll();
        return $promotion;
    }

}