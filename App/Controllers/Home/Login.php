<?php

namespace App\Controllers\Home;

use \Core\View;
use \App\Models\User;
use \Config\User\AuthHomePage;
use \Config\Flash;
use \App\Models\ProductDTO;
use \App\Models\TypeProductDTO;
use \App\Models\TrademarkDTO;
use \App\Models\PromotionDTO;
use \App\Models\GroupProductDTO;
use \App\Models\UserAccountDTO;
/**
 * Home controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{

    /**
     * Show the index page
     *
     * @return void
     */
    public function newAction()
    {
        $product = new ProductDTO();
        $typeProduct = new TypeProductDTO();
        $trademark = new TrademarkDTO();
        $promotion = new PromotionDTO();
        $groupProducts = new GroupProductDTO();
        View::renderTemplate('User/login.html' ,
        ['productLaptops' => $product->getAllProductViewLaptop() , 
        'productLinhKiens' => $product->getAllProductViewLinkien() ,
        'groupProducts' => $groupProducts->getAllGroupProductPage(),
        'trademarks' => $trademark->getAllTrademarkPage(),
        'promotions' => $promotion->getAllPromotionView()]);
    }

    public function registerAction()
    {
        $product = new ProductDTO();
        $typeProduct = new TypeProductDTO();
        $trademark = new TrademarkDTO();
        $promotion = new PromotionDTO();
        $groupProducts = new GroupProductDTO();
        View::renderTemplate('User/register.html' , 
        ['productLaptops' => $product->getAllProductViewLaptop() , 
        'productLinhKiens' => $product->getAllProductViewLinkien() ,
        'groupProducts' => $groupProducts->getAllGroupProductPage(),
        'trademarks' => $trademark->getAllTrademarkPage(),
        'promotions' => $promotion->getAllPromotionView()]);
    }

    public function createAction()
    {

        $product = new ProductDTO();
        $typeProduct = new TypeProductDTO();
        $trademark = new TrademarkDTO();
        $promotion = new PromotionDTO();
        $groupProducts = new GroupProductDTO();
        $user = User::authenticateUser($_POST['username'], $_POST['pass']);
        
        $remember_me = isset($_POST['save-pass']);

        if ($user) {
            
            
            AuthHomePage::login($user, $remember_me);

            $this->redirect('/');

        } else {

            Flash::addMessage('Login unsuccessful, please try again', Flash::WARNING);

            View::renderTemplate('User/login.html', [
                'username' => $_POST['username'],
                'remember_me' => $remember_me,
                'productLaptops' => $product->getAllProductViewLaptop() , 
                'productLinhKiens' => $product->getAllProductViewLinkien() ,
                'groupProducts' => $groupProducts->getAllGroupProductPage(),
                'trademarks' => $trademark->getAllTrademarkPage(),
                'promotions' => $promotion->getAllPromotionView()
            ]);
        }
    }


    public function addAction()
    {

        $product = new ProductDTO();
        $typeProduct = new TypeProductDTO();
        $trademark = new TrademarkDTO();
        $promotion = new PromotionDTO();
        $groupProducts = new GroupProductDTO();
        $user = new UserAccountDTO();

        $check = true ;
        $checkEmail = false ;
        $checkConfim = false ;

        if ($user->emailFound($_POST['email'])) {
                        
            $checkEmail = true;
            $check = false;

        }

        if ($_POST['password'] != $_POST['con_password'] ){
            $checkConfim = true;
            $check = false;
        }

        if($checkEmail){
            Flash::addMessage('Email đã được sử dụng , vui lòng chọn email khác', Flash::WARNING);

            View::renderTemplate('User/register.html', [
                'name' => $_POST['name'],
                'phone_number' => $_POST['phone_number'],
                'email' => $_POST['email'],
                'productLaptops' => $product->getAllProductViewLaptop() , 
                'productLinhKiens' => $product->getAllProductViewLinkien() ,
                'groupProducts' => $groupProducts->getAllGroupProductPage(),
                'trademarks' => $trademark->getAllTrademarkPage(),
                'promotions' => $promotion->getAllPromotionView()
            ]);
        }

        if($checkConfim){
            Flash::addMessage('Xác nhận mật khẩu không đùng , xin kiểm tra lại', Flash::WARNING);

            View::renderTemplate('User/register.html', [
                'name' => $_POST['name'],
                'phone_number' => $_POST['phone_number'],
                'email' => $_POST['email'],
                'productLaptops' => $product->getAllProductViewLaptop() , 
                'productLinhKiens' => $product->getAllProductViewLinkien() ,
                'groupProducts' => $groupProducts->getAllGroupProductPage(),
                'trademarks' => $trademark->getAllTrademarkPage(),
                'promotions' => $promotion->getAllPromotionView()
            ]);
        }

        if($check){
            
           $user->addUser() ;
           $user = User::authenticateUser($_POST['email'], $_POST['password']);
           AuthHomePage::login($user, $remember_me);

            $this->redirect('/');
        }

    }

    public function resetPassword(){

        $user = new UserAccountDTO();
        $user->resetPassword() ;

        $this->redirect("/?admin/admin/index") ;
    }


    public function changePassword(){

        $user = new UserAccountDTO();

        if($user->notFound()){
            
            $user->updateChangePassword();
        }else{
            echo " mật khẩu cũ không chính xác " ;
        }
        
    }

}
