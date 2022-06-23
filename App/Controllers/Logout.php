<?php

namespace App\Controllers;

class Logout extends \Core\Controller {

    public function logout()
    {       
        $_SESSION = [];

        session_destroy();
        
        $this->redirect('/?login');
    }

    public function logoutUser()
    {       
        $_SESSION = [];

        session_destroy();
        
        $this->redirect('/?loginUser');
    }


}