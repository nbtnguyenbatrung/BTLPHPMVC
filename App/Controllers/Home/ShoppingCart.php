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

class ShoppingCart extends AuthenticatedUser
{

    protected function before()
    {
        parent::before();

        $this->user = AuthHomePage::getUser();
    }


    public function indexAction($id)
    {
        $groupProducts = new GroupProductDTO();
        $trademark = new TrademarkDTO();
        $order = new OrderDTO();
        $tong = 0;
        foreach ($order->getShoppingCart($id) as $row) {

            if($row["giasau"] > 0){
                $tong += $row["giasau"] * $row["quantity"] ;
            }else{
                $tong += $row["price"] * $row["quantity"] ;
            }
            
        }

        View::renderTemplate('User/shopping-cart.html',[
            'carts' => $order->getShoppingCart($id),
            'tong' => $tong,
            'trademarks' => $trademark->getAllTrademarkPage(),
            'groupProducts' => $groupProducts->getAllGroupProductPage(),
            'carts' => $order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ),
            'sl' => count($order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ) )
        ] );
    }

    public function addAction($id)
    {
        
        $order = new OrderDTO();
        if($order->shoppingCartFound($id , $_POST['pro_id'])){
            
            $order->addCartFound($id , $_POST['pro_id'] , $_POST['quantity']) ;

        }else{

            $order->addCart($id , $_POST['pro_id'] , $_POST['quantity']) ;
        }
        
    }

    public function updatePlusAction($id)
    {
        
        $order = new OrderDTO();
        $order->updateCart($id , $_POST['pro_id'] , $_POST['quantity'] ) ;
    }

    public function updateMinusAction($id)
    {
        
        $order = new OrderDTO();
        $order->updateCart($id , $_POST['pro_id'] , $_POST['quantity'] ) ;
    }

    public function deleteAction($id)
    {
        
        $order = new OrderDTO();
        $order->deleteCart($id , $_POST['pro_id'] ) ;
    }

}