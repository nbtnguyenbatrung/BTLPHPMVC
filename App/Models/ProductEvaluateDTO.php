<?php

namespace App\Models;
use \Config\Config;
use PDO;

class ProductEvaluateDTO extends \Core\Model
{
    

    public function getAllProductEvaluatePage($id){
        $sql = 'SELECT * from evalute ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $productEvaluate = $data->fetchAll();
        return $productEvaluate;
    }

    public function getAllGroupProduct($id , $currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllProductEvaluatePage($id)) / 5) ){
            $sql = 'SELECT * from evalute ORDER BY create_date DESC LIMIT ' . Config::getPage($currentPage) . ' , 5 ' ;
        }else{
            $sql = 'SELECT * from evalute ORDER BY create_date DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllProductEvaluatePage($id)) / 5)) . ' , 5 ' ;
        }
        
        $db = static::getDB();
        $data = $db->query($sql);
        $productEvaluate = $data->fetchAll();
        return $productEvaluate;
    }

}