<?php

namespace App\Controllers\Home;

use \Core\View;
use \App\Models\User;
use \Config\Admin\Auth;
use \Config\Flash;
use \App\Models\ProductDTO;
use \App\Models\TypeProductDTO;
use \App\Models\TrademarkDTO;
use \App\Models\PromotionDTO;
use \App\Models\GroupProductDTO;
use \App\Models\OrderDTO;
/**
 * Home controller
 *
 * PHP version 7.0
 */
class Contact extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function indexAction()
    {

        $product = new ProductDTO();
        $typeProduct = new TypeProductDTO();
        $trademark = new TrademarkDTO();
        $promotion = new PromotionDTO();
        $groupProducts = new GroupProductDTO();
        $order = new OrderDTO();
        View::renderTemplate('User/contact.html' , ['productLaptops' => $product->getAllProductViewLaptop() , 
        'productLinhKiens' => $product->getAllProductViewLinkien() ,
        'groupProducts' => $groupProducts->getAllGroupProductPage(),
        'trademarks' => $trademark->getAllTrademarkPage(),
        'promotions' => $promotion->getAllPromotionView(),
        'carts' => $order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ),
        'sl' => count($order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ) ) ]);
    }
}
