<?php

namespace App\Controllers\Admin;

use \Core\View;
use \Core\Router;
use \App\Models\GroupProductDTO;
use \Config\Admin\Auth;
use \Config\Config;

class GroupProduct extends \Core\Controller 
{

    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }
    
    public function indexAction()
    {
        $groupProduct = new GroupProductDTO();

        if (!empty($_GET['page'])){
            View::renderTemplate('Admin/groupProduct.html' ,
             ['groupProducts' => $groupProduct->getAllGroupProduct($_GET['page']) , 
             'totalPage' => Config::getCeil(count($groupProduct->getAllGroupProductPage()) / 5) ,
             'currentPage' => $_GET['page'] ] );
        }else{
            View::renderTemplate('Admin/groupProduct.html' , 
            ['groupProducts' => $groupProduct->getAllGroupProduct(1)  , 
            'totalPage' => Config::getCeil(count($groupProduct->getAllGroupProductPage()) / 5) ,
            'currentPage' => 1 ] );

        }
    }

    public function get()
    {
        $groupProduct = new GroupProductDTO();

        return $groupProduct->getGroupProduct(1) ;
        
    }

    public function update()
    {
        $groupProduct = new GroupProductDTO();
        $groupProduct->update() ; 
        $this->redirect("/?admin/group-product/index") ;
    
    }
    public function delete($id)
    {
        $groupProduct = new GroupProductDTO();
        $groupProduct->delete($id) ; 

        $this->redirect("/?admin/group-product/index") ;
    }

    public function add()
    {
        $groupProduct = new GroupProductDTO();

        if ($groupProduct->nameFound($_POST["name"])){
            echo " Tên đã được sử  ";
        }else{
            $groupProduct->add() ; 
            $this->redirect("/?admin/group-product/index") ;
        }
    }


    public function nameExist(){

        $groupProduct = new GroupProductDTO();

        $is_valid = ! $groupProduct->nameFound($_GET['name']);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);
    }
}