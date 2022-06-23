<?php

namespace App\Models;
use \Config\Config;
use PDO;

class ProductPromotionDTO extends \Core\Model
{
    

    public function getAllProductPromotionPage(){
        $sql = 'SELECT * from product INNER JOIN promotion
        ON product.prom_id = promotion.prom_id
        ORDER BY product.pro_id  ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $productPromotion = $data->fetchAll();
        return $productPromotion;
    }

    public function getAllProductPromotion($currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllProductPromotionPage()) / 5) ){
            $sql = 'SELECT product.name , product.price , product.pro_id , promotion.prom_id,
            promotion.percent , promotion.from_date , promotion.to_date ,DATEDIFF(promotion.to_date,promotion.from_date) as diffdate
            from product INNER JOIN promotion
            ON product.prom_id = promotion.prom_id
            ORDER BY product.pro_id DESC LIMIT ' . Config::getPage($currentPage , 5) . ' , 5 ' ;
        }else{
            $sql = 'SELECT product.name , product.price , product.pro_id , promotion.prom_id,
            promotion.percent , promotion.from_date , promotion.to_date , DATEDIFF(promotion.to_date,promotion.from_date) as diffdate
            from product INNER JOIN promotion
            ON product.prom_id = promotion.prom_id
            ORDER BY product.pro_id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllProductPromotionPage()) / 5) , 5) . ' , 5 ' ;
        }
        
        $db = static::getDB();
        $data = $db->query($sql);
        $productPromotion = $data->fetchAll();
        return $productPromotion;
    }

    public function delete($id){
        $sql = ' UPDATE product SET prom_id = :prom_id WHERE pro_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':prom_id', NULL );

        return $stmt->execute();
    }

    public function update(){
        $sql = ' UPDATE product SET prom_id = :prom_id WHERE pro_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_POST["pro_id"], PDO::PARAM_INT);
        $stmt->bindValue(':prom_id', $_POST["prom_id"], PDO::PARAM_INT);

        return $stmt->execute();
    }
}