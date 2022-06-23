<?php

namespace App\Models;

use \Config\Config;
use PDO;

class OrderDTO extends \Core\Model
{

    public function addReceipt($user_id, $name , $phone_number , $address){

        $sql = 'INSERT INTO receipt ( user_id , name , phone_number , address , status )
                VALUES ( :user_id, :name , :phone_number , :address , 1 )';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':name',$name, PDO::PARAM_STR);     
        $stmt->bindValue(':phone_number',$phone_number, PDO::PARAM_STR);    
        $stmt->bindValue(':address',$address, PDO::PARAM_STR);       
        $stmt->execute();

        $id = $db->lastInsertId();
        return $id;
    }

    public function addInvoice_detail($id, $pro_id , $quantity , $price  ){

        $sql = 'INSERT INTO invoice_detail ( id , pro_id , quantity , price , status  )
                VALUES ( :id, :pro_id , :quantity , :price , 0  )';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $quantity);
        $stmt->bindValue(':price', $price);     
        
        return $stmt->execute();
    }

    public function getShoppingCart($id){
        $sql = 'SELECT cart.pro_id , cart.id , product.name , cart.quantity , product.price AS price , product.image AS image,
         product.price - product.price*promotion.percent/100 AS giasau , product.quantity AS quantityProduct
         from cart INNER JOIN product ON cart.pro_id = product.pro_id
         LEFT JOIN promotion ON promotion.prom_id = product.prom_id
         WHERE id = :id  ' ;

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_STR);

        $stmt->execute();
        
        return $stmt->fetchAll();
    }

    public static function checkShoppingCart($id , $pro_id){

        $sql = 'SELECT * from cart WHERE id = :id AND pro_id = :pro_id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);

        // $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());FETCH_OBJ
        $stmt->setFetchMode(PDO::FETCH_OBJ);

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function shoppingCartFound($id , $pro_id){

        $order = static::checkShoppingCart($id , $pro_id);

        if ($order) {
            return true;
        }

        return false;

    }

    private static function checkQuantity($check , $quantity , $quantity2){

        return $check ? $quantity : $quantity2;
    }

    public function addCart($id , $pro_id , $quantity ){

        $order = static::checkShoppingCart($id , $pro_id);

        $sql = 'INSERT INTO cart ( id , pro_id , quantity  )
            VALUES ( :id, :pro_id , :quantity )';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);   
        $stmt->bindValue(':quantity', $quantity );   

       return  $stmt->execute();
    }

    public function addCartFound($id , $pro_id , $quantity ){

        $order = static::checkShoppingCart($id , $pro_id);

        $sql = 'UPDATE cart SET quantity = :quantity WHERE id = :id AND pro_id = :pro_id ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);   
        $stmt->bindValue(':quantity', $order->quantity + $quantity );   

       return  $stmt->execute();
    }

    public function updateCart($id , $pro_id , $quantity  ){

        $order = static::checkShoppingCart($id , $pro_id);
        
        $sql = ' UPDATE cart SET quantity = :quantity WHERE id = :id AND pro_id = :pro_id';       

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);

            $stmt->bindValue(':quantity',  $quantity);
       

        return  $stmt->execute();
    }

    public function deleteCart($id , $pro_id ){
        
        $sql = ' DELETE FROM cart WHERE id = :id AND pro_id = :pro_id';     

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);      

        return  $stmt->execute();
    }
    
}