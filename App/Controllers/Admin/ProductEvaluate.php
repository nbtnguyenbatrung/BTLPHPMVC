<?php

namespace App\Controllers\Admin;

use \Core\View;
use \Core\Router;
use \App\Models\ProductEvaluateDTO;
use \Config\Admin\Auth;
use \Config\Config;

class ProductEvaluate extends \Core\Controller 
{

    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }
    
    public function indexAction()
    {
        $productEvaluate = new ProductEvaluateDTO();
        $product = new ProductDTO() ;

        if (!empty($id)){
            if (!empty($_GET['page'])){
                View::renderTemplate('Admin/productEvaluate.html' ,
                 ['productEvaluates' => $productEvaluate->getAllGroupProduct($_GET['page']) , 
                 'totalPage' => Config::getCeil(count($productEvaluate->getAllGroupProductPage()) / 5) ,
                 'currentPage' => $_GET['page'] ] );
            }else{
                View::renderTemplate('Admin/productEvaluate.html' , 
                ['productEvaluates' => $productEvaluate->getAllGroupProduct(1)  , 
                'totalPage' => Config::getCeil(count($productEvaluate->getAllGroupProductPage()) / 5) ,
                'currentPage' => 1 ] );
    
            }
        }
        else{
            View::renderTemplate('Admin/productEvaluate.html'  ,
            ['productEvaluates' => $productEvaluate->getAllGroupProduct($_GET['page']) , 
            'products' =>  $product->getAllProductPage() ,
            'totalPage' => 0 ,
            'currentPage' => 0 ] );
        }
    }

}