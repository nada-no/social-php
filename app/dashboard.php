<?php
include 'loginHelper.php'; //if removed you can log in with whatever credentials!!!
include 'class/PostController.php';



$postController = new PostController();
//add new post
if(isset($_POST['post'])) $postController->addPost();
//show posts
$posts = $postController->getPosts();


?>
<h1>Este es el dashboard</h1>
<form method="POST" action="dashboard.php">
    <label>Write a post!</label>
    <input type="text" name="post">
    <input type="submit">
</form>
<div>
    <h1>
        Timeline
    </h1>

   <?php
   foreach($posts as $post){
    ?>
    <div>
        <h3><?= $post['email']?></h3>
        <p><?=$post['content']?></p>
    </div>
    <?php
   }
   ?>
</div>