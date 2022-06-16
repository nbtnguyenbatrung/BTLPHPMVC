<?php

namespace App\Controllers\Admin;
use \Core\View;
use \App\Models\User;
use \Config\Admin\Auth;
use \Config\Flash;

class Login extends \Core\Controller {

    public function loginAction()
    {
        View::renderTemplate('Admin/login.html');
    }

    public function createAction()
    {

        $user = User::authenticate($_POST['email'], $_POST['password']);
        
        $remember_me = isset($_POST['remember_me']);

        if ($user) {
            
            
            Auth::login($user, $remember_me);

            $this->redirect('/?admin/admin/index');

        } else {

            Flash::addMessage('Login unsuccessful, please try again', Flash::WARNING);

            View::renderTemplate('Admin/login.html', [
                'email' => $_POST['email'],
                'remember_me' => $remember_me
            ]);
        }
    }
}