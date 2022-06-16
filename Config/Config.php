<?php

namespace Config;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'weblightstarphp';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'root';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * target_dir
     * đường dẫn đến thư mục để lưu ảnh vào 
     * @var string
     */
    const TARGET_DIR = 'C:/xampp/htdocs/BTL/public/admin/img/';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;

    /**
     * Secret key for hashing
     * @var boolean
     */
    const SECRET_KEY = 'your-secret-key';

    /**
     * Mailgun API key
     *
     * @var string
     */
    const MAILGUN_API_KEY = 'your-mailgun-api-key';

    /**
     * Mailgun domain
     *
     * @var string
     */
    const MAILGUN_DOMAIN = 'your-mailgun-domain';

    public static function getPage($currentPage){
        if($currentPage == 0 ) return 0 ;
        return ($currentPage - 1 )*5 ;
    }

    public static function getCeil($count){

        $totalCount = ceil($count) ;
        if( $totalCount >= $count ){
            return $totalCount ;
        }else{
            return $totalCount + 1;
        }
    }

    public static function checkList($count){
        if($count == 0)return false ;

        return true ;
    }

    public static function uploadFile($mkdir){
        $target_dir = Config::TARGET_DIR . $mkdir;
        $target_file = $target_dir . basename($_FILES["fileupload"]["name"]);
        $nameFile = $_FILES["fileupload"]["name"];
        if (file_exists($target_file)) {
            $name = substr($_FILES["fileupload"]["name"], 0, -4);
            $pos = strpos($_FILES["fileupload"]["name"], '.');
            $image = substr($_FILES["fileupload"]["name"], 0, -4) . uniqid() . substr($_FILES["fileupload"]["name"], $pos);
            $target_file = $target_dir . $image;
            $nameFile = $image;
        }

        move_uploaded_file($_FILES["fileupload"]["tmp_name"], $target_file);

        return $nameFile ;
    }
}
