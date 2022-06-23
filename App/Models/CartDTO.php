<?php

namespace App\Models;

use \Config\Config;
use PDO;

class CartDTO extends \Core\Model
{

    public function getCartCheckOut($user_id){

        $sql = 'SELECT product.name , product.price , product.price - product.price*promotion.percent/100 AS giasau ,
         cart.quantity AS quantity , product.pro_id
        FROM product LEFT JOIN promotion ON promotion.prom_id = product.prom_id
        INNER JOIN product_type ON product.pt_id = product_type.pt_id
        INNER JOIN cart ON product.pro_id = cart.pro_id
        WHERE cart.id = :user_id ' ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);    
        $stmt->execute();

        return $stmt->fetchAll();;
    }
    
}