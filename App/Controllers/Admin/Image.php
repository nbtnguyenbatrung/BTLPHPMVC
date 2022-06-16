<?php

namespace App\Controllers\Admin;

use \Core\View;
use \App\Models\ImageDTO;
use \Config\Admin\Auth;
use \Config\Config;

class Image extends \Core\Controller 
{
    protected function before()
    {
        parent::before();

        $this->user = Auth::getUser();
    }

    public function indexAction($id)
    {
        $image = new ImageDTO();

        View::renderTemplate('Admin/image.html' , 
        ['images' => $image->getAllImage($id),
         'pro_id' => $id ,
         'totalCount' => count($image->getAllImage($id) )] );

        
    }

    public function delete($id)
    {
        $image = new ImageDTO();
        $image->delete($id) ;

        $this->redirect("/?admin/image/" . $_GET['pro_id'] . "/index"); 
    }

    public function add()
    {

        $image = new ImageDTO();

         $target_dir = Config::TARGET_DIR . 'products/';
         $files = $_FILES['fileupload'];
         $file_names = $_FILES['fileupload']['name'];
         $file_temps = $_FILES['fileupload']['tmp_name'];

         foreach ($file_names as $key => $value)
            {
                $target_file = $target_dir . basename($value);
                $nameFile = $value;
                if (file_exists($target_file)) {
                    $name = substr($value, 0, -4);
                    $pos = strpos($value, '.');
                    $image = substr($value, 0, -4) . uniqid() . substr($value, $pos);
                    $target_file = $target_dir . $image;
                    $nameFile = $image;
                }

                move_uploaded_file($file_temps[$key], $target_file);
                $image->add($_POST['pro_id'] , $nameFile);
            }

        $this->redirect("/?admin/image/" . $_POST['pro_id'] . "/index"); 
    }
}