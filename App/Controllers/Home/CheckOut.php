<?php

namespace App\Controllers\Home;

use \Core\View;
use \Config\Config;
use \Config\User\AuthHomePage;
use \App\Models\TypeProductDTO;
use \App\Models\TrademarkDTO;
use \App\Models\PromotionDTO;
use \App\Models\CartDTO;
use \App\Models\ProductDTO;
use \App\Models\OrderDTO;
use \App\Models\GroupProductDTO;

class CheckOut extends AuthenticatedUser
{

    protected function before()
    {
        parent::before();

        $this->user = AuthHomePage::getUser();
    }


    public function indexAction()
    {
        $product = new ProductDTO();
        $typeProduct = new TypeProductDTO();
        $trademark = new TrademarkDTO();
        $promotion = new PromotionDTO();
        $groupProducts = new GroupProductDTO();
        $order = new OrderDTO();

        if (!empty($_GET['check']) && $_GET['check'] = true ){

            View::renderTemplate('User/check-out.html',
        [ 'products' => $product->getAllProductCheckOut( $_GET['pro_id'] ),
          'quantity'=> $_GET['quantity'],
          'productLaptops' => $product->getAllProductViewLaptop() , 
          'productLinhKiens' => $product->getAllProductViewLinkien() ,
          'groupProducts' => $groupProducts->getAllGroupProductPage(),
          'trademarks' => $trademark->getAllTrademarkPage(),
          'promotions' => $promotion->getAllPromotionView() ] );

        }else{

            View::renderTemplate('User/check-out.html',
        [ 'products' => $product->getAllProductCheckOut( $_GET['pro_id'] ),
          'quantity'=> $_GET['quantity'],
          'productLaptops' => $product->getAllProductViewLaptop() , 
          'productLinhKiens' => $product->getAllProductViewLinkien() ,
          'groupProducts' => $groupProducts->getAllGroupProductPage(),
          'trademarks' => $trademark->getAllTrademarkPage(),
          'promotions' => $promotion->getAllPromotionView(),
          'carts' => $order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ),
          'sl' => count($order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ) ) ] );

        }
    
       
    }

    public function orderAction()
    {
        $product = new ProductDTO();
        View::renderTemplate('User/check-out.html',
        [ 'product' => $product->getAllProductCheckOut( $_GET['pro_id'] ),
        'quantity'=> $_GET['quantity'] ] );
       
    }

    private static function checkPrice($giasau , $price){

        return $giasau > 0 ? $giasau : $price;
    }
    public function addOrderAction()
    {

        $product = new ProductDTO();
        $order = new OrderDTO();
        $productOrder = $product->getAllProductCheckOut( $_GET['pro_id'] ) ;
        $order->addInvoice_detail( $order->addReceipt($_GET['user_id'] , $_GET['name'] , $_GET['phone'] , $_GET['address'] ) ,
        $_GET['pro_id'] , $_GET['quantity'] , static::checkPrice($productOrder[0]->giasau , $productOrder[0]->price)  ) ;

        $productCheckOut = $product->getProductAfterId($_GET['pro_id']);
        
        $product->getUpdateAfterCheckOut( $_GET['pro_id'] , $productCheckOut->quantity - $_GET['quantity']);

        $this->redirect("/"); 
       
    }

    public function checkOutAction($id)
    {

        $cart = new CartDTO();

        View::renderTemplate('User/check-out.html',
        [ 'carts' => $cart->getCartCheckOut( $id ),
           'check' => $_GET['check'] ] );
       
    }

    public function addOutAction()
    {

        $product = new ProductDTO();
        $order = new OrderDTO();

        foreach ($order->getShoppingCart($_GET['user_id']) as $row) {

            $order->addInvoice_detail( $order->addReceipt($_GET['user_id'] , $_GET['name'] , $_GET['phone'] , $_GET['address'] ) ,
            $row['pro_id'] , $row['quantity'] , static::checkPrice($row['giasau'] , $row['price'])  ) ;
           
            $productCheckOut = $product->getProductAfterId($row['pro_id']);
        
            $product->getUpdateAfterCheckOut( $row['pro_id'] , $productCheckOut->quantity - $row['quantity']);
            
        }

        $this->redirect("/"); 
       
    }
}