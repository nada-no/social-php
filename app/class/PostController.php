<?php
include_once 'Controller.php';

class PostController extends Controller
{

    private $user;
    private $posts;

    //METHODS
    public function getPosts()
    {
        return $this->PostModel->getAll();
    }

    public function addPost()
    {

        $this->PostModel->storePost();
    }
}
