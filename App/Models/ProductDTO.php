<?php

namespace App\Models;

use \Config\Config;
use PDO;

class ProductDTO extends \Core\Model
{

    public function getAllProductPage(){
        $sql = 'SELECT * from product WHERE status = 1 ORDER BY pro_id ';

        $db = static::getDB();
        $data = $db->query($sql);
        $product = $data->fetchAll();
        return $product;
    }

    public function getAllProduct($currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllProductPage()) / 5) ){
            $sql = 'SELECT * from product WHERE status = 1 ORDER BY pro_id DESC LIMIT ' . Config::getPage($currentPage , 5) . ' , 5 ' ;
        }else{
            $sql = 'SELECT * from product WHERE status = 1 ORDER BY pro_id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllProductPage()) / 5) , 5) . ' , 5 ' ;
        }
        
        $db = static::getDB();
        $data = $db->query($sql);
        $product = $data->fetchAll();
        return $product;
    }

    public function delete($id){
        $sql = ' UPDATE product SET status = 0 WHERE pro_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function add(){

        $sql = 'INSERT INTO product ( tra_id , prom_id , pt_id , name , price , quantity , image , description ,status)
                VALUES ( :tra_id , :prom_id , :pt_id, :name , :price , :quantity , :image , :description , 1)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':tra_id', $_POST["tra_id"], PDO::PARAM_INT);
        $stmt->bindValue(':prom_id', $_POST["prom_id"], PDO::PARAM_INT);
        $stmt->bindValue(':pt_id', $_POST["pt_id"], PDO::PARAM_INT);
        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        $stmt->bindValue(':price', $_POST["price"]);
        $stmt->bindValue(':quantity', $_POST["quantity"]);
        $stmt->bindValue(':image',Config::uploadFile('products/'), PDO::PARAM_STR);
        $stmt->bindValue(':description', $_POST["description"], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function update(){
        $sql = ' UPDATE product SET tra_id = :tra_id , prom_id = :prom_id , pt_id = :pt_id ,
        price = :price , quantity = :quantity , image = :image , description = :description,
          name = :name WHERE pro_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_POST["pro_id"], PDO::PARAM_INT);
        $stmt->bindValue(':tra_id', $_POST["tra_id"], PDO::PARAM_INT);
        $stmt->bindValue(':prom_id', $_POST["prom_id"], PDO::PARAM_INT);
        $stmt->bindValue(':pt_id', $_POST["pt_id"], PDO::PARAM_INT);
        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        $stmt->bindValue(':price', $_POST["price"]);
        $stmt->bindValue(':quantity', $_POST["quantity"]);
        if($_FILES["fileupload"]["name"]){
            $stmt->bindValue(':image', Config::uploadFile('products/'), PDO::PARAM_STR);
        }else{
            $stmt->bindValue(':image', $_POST['imageOld'], PDO::PARAM_STR);
        }
        $stmt->bindValue(':description', $_POST["description"], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function getAllProductViewLaptop(){

        $sql = 'SELECT product.* , trademark.name AS trademarkName , product_type.name AS productTypeName
             , product.price - product.price*promotion.percent/100 AS giasau 
            FROM product INNER JOIN trademark ON product.tra_id = trademark.tra_id
            LEFT JOIN promotion ON promotion.prom_id = product.prom_id
            INNER JOIN product_type ON product.pt_id = product_type.pt_id
            INNER JOIN product_group on product_group.pg_id = product_type.pg_id             
            WHERE product_group.pg_id = 1 
            ORDER BY RAND() ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $productView = $data->fetchAll();
        return $productView;
    }

    public function getAllProductViewLinkien(){

        $sql = 'SELECT product.* , trademark.name AS trademarkName , product_type.name AS productTypeName
             , product.price - product.price*promotion.percent/100 AS giasau 
            FROM product INNER JOIN trademark ON product.tra_id = trademark.tra_id
            LEFT JOIN promotion ON promotion.prom_id = product.prom_id
            INNER JOIN product_type ON product.pt_id = product_type.pt_id
            INNER JOIN product_group on product_group.pg_id = product_type.pg_id            
            WHERE product_group.pg_id = 3 OR product_group.pg_id = 4
            ORDER BY RAND()   ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $productView = $data->fetchAll();
        return $productView;
    }

    public function getProductId($id){
        $sql = 'SELECT product.* , product.price - product.price*promotion.percent/100 AS giasau ,
            product_type.name AS productTypeName
            FROM product LEFT JOIN promotion ON promotion.prom_id = product.prom_id
            INNER JOIN product_type ON product.pt_id = product_type.pt_id
            WHERE product.pro_id = :id ' ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function getProductAfterId($id){
        $sql = 'SELECT * FROM product
            WHERE pro_id = :id ' ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $stmt->execute();

        return $stmt->fetch();
    }

    public function getProductSimilar($id){
        $sql = 'SELECT product.* , product.price - product.price*promotion.percent/100 AS giasau ,
            product_type.name AS productTypeName
            FROM product LEFT JOIN promotion ON promotion.prom_id = product.prom_id
            INNER JOIN product_type ON product.pt_id = product_type.pt_id             
            WHERE product.pro_id = ' . $id .
            ' ORDER BY RAND() ';

            $db = static::getDB();
            $data = $db->query($sql);
            $productSimilar = $data->fetchAll();
            return $productSimilar;
    }

    public function getAllProductShopPage($search , $group , $type , $brand){
        
        $sql = 'SELECT product.* , trademark.name AS trademarkName , product_type.name AS productTypeName
                , product.price - product.price*promotion.percent/100 AS giasau 
                FROM product INNER JOIN trademark ON product.tra_id = trademark.tra_id
                LEFT JOIN promotion ON promotion.prom_id = product.prom_id
                INNER JOIN product_type ON product.pt_id = product_type.pt_id
                INNER JOIN product_group on product_group.pg_id = product_type.pg_id
                ORDER BY RAND() ' ;

        $dk = "" ;
        $check = false;
        $number = 0 ;
        $sql = 'SELECT product.* , trademark.name AS trademarkName , product_type.name AS productTypeName
                , product.price - product.price*promotion.percent/100 AS giasau 
                FROM product INNER JOIN trademark ON product.tra_id = trademark.tra_id
                LEFT JOIN promotion ON promotion.prom_id = product.prom_id
                INNER JOIN product_type ON product.pt_id = product_type.pt_id
                INNER JOIN product_group on product_group.pg_id = product_type.pg_id ' ;

        if($search != ""){
            $dk .= "product.name LIKE '%" . $search ."%' " ;
            $check = true ;
            $number += 1 ;
        }
        if($group != ""){
            
            if ($number == 0){
                $dk .= "product_group.pg_id = " . $group . " " ;
                $check = true ;
                $number += 1 ;
            }else{
                $dk .= " AND product_group.pg_id = " . $group . " " ;
                $check = true ;
                $number += 1 ;
            }
        }
        if($type != ""){
            
            if ($number == 0){
                $dk .= "product_type.pt_id = " . $type . " " ;
                $check = true ;
                $number += 1 ;
            }else{
                $dk .= " AND product_type.pt_id = " . $type . " " ;
                $check = true ;
                $number += 1 ;
            }

        }
        if($brand != ""){
            
            if ($number == 0){
                $dk .= "trademark.tra_id = " . $brand . " " ;
                $check = true ;
                $number += 1 ;
            }else{
                $dk .= " AND trademark.tra_id = " . $brand . " " ;
                $check = true ;
                $number += 1 ;
            }

        }

        if ($check){
            $sql .= " WHERE " . $dk  ;
        }

        $db = static::getDB();
        $data = $db->query($sql);
        $product = $data->fetchAll();
        return $product;
    }

    public function getAllProductShop( $search , $group , $type , $brand , $currentPage ){

        $dk = "" ;
        $check = false;
        $number = 0 ;
        $sql = 'SELECT product.* , trademark.name AS trademarkName , product_type.name AS productTypeName
                , product.price - product.price*promotion.percent/100 AS giasau 
                FROM product INNER JOIN trademark ON product.tra_id = trademark.tra_id
                LEFT JOIN promotion ON promotion.prom_id = product.prom_id
                INNER JOIN product_type ON product.pt_id = product_type.pt_id
                INNER JOIN product_group on product_group.pg_id = product_type.pg_id ' ;

        if($search != ""){
            $dk .= "product.name LIKE '%" . $search ."%' " ;
            $check = true ;
            $number += 1 ;
        }
        if($group != ""){
            
            if ($number == 0){
                $dk .= "product_group.pg_id = " . $group . " " ;
                $check = true ;
                $number += 1 ;
            }else{
                $dk .= " AND product_group.pg_id = " . $group . " " ;
                $check = true ;
                $number += 1 ;
            }
        }
        if($type != ""){
            
            if ($number == 0){
                $dk .= "product_type.pt_id = " . $type . " " ;
                $check = true ;
                $number += 1 ;
            }else{
                $dk .= " AND product_type.pt_id = " . $type . " " ;
                $check = true ;
                $number += 1 ;
            }

        }
        if($brand != ""){
            
            if ($number == 0){
                $dk .= "trademark.tra_id = " . $brand . " " ;
                $check = true ;
                $number += 1 ;
            }else{
                $dk .= " AND trademark.tra_id = " . $brand . " " ;
                $check = true ;
                $number += 1 ;
            }

        }

        if ($check){
            $sql .= " WHERE " . $dk . ' ORDER BY RAND() 
            LIMIT ' . Config::getPage($currentPage , 9) . ' , 9 ' ;
        }else{
            $sql .= ' ORDER BY RAND() 
            LIMIT ' . Config::getPage($currentPage , 9) . ' , 9 ' ;
        }

        $db = static::getDB();
        $data = $db->query($sql);
        $product = $data->fetchAll();
        return $product;
    }

    public function getAllProductCheckOut( $id ){

        $sql = 'SELECT product.* , product.price - product.price*promotion.percent/100 AS giasau ,
        product_type.name AS productTypeName
        FROM product LEFT JOIN promotion ON promotion.prom_id = product.prom_id
        INNER JOIN product_type ON product.pt_id = product_type.pt_id
        WHERE product.pro_id = :id ' ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getUpdateAfterCheckOut( $id , $quantity){

        $sql = ' UPDATE product SET quantity = :quantity WHERE pro_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity);

        return $stmt->execute();
    }

}