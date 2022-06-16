<?php

namespace App\Models;
use \Config\Config;
use PDO;

class GroupProductDTO extends \Core\Model
{
    

    public function getAllGroupProductPage(){
        $sql = 'SELECT * from product_group WHERE status = 1 ORDER BY pg_id  ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $productGroup = $data->fetchAll();
        return $productGroup;
    }

    public function getAllGroupProduct($currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllGroupProductPage()) / 5) ){
            $sql = 'SELECT * from product_group WHERE status = 1 ORDER BY pg_id DESC LIMIT ' . Config::getPage($currentPage) . ' , 5 ' ;
        }else{
            $sql = 'SELECT * from product_group WHERE status = 1 ORDER BY pg_id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllGroupProductPage()) / 5)) . ' , 5 ' ;
        }
        
        $db = static::getDB();
        $data = $db->query($sql);
        $productGroup = $data->fetchAll();
        return $productGroup;
    }

    public function getGroupProduct($id){
        
        $sql = 'SELECT * from product_group WHERE pg_id = :id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function delete($id){
        $sql = ' UPDATE product_group SET status = 0 WHERE pg_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function add(){

        $sql = 'INSERT INTO product_group (name ,status)
                VALUES (:name , 1)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public function update(){
        $sql = ' UPDATE product_group SET name = :name WHERE pg_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);

        return $stmt->execute();
    }

    public static function checkName($name){

        $sql = 'SELECT * from product_group WHERE name = :name ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function nameFound($name){

        $productGroup = static::checkName($name);

        if ($productGroup) {
            return true;
        }

        return false;

    }
}