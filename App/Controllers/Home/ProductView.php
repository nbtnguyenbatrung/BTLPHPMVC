<?php

namespace App\Controllers\Home;

use \Core\View;
use \App\Models\ProductDTO;
use \App\Models\TypeProductDTO;
use \App\Models\TrademarkDTO;
use \App\Models\GroupProductDTO;
use \App\Models\ImageDTO;
use \App\Models\EvaluateDTO;
use \Config\Config;
use \App\Models\OrderDTO;

class ProductView extends \Core\Controller 
{

    public function shopAction()
    {

        $product = new ProductDTO();
        $typeProduct = new TypeProductDTO();
        $trademark = new TrademarkDTO();
        $groupProducts = new GroupProductDTO();
        $order = new OrderDTO();

        $search = "" ;
        $group = "" ;
        $type = "" ;
        $brand = "" ;
        $currentPage = 1 ;
        $url = "";
        $urlSearch = "";
        $urlType = "";
        $urlGroup = "";
        $urlBrand = "";

        if (!empty($_GET['search']) && $_GET['search'] != "" ){
            $search = $_GET['search'];

            $url .= "&search=" . $_GET['search'];
            $urlType .= "&search=" . $_GET['search'];
            $urlGroup .= "&search=" . $_GET['search'];
            $urlBrand .= "&search=" . $_GET['search'];
        }
        if (!empty($_GET['group']) && $_GET['group'] != "" ){
            $group = $_GET['group'];
            $url .= "&group=" . $_GET['group'];
            $urlSearch .= "&group=" . $_GET['group'];
            $urlType .= "&group=" . $_GET['group'];
            $urlBrand .= "&group=" . $_GET['group'];
        }
        if (!empty($_GET['type']) && $_GET['type'] != "" ){
            $type = $_GET['type'];
            $url .= "&type=" . $_GET['type'];
            $urlSearch .= "&type=" . $_GET['type'];
            $urlGroup .= "&type=" . $_GET['type'];
            $urlBrand .= "&type=" . $_GET['type'];
        }
        if (!empty($_GET['brand']) && $_GET['brand'] != "" ){
            $brand = $_GET['brand'];
            $url .= "&brand=" . $_GET['brand'];
            $urlSearch .= "&brand=" . $_GET['brand'];
            $urlGroup .= "&brand=" . $_GET['brand'];
            $urlType .= "&brand=" . $_GET['brand'];
        }
        if (!empty($_GET['page']) && $_GET['page'] != "" ){
            $currentPage = $_GET['page'];
            $url .= "&page=";
            $urlSearch .= "&page=";
            $urlType .= "&page=";
            $urlGroup .= "&page=";
            $urlBrand .= "&page=";
        }else{
            $url .= "&page=" ;
            $urlSearch .= "&page=";
            $urlType .= "&page=";
            $urlGroup .= "&page=";
            $urlBrand .= "&page=";
        }
        
        View::renderTemplate('User/shop.html' ,
             ['products' => $product->getAllProductShop( $search , $group , $type , $brand , $currentPage ),
             'typeProducts' => $typeProduct->getAllTypeProductPage(),
             'groupProducts' => $groupProducts->getAllGroupProductPage(),
             'trademarks' => $trademark->getAllTrademarkPage(),
             'search' => $search,
             'group' => $group,
             'type' => $type,
             'brand' => $brand,
             'url' => $url,
             'urlSearch' => $urlSearch,
             'urlSearch' => $urlSearch,
             'urlType' => $urlType,
             'urlGroup' => $urlGroup,
             'urlBrand' => $urlBrand,
             'totalPage' => Config::getCeil(count($product->getAllProductShopPage($search , $group , $type , $brand)) / 9) ,
             'currentPage' => $currentPage ,
             'carts' => $order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ),
             'sl' => count($order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ) )  ]);
    }

    public function detailAction($id)
    {
        $product = new ProductDTO();
        $image = new ImageDTO();
        $evaluate = new EvaluateDTO();
        $order = new OrderDTO();

        if (!empty($_GET['pageEvalute'])){

            View::renderTemplate('User/product.html' ,
            ['product' => $product->getProductId($id) ,
           'images' => $image->getImageProduct($id),
           'productSimilars'=> $product->getProductSimilar($id),
           'evaluates' => $evaluate->getAlllEvaluateByProductId($id , $_GET['pageEvalute']),
           'totalPage' => Config::getCeil(count($evaluate->getAlllEvaluateByProductId($id)) / 5) ,
           'currentPage' => $_GET['pageEvalute'] , 
           'carts' => $order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ),
           'sl' => count($order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ) )]);

        }else{

            View::renderTemplate('User/product.html' ,
             ['product' => $product->getProductId($id) ,
            'images' => $image->getImageProduct($id),
            'productSimilars'=> $product->getProductSimilar($id),
            'evaluates' => $evaluate->getAlllEvaluateByProductId($id , 1),
            'totalPage' => Config::getCeil(count($evaluate->getAlllEvaluateByProductId($id)) / 5) ,
            'currentPage' => 1 ,
            'carts' => $order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ),
             'sl' => count($order->getShoppingCart( !empty($_SESSION['userHomePage_id']) ? $_SESSION['userHomePage_id'] : -1 ) ) ]);

        }
    
    }
}