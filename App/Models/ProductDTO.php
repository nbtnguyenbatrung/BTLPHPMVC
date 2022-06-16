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
            $sql = 'SELECT * from product WHERE status = 1 ORDER BY pro_id DESC LIMIT ' . Config::getPage($currentPage) . ' , 5 ' ;
        }else{
            $sql = 'SELECT * from product WHERE status = 1 ORDER BY pro_id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllProductPage()) / 5)) . ' , 5 ' ;
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
}