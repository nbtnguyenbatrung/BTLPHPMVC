<?php

namespace App\Models;

use \Config\Config;
use PDO;

class ImageDTO extends \Core\Model
{

    
    public function getAllImage($id){
        $sql = 'SELECT * from image WHERE pro_id = ' . $id;

        $db = static::getDB();
        $data = $db->query($sql);
        $image = $data->fetchAll();
        return $image;
    }

    public function delete($id){
        $sql = ' DELETE FROM image WHERE img_id = :img_id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':img_id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function add($pro_id, $image){

        $sql = 'INSERT INTO image ( pro_id , image )
                VALUES ( :pro_id, :image )';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);
        $stmt->bindValue(':image',$image, PDO::PARAM_STR);        
        return $stmt->execute();
    }

    public function getImageProduct($id){
        $sql = 'SELECT * from image WHERE pro_id = ' . $id;

        $db = static::getDB();
        $data = $db->query($sql);
        $image = $data->fetchAll();
        return $image;
    }

}