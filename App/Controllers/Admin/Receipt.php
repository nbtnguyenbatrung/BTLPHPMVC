<?php

namespace App\Controllers\Admin;

use \Core\View;
use \Core\Router;
use \App\Models\ReceiptDTO;
use \Config\Admin\Auth;
use \Config\Config;

class Receipt extends Authenticated 
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
            View::renderTemplate('Admin/receipt.html' ,
             ['receipts' => $receipt->getAllReceipt($_GET['page']) , 
             'totalPage' => Config::getCeil(count($receipt->getAllReceiptPage()) / 5) ,
             'currentPage' => $_GET['page'] ] );
        }else{
            View::renderTemplate('Admin/receipt.html' , 
            ['receipts' => $receipt->getAllReceipt(1)  , 
            'totalPage' => Config::getCeil(count($receipt->getAllReceiptPage()) / 5) ,
            'currentPage' => 1 ] );

        }
    }

    public function receiptDeteilAction($id)
    {
        $receipt = new ReceiptDTO();
            View::renderTemplate('Admin/invoiceDetail.html' ,
             ['invoiceDetails' => $receipt->getAllInvoiceDetailByReceiptId($id) ,
             'receipt' => $receipt->getReceiptId($id) ] );
    }
}