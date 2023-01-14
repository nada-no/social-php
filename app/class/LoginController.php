<?php
include 'UserModel.php';

class LoginController
{

    //ATTRIBUTES
    private $UserModel;
    private $email;
    private $password;
    private $auth;

    //CONSTRUCTOR
    public function __construct($_email,$_password)
    {
        $this->password = $_password;
        $this->email = $_email;
        $this->auth = false;
        $this->UserModel = new UserModel();
    }

    //DESTRUCTOR
    public function __destruct()
    {
    }

    public function loginUser(){
        $registerSucess = $this->UserModel->login($this->email,$this->password);
        if($registerSucess){
            header("Location: dashboard.php");
        }else{
            header("Location: index.php?error=bad_login");
        }
    }
}
