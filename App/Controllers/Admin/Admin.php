<?php

namespace App\Controllers\Admin;
use \Core\View;
use \Config\Admin\Auth;

class Admin extends Authenticated {

    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }
    

    public function indexAction()
    {
        View::renderTemplate('Admin/admin.html');
    }
}