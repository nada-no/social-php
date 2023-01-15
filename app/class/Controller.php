<?php
include_once 'UserModel.php';
include_once 'PostModel.php';

class Controller {
      //ATTRIBUTES
      public $UserModel;
      public $PostModel;

      public function __construct()
      {
        $this->UserModel = new UserModel();
        $this->PostModel = new PostModel();
      }
}