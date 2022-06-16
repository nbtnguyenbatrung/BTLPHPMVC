<?php

namespace App\Models;
use \Config\Config;
use PDO;

class TrademarkDTO extends \Core\Model
{

    public function getAllTrademarkPage(){
        $sql = 'SELECT * from trademark WHERE status = 1 ORDER BY tra_id  ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $productGroup = $data->fetchAll();
        return $productGroup;
    }

    public function getAllTrademark($currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllTrademarkPage()) / 5) ){
            $sql = 'SELECT * from trademark WHERE status = 1 ORDER BY tra_id DESC LIMIT ' . Config::getPage($currentPage) . ' , 5 ' ;
        }else{
            $sql = 'SELECT * from trademark WHERE status = 1 ORDER BY tra_id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllTrademarkPage()) / 5)) . ' , 5 ' ;
        }

        $db = static::getDB();
        $data = $db->query($sql);
        $productGroup = $data->fetchAll();
        return $productGroup;
    }

    public function getTrademark($id){
        
        $sql = 'SELECT * from trademark WHERE tra_id = :id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function delete($id){
        $sql = ' UPDATE trademark SET status = 0 WHERE tra_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function add(){

        $sql = 'INSERT INTO trademark (name , logo ,status)
                VALUES (:name , :logo , 1)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        $stmt->bindValue(':logo', Config::uploadFile('logo/'), PDO::PARAM_STR);
        
        return $stmt->execute();

    }

    public function update(){
        $sql = ' UPDATE trademark SET name = :name , logo = :logo WHERE tra_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_POST["id"], PDO::PARAM_INT);
        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        $stmt->bindValue(':logo', Config::uploadFile('logo/'), PDO::PARAM_STR);

        return $stmt->execute();
    }

}