<?php

namespace App\Controllers\Admin;

use \Core\View;
use \Core\Router;
use \App\Models\ReceiptDTO;
use \Config\Admin\Auth;
use \Config\Config;

class Order extends Authenticated 
{

    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }
    
    public function indexAction()
    {
        $receipt = new ReceiptDTO();

        if (!empty($_GET['page'])){
            View::renderTemplate('Admin/order.html' ,
             ['orders' => $receipt->getAllInvoiceDetailByStatus($_GET['page']) , 
             'totalPage' => Config::getCeil(count($receipt->getAllInvoiceDetailByStatusPage()) / 5) ,
             'currentPage' => $_GET['page'] ] );
        }else{
            View::renderTemplate('Admin/order.html' , 
            ['orders' => $receipt->getAllInvoiceDetailByStatus(1)  , 
            'totalPage' => Config::getCeil(count($receipt->getAllInvoiceDetailByStatusPage()) / 5) ,
            'currentPage' => 1 ] );

        }
    }

    public function duyetAction()
    {
        $receipt = new ReceiptDTO();

        $receipt->updateDuyet($_POST['id'] , $_POST['pro_id']);
        
    }

    public function noDuyetAction()
    {
        $receipt = new ReceiptDTO();

        $receipt->updateNoDuyet($_POST['id'] , $_POST['pro_id']);
    }

    public function duyetAll()
    {
        $receipt = new ReceiptDTO();

         $name = $_POST['list'];
        foreach ($name as $k => $name) {
            $id = substr( $name, 0 , strpos($name, "-") ) ;
            $pro_id = substr( $name, strpos($name, "-") + 1) ;

            if ($_POST['key'] == 1){
                $receipt->updateDuyet($id , $pro_id);
            }else{
                $receipt->updateNoDuyet($id , $pro_id);
            }
        }

    }
}