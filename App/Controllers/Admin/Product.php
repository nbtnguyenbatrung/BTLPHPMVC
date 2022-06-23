<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\ProductDTO;
use \App\Models\TypeProductDTO;
use \App\Models\TrademarkDTO;
use \App\Models\PromotionDTO;
use \Config\Admin\Auth;
use \Config\Config;

class Product extends Authenticated
{
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    public function indexAction()
    {
        $product = new ProductDTO();
        $typeProduct = new TypeProductDTO();
        $trademark = new TrademarkDTO();
        $promotion = new PromotionDTO();

        if (!empty($_GET['page'])){
            View::renderTemplate('Admin/product.html' ,
             ['products' => $product->getAllProduct($_GET['page']) , 
             'typeProducts' => $typeProduct->getAllTypeProductPage(),
             'trademarks' => $trademark->getAllTrademarkPage(),
             'promotions' => $promotion->getAllPromotionPage(),
             'totalPage' => Config::getCeil(count($product->getAllProductPage()) / 5) ,
             'currentPage' => $_GET['page'],
             'tab3'=> true ] );
        }else{
            View::renderTemplate('Admin/product.html' , 
            ['products' => $product->getAllProduct(1)  , 
            'typeProducts' => $typeProduct->getAllTypeProductPage(),
            'trademarks' => $trademark->getAllTrademarkPage(),
            'promotions' => $promotion->getAllPromotionPage(),
            'totalPage' => Config::getCeil(count($product->getAllProductPage()) / 5) ,
            'currentPage' => 1 ] );

        }
    }

    public function get()
    {
        $product = new ProductDTO();

        return $product->getProduct(1) ;
        
    }

    public function update()
    {
        $product = new ProductDTO();
        $product->update() ; 
        $this->redirect("/?admin/product/index"); 
    }
    public function delete($id)
    {
        $product = new ProductDTO();
        $product->delete($id) ; 

        $this->redirect("/?admin/product/index"); 
    }

    public function add()
    {
        $product = new ProductDTO();

        $product->add() ; 
        $this->redirect("/?admin/product/index"); 
    }
}