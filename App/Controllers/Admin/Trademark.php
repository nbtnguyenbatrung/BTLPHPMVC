<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\TrademarkDTO;
use \Config\Admin\Auth;
use \Config\Config;

class Trademark extends \Core\Controller 
{
    
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    public function indexAction()
    {
        $trademark = new TrademarkDTO();

        if (!empty($_GET['page'])){
            View::renderTemplate('Admin/trademark.html' ,
             ['trademarks' => $trademark->getAllTrademark($_GET['page']) , 
             'totalPage' => Config::getCeil(count($trademark->getAllTrademarkPage()) / 5) ,
             'currentPage' => $_GET['page'] ] );
        }else{
            View::renderTemplate('Admin/trademark.html' , 
            ['trademarks' => $trademark->getAllTrademark(1)  , 
            'totalPage' => Config::getCeil(count($trademark->getAllTrademarkPage()) / 5) ,
            'currentPage' => 1 ] );

        }
    }

    public function get()
    {
        $trademark = new TrademarkDTO();

        return $trademark->getTrademark(1) ;
        
    }

    public function update()
    {
        $trademark = new TrademarkDTO();
        $trademark->update() ; 
        $this->redirect("/?admin/trademark/index"); 
    }
    public function delete($id)
    {
        $trademark = new TrademarkDTO();
        $trademark->delete($id) ; 

        $this->redirect("/?admin/trademark/index"); 
    }

    public function add()
    {
        $trademark = new TrademarkDTO();

        $trademark->add() ; 
        $this->redirect("/?admin/trademark/index"); 
    }

}