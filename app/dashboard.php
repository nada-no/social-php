<?php
include 'class/User.php';

$user = new User();

if($user->login($_POST['email'],$_POST['password'])){
?>
<h1>Este es el dashboard</h1>
<?php
}else{
header("Location: index.html");
}
?>