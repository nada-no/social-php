<?php 
include 'class/LoginController.php';

if(isset($_POST['email'],$_POST['password'])){
    $login = new LoginController($_POST['email'],$_POST['password']);
    $login->loginUser();
}