<?php
// include 'UserModel.php';
include_once 'Controller.php';

class LoginController extends Controller
{

    //ATTRIBUTES
    // private $UserModel;
    private $email;
    private $password;
    private $auth;

    //CONSTRUCTOR
    public function __construct($_email,$_password)
    {
        parent::__construct();
        $this->password = $_password;
        $this->email = $_email;
        $this->auth = false;
        // $this->UserModel = new UserModel();
    }

    //DESTRUCTOR
    public function __destruct()
    {
    }

    public function loginUser(){
    //    header("Location: register.php");
        $registerSucess = $this->UserModel->login($this->email,$this->password);
        if($registerSucess){
            header("Location: dashboard.php");
        }else{
            header("Location: index.php?error=bad_login");
        }
    }
}
