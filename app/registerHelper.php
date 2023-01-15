<?php


include 'class/RegisterController.php';



if(isset($_POST['email'])&&isset($_POST['password'])){
  $register = new RegisterController($_POST['email'],$_POST['password']);
  $register->addUser();
}