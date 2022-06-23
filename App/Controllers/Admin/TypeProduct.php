<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\TypeProductDTO;
use \Config\Config;
use \App\Models\GroupProductDTO;
use \Config\Admin\Auth;

class TypeProduct extends Authenticated
{

    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }
    
    public function indexAction()
    {
        $typeProduct = new TypeProductDTO();
        $groupProduct = new GroupProductDTO();

        if (!empty($_GET['page'])){
            View::renderTemplate('Admin/typeProduct.html' ,
             ['typeProducts' => $typeProduct->getAllTypeProduct($_GET['page']),
             'groupProducts' => $groupProduct->getAllGroupProductPage(),
             'totalPage' => Config::getCeil(count($typeProduct->getAllTypeProductPage()) / 5) ,
             'currentPage' => $_GET['page']] );
        }else{
            View::renderTemplate('Admin/typeProduct.html' ,
             ['typeProducts' => $typeProduct->getAllTypeProduct(1),
             'groupProducts' => $groupProduct->getAllGroupProductPage(),
             'totalPage' => Config::getCeil(count($typeProduct->getAllTypeProductPage()) / 5) ,
            'currentPage' => 1] );
        }
    }

    public function get()
    {
        $typeProduct = new TypeProductDTO();

        return $typeProduct->getTypeProduct(1) ;
        
    }

    public function update()
    {
        $typeProduct = new TypeProductDTO();
        $typeProduct->update() ;
        $this->redirect("/?admin/type-product/index"); 

    }
    public function delete($id)
    {
        $typeProduct = new TypeProductDTO();
        $typeProduct->delete($id) ; 

        $this->redirect("/?admin/type-product/index"); 
    }

    public function add()
    {
        $typeProduct = new TypeProductDTO();
        $typeProduct->add() ; 
        
        $this->redirect("/?admin/type-product/index"); 
    }

}