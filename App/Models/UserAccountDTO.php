<?php

namespace App\Models;

use \Config\Config;
use PDO;

class UserAccountDTO extends \Core\Model
{
       
    public function getAllUserPage(){
        $sql = 'SELECT * from user_account ORDER BY user_id  ' ;

        $db = static::getDB();
        $data = $db->query($sql);
        $user = $data->fetchAll();
        return $user;
    }

    public function getAllUser($currentPage){

        if ($currentPage <= Config::getCeil(count($this->getAllUserPage()) / 5) ){
            $sql = 'SELECT * from user_account  ORDER BY user_id DESC LIMIT ' . Config::getPage($currentPage , 5) . ' , 5 ' ;
        }else{
            $sql = 'SELECT * from user_account ORDER BY user_id DESC LIMIT ' . Config::getPage(Config::getCeil(count($this->getAllUserPage()) / 5) , 5) . ' , 5 ' ;
        }
        
        $db = static::getDB();
        $data = $db->query($sql);
        $productGroup = $data->fetchAll();
        return $productGroup;
    }

    public function disable($id){
        $sql = ' UPDATE user_account SET status = 0 WHERE user_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function active($id){
        $sql = ' UPDATE user_account SET status = 1 WHERE user_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function add(){

        $sql = 'INSERT INTO user_account (name ,phone_number , email , password , role ,status)
                VALUES (:name , :phone_number , :email , :password , :role , 1)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $_POST["phone_number"], PDO::PARAM_STR);
        $stmt->bindValue(':email', $_POST["email"], PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($_POST["password"], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':role', $_POST["role"], PDO::PARAM_STR);
        
        return $stmt->execute();
    }

    public static function checkEmail($email){

        $sql = 'SELECT * from user_account WHERE email = :email ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return $stmt->fetch();
    }

    public function emailFound($email){

        $user = static::checkEmail($email);

        if ($user) {
            return true;
        }

        return false;

    }

    public function editProfile(){

        $sql = ' UPDATE user_account SET name = :name , phone_number = :phone_number WHERE user_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->bindValue(':phone_number', $_POST['phone_number'], PDO::PARAM_STR);
        $stmt->bindValue(':name', $_POST['name'], PDO::PARAM_STR);

        return $stmt->execute();
    }

    
    public function changePassword(){
        
        $sql = 'SELECT * from user_account WHERE email = :email and password = :password ';

        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($_POST["password"], PASSWORD_DEFAULT), PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();
        
        return $stmt->fetch();

    }

    public function notFound(){
        $user = static::changePassword();

        if ($user) {
            return true;
        }

        return false;
    }

    public function updateChangePassword(){
        $sql = ' UPDATE user_account SET password = :password WHERE user_id = :id ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':id', $_POST['id'], PDO::PARAM_INT);
        $stmt->bindValue(':password', password_hash($_POST["password"], PASSWORD_DEFAULT), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function resetPassword(){
        $sql = ' UPDATE user_account SET password = :password WHERE email = :email ';
        $db = static::getDB();
        $stmt = $db->prepare($sql);
        $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash(1, PASSWORD_DEFAULT), PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function addUser(){

        $sql = 'INSERT INTO user_account (name ,phone_number , email , password , role ,status)
                VALUES (:name , :phone_number , :email , :password , :role , 1)';

        $db = static::getDB();
        $stmt = $db->prepare($sql);

        $stmt->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
        $stmt->bindValue(':phone_number', $_POST["phone_number"], PDO::PARAM_STR);
        $stmt->bindValue(':email', $_POST["email"], PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($_POST["password"], PASSWORD_DEFAULT), PDO::PARAM_STR);
        $stmt->bindValue(':role', "user", PDO::PARAM_STR);
        
        return $stmt->execute();
    }

}