<?php 
include 'UserModel.php';

class RegisterController {

    private $UserModel;
    private $email;
    private $password;

    public function __construct($__email,$__password)
    {
        $this->email=$__email;
        $this->password = $__password;
        $this->UserModel = new UserModel();
    }


    //METHODS
    public function addUser(){

        if(empty($this->email)){
            echo "problem";
            die();
        }
        $newUserId = $this->UserModel->storeUser($this->email,$this->password);
        
        //if the new user is created redirect to index, otherwise show error
        if($newUserId > 0){
            header("Location: index.php");
        }else{
            header("Location: register.php?error=true");
        }

    }
}