<?php

namespace App\Models;
use \Config\Config;
use PDO;

class ReceiptDTO extends \Core\Model
{

    public function getAllReceiptPage(){
        
        $sql = 'SELECT receipt.id , receipt.create_date , SUM(invoice_detail.price) AS giatri
        FROM receipt INNER JOIN invoice_detail ON receipt.id = invoice_detail.id
        GROUP BY receipt.id , receipt.create_date ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $receipt = $data->fetchAll();
        return $receipt;
    }

    public function getAllReceipt($currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllReceiptPage()) / 5) ){
            $sql = 'SELECT receipt.id , receipt.create_date , SUM(invoice_detail.price) AS giatri
            FROM receipt INNER JOIN invoice_detail ON receipt.id = invoice_detail.id
            GROUP BY receipt.id , receipt.create_date 
            ORDER BY create_date DESC LIMIT ' . Config::getPage($currentPage , 5) . ' , 5 ' ;
        
        }else{
            $sql = 'SELECT receipt.id , receipt.create_date , SUM(invoice_detail.price) AS giatri
            FROM receipt INNER JOIN invoice_detail ON receipt.id = invoice_detail.id
            GROUP BY receipt.id , receipt.create_date 
            ORDER BY create_date DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllReceiptPage()) / 5) , 5) . ' , 5 ' ;
        }

        $db = static::getDB();
        $data = $db->query($sql);
        $receipt = $data->fetchAll();
        return $receipt;
    }

    public function getReceiptId($id){
        
        $sql = 'SELECT *
        FROM receipt 
        WHERE id = ' .$id ;

        $db = static::getDB();
        $data = $db->query($sql);
        $receipt = $data->fetch();
        return $receipt;
    }

    public function getAllInvoiceDetailByReceiptId($id){
        
        $sql = 'SELECT product.* , invoice_detail.quantity AS quantityDetail , invoice_detail.price AS priceDetail , 
        invoice_detail.status AS statusDetail
        FROM invoice_detail INNER JOIN product ON invoice_detail.pro_id = product.pro_id
        WHERE id = ' .$id ;

        $db = static::getDB();
        $data = $db->query($sql);
        $receipt = $data->fetchAll();
        return $receipt;
    }

    public function getAllInvoiceDetailByStatusPage(){
        
        $sql = 'SELECT product.* , invoice_detail.quantity AS quantityDetail , invoice_detail.price AS priceDetail , 
        invoice_detail.status AS statusDetail
        FROM invoice_detail INNER JOIN product ON invoice_detail.pro_id = product.pro_id 
        WHERE invoice_detail.status = 0
        ORDER BY invoice_detail.id';

        $db = static::getDB();
        $data = $db->query($sql);
        $order = $data->fetchAll();
        return $order;
    }

    public function getAllInvoiceDetailByStatus($currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllInvoiceDetailByStatusPage()) / 5) ){
            $sql = 'SELECT product.* , invoice_detail.quantity AS quantityDetail , invoice_detail.price AS priceDetail , 
            invoice_detail.status AS statusDetail , invoice_detail.id AS id , invoice_detail.pro_id AS pro_idDetail
            FROM invoice_detail INNER JOIN product ON invoice_detail.pro_id = product.pro_id 
            WHERE invoice_detail.status = 0
            ORDER BY invoice_detail.id DESC LIMIT ' . Config::getPage($currentPage , 5) . ' , 5 ' ;
        
        }else{
            $sql = 'SELECT product.* , invoice_detail.quantity AS quantityDetail , invoice_detail.price AS priceDetail , 
            invoice_detail.status AS statusDetail , invoice_detail.id AS id
            FROM invoice_detail INNER JOIN product ON invoice_detail.pro_id = product.pro_id 
            WHERE invoice_detail.status = 0
            ORDER BY invoice_detail.id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllInvoiceDetailByStatusPage()) / 5) , 5) . ' , 5 ' ;
        }

        $db = static::getDB();
        $data = $db->query($sql);
        $order = $data->fetchAll();
        return $order;
    }

    public function updateDuyet($id , $pro_id){

        $sql = ' UPDATE invoice_detail SET status = 1 WHERE id = :id AND pro_id = :pro_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function updateNoDuyet($id , $pro_id){

        $sql = ' UPDATE invoice_detail SET status = 2 WHERE id = :id AND pro_id = :pro_id';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':pro_id', $pro_id, PDO::PARAM_INT);

        return $stmt->execute();
    }

}