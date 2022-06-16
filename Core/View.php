<?php

namespace Core;

use \Config\Admin\Auth;
use \Config\Flash;

class View
{
    public static function render($view, $args)
    {
        extract($args, EXTR_SKIP);
        $file = "../App/Views/$view";
        if (is_readable($file)) {
            require $file;
        } else {
            echo "$file not found";
        }
    }

    public static function renderTemplate($template, $args = [])
    {
        echo static::getTemplate($template, $args);
    }

    public static function getTemplate($template, $args = [])
    {
        static $twig = null;

        if ($twig === null) {
            $loader = new \Twig_Loader_Filesystem(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig_Environment($loader);
            $twig->addGlobal('current_user', \Config\Admin\Auth::getUser());
            $twig->addGlobal('flash_messages', \Config\Flash::getMessages());
        }

        return $twig->render($template, $args);
    }

}