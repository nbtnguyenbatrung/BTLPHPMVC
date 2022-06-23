<?php

require '../vendor/autoload.php';

    spl_autoload_register(function ($class){
        $root = dirname(__DIR__);
        $file = $root . '/' . str_replace("\\",'/',$class) . '.php';
        if (is_readable($file)) {
            require $file;
        }
    });
    
    session_start();
    
    $router = new Core\Router();

    $router->add('',['controller'=>'Home','action'=>'index','namespace'=>'Home']);
    $router->add("{controller}/{action}");
    $router->add("admin/{controller}/{action}",['namespace'=>'Admin']);
    $router->add("admin/{controller}/{id:\d+}/{action}",['namespace'=>'Admin']);
    $router->add("home/{controller}/{action}",['namespace'=>'Home']);
    $router->add("{controller}/{id:\d+}/{action}");
    $router->add("home/{controller}/{id:\d+}/{action}",['namespace'=>'Home']);
    $router->add('login', ['controller' => 'Login', 'action' => 'login' , 'namespace'=>'Admin' ]);
    $router->add('logout', ['controller' => 'Logout', 'action' => 'logout']);

    $router->add('loginUser', ['controller' => 'Login', 'action' => 'new' , 'namespace'=>'Home' ]);
    $router->add('logoutUser', ['controller' => 'Logout', 'action' => 'logoutUser']);
    $router->add('register', ['controller' => 'Login', 'action' => 'register' , 'namespace'=>'Home' ]);
    $router->add("user/{controller}/{action}",['namespace'=>'Home']);
    $router->add("user/{controller}/{id:\d+}/{action}",['namespace'=>'Home']);
    $router->add('contact', ['controller' => 'Contact', 'action' => 'index' , 'namespace'=>'Home' ]);

    $router->dispatch($_SERVER["QUERY_STRING"]);
    
?>