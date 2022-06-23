<?php

namespace App\Controllers\Admin;

use \Core\View;
use \Core\Router;
use \App\Models\UserAccountDTO;
use \Config\Admin\Auth;
use \Config\Config;

class User extends Authenticated
{

    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }
    
    public function indexAction()
    {
        $user = new UserAccountDTO();

        if (!empty($_GET['page'])){
            View::renderTemplate('Admin/user.html' ,
             ['users' => $user->getAllUser($_GET['page']) , 
             'totalPage' => Config::getCeil(count($user->getAllUserPage()) / 5) ,
             'currentPage' => $_GET['page'],
             'urlDelete'=> $_SERVER['HTTP_HOST']."/?admin/user/disable" ] );
        }else{
            View::renderTemplate('Admin/user.html' , 
            ['users' => $user->getAllUser(1)  , 
            'totalPage' => Config::getCeil(count($user->getAllUserPage()) / 5) ,
            'currentPage' => 1 ,
            'urlDelete'=> $_SERVER['HTTP_HOST']."/?admin/user/disable" ] );

        }
    }

    public function disable()
    {
        $user = new UserAccountDTO();

        if($_GET["status"] == 0){
            $user->disable($_GET["id"] ) ;
        }elseif($_GET["status"] == 1){
            $user->active($_GET["id"] ) ;
        } 

        $this->redirect("/?admin/user/index") ;
    }

    public function add()
    {
        $user = new UserAccountDTO();

        $user->add() ; 
        $this->redirect("/?admin/user/index") ;
    }

    public function validatePhone(){
        $pattern = '/^\+\d(\d{3})(\d{3})(\d{4})$/';
        $is_valid = false ;
        if(preg_match($pattern, $_GET["phone_number"], $match) == 1){
            $is_valid = true;
        };
        header('Content-Type: application/json');
        echo json_encode($is_valid);

    }

    public function emailExist(){
        $user = new UserAccountDTO();

        $is_valid = ! $user->emailFound($_GET['email']);
        
        header('Content-Type: application/json');
        echo json_encode($is_valid);

    }

    public function editProfile(){
        $user = new UserAccountDTO();
        $user->editProfile();
        $this->redirect("/?admin/admin/index") ;
    }

    public static function confimPassword($newPass , $confimPass){

        $check = false ;

        if ($newPass == $confimPass){
            $check = true ;
        }

        return $check ;
    }

    public static function wrongPassword(){
        $user = new UserAccountDTO();
        $user->notFound() ;

        $is_valid = ! $user->notFound();
        
        return $is_valid ;
    }
    

    public function changePassword(){
        
        $check = true ;
        if (!static::confimPassword($_POST["newPass"] , $_POST["confirmPass"] )){
            echo " Xác nhận mật khẩu không thành công  " ;
            $check = false ;
        }

        if (!static::wrongPassword()){
            echo " mật khẩu cũ không đúng " ;
            $check = false ;
        }

        if($check){
            $user = new UserAccountDTO();
            $user->updateChangePassword() ;
        }


    }

    public function resetPassword(){

        $user = new UserAccountDTO();
        $user->resetPassword() ;

        $this->redirect("/?admin/admin/index") ;
    }
}