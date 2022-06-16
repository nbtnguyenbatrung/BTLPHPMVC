<?php

namespace Core;

use \Config\Admin\Auth;
use \Config\Flash;

abstract class Controller 
{
    protected $route_params = [];

    public function __call($name, $args) {
        $method = $name . 'Action';
        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this,$method],$args);
                $this->after();
            }
        } else {
            echo "Method $method not found in controller ".get_class($this);
        }

        
    }

    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    protected function before() {}

    protected function after() {}

    /**
     * Redirect to a different page
     *
     * @param string $url  The relative URL
     *
     * @return void
     */
    public function redirect($url)
    {
   
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit;
    }

    /**
     * Require the user to be logged in before giving access to the requested page.
     * Remember the requested page for later, then redirect to the login page.
     *
     * @return void
     */
    public function requireLogin()
    {

        if (!Auth::getUser()) {

            
            // Flash::addMessage('Please login to access that page', Flash::INFO);

            // Auth::rememberRequestedPage();

            $this->redirect('/?login');
        }
    }
}