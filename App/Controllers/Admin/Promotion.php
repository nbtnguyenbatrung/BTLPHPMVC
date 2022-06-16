<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\PromotionDTO;
use \Config\Admin\Auth;
use \Config\Config;

class Promotion extends \Core\Controller 
{

    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    public function indexAction()
    {
        $promotion = new PromotionDTO();

        if (!empty($_GET['page'])){
            View::renderTemplate('Admin/promotion.html' ,
             ['promotions' => $promotion->getAllPromotion($_GET['page']) , 
             'totalPage' => Config::getCeil(count($promotion->getAllPromotionPage()) / 5) ,
             'currentPage' => $_GET['page'] ] );
        }else{
            View::renderTemplate('Admin/promotion.html' , 
            ['promotions' => $promotion->getAllPromotion(1)  , 
            'totalPage' => Config::getCeil(count($promotion->getAllPromotionPage()) / 5) ,
            'currentPage' => 1 ] );

        }

    }

    public function get()
    {
        $promotion = new PromotionDTO();

        return $promotion->getGroupProduct(1) ;
        
    }

    public function update()
    {
        $promotion = new PromotionDTO();
        $promotion->update() ; 
        $this->redirect("/?admin/promotion/index") ;
    
    }
    public function delete($id)
    {
        $promotion = new PromotionDTO();
        $promotion->delete($id) ; 

        $this->redirect("/?admin/promotion/index") ;
    }

    public function add()
    {
        $promotion = new PromotionDTO();

         $check = true ;
         if(!is_numeric($_POST['percent'])){
            $check = false ;
            echo " Phần trăm khuyến mại phải là số  ";
         }

         if(!static::checkDate($_POST['from_date'] ,$_POST['to_date'])){
            $check = false ;
            echo " ngày bắt đầu phải nhỏ hơn ngày kết thúc  ";
         }

        if ($check){
            $promotion->add() ; 
            $this->redirect("/?admin/promotion/index") ;;
        }
    }

    public static function checkDate($from_date , $to_date){
        if (strtotime($from_date) > strtotime($to_date)) {
           return false ;
        } else {
            return true ;
        }
    }  
}     