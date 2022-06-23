<?php

namespace App\Controllers\Home;

use \Core\View;
use \Config\Config;
use \Config\User\AuthHomePage;
use \App\Models\TypeProductDTO;
use \App\Models\TrademarkDTO;
use \App\Models\PromotionDTO;
use \App\Models\GroupProductDTO;
use \App\Models\OrderDTO;

class Purchase extends AuthenticatedUser
{

    protected function before()
    {
        parent::before();

        $this->user = AuthHomePage::getUser();
    }


    public function indexAction()
    {
        $groupProducts = new GroupProductDTO();
        $trademark = new TrademarkDTO();
        $order = new OrderDTO();

        View::renderTemplate('User/purchase.html' ,
        [
        'groupProducts' => $groupProducts->getAllGroupProductPage(),
        'trademarks' => $trademark->getAllTrademarkPage() , 
        'carts' => $order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ),
        'sl' => count($order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ) )]);
       
    }
}