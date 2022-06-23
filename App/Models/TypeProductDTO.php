<?php

namespace App\Models;
use \Config\Config;
use PDO;

class TypeProductDTO extends \Core\Model
{

    public function getAllTypeProductPage(){
        $sql = 'SELECT * from product_type WHERE status = 1 ORDER BY pt_id  ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $productGroup = $data->fetchAll();
        return $productGroup;
    }

    public function getAllTypeProduct($currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllTypeProductPage()) / 5)){
            $sql = 'SELECT * from product_type WHERE status = 1 ORDER BY pt_id DESC LIMIT ' . Config::getPage($currentPage , 5) . ' , 5 ' ;
        }else{
            $sql = 'SELECT * from product_type WHERE status = 1 ORDER BY pt_id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllTypeProductPage()) / 5) , 5) . ' , 5 ' ;
        }

        $db = static::getDB();
        $data = $db->query($sql);
        $productGroup = $data->fetchAll();
        return $productGroup;
    }

    public function getTypeProduct($id){
        
        $sql = 'SELECT * from product_type WHERE pt_id = :id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function delete($id){
        $sql = ' UPDATE product_type SET status = 0 WHERE pt_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function add(){

        $sql = 'INSERT INTO product_type (name ,status)
                VALUES (:name , 1)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function update(){
        $sql = ' UPDATE product_type SET name = :name WHERE pt_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);

        return $stmt->execute();
    }
}