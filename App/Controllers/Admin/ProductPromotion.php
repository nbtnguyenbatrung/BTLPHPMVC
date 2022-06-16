<?php

namespace App\Controllers\Admin;

use \Core\View;
use \Core\Router;
use \App\Models\ProductPromotionDTO;
use \Config\Admin\Auth;
use \Config\Config;
use \App\Models\ProductDTO;
use \App\Models\PromotionDTO;

class ProductPromotion extends \Core\Controller 
{

    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }
    
    public function indexAction()
    {
        $productPromotion = new ProductPromotionDTO();
        $product = new ProductDTO();
        $promotion = new PromotionDTO();

        if (!empty($_GET['page'])){
            View::renderTemplate('Admin/productPromotion.html' ,
             ['productPromotions' => $productPromotion->getAllProductPromotion($_GET['page']) , 
             'products' => $product->getAllProductPage(),
             'promotions'=> $promotion->getAllPromotionPage(),
             'totalPage' => Config::getCeil(count($productPromotion->getAllProductPromotionPage()) / 5) ,
             'currentPage' => $_GET['page'] ] );
        }else{
            View::renderTemplate('Admin/productPromotion.html' , 
            ['productPromotions' => $productPromotion->getAllProductPromotion(1)  , 
            'products' => $product->getAllProductPage(),
             'promotions'=> $promotion->getAllPromotionPage(),
            'totalPage' => Config::getCeil(count($productPromotion->getAllProductPromotionPage()) / 5) ,
            'currentPage' => 1 ] );

        }
    }

    public function add()
    {
        $productPromotion = new ProductPromotionDTO();

        $productPromotion->update() ; 
        $this->redirect("/?admin/product-promotion/index"); 
    }
}