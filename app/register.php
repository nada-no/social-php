<?php
// include 'app.php';

?>

<main>

  <div>
    <?php
    if(isset($_GET['error'])){
        ?>
        <h1>Register error!</h1>
        <?php
    }
    ?>
    <h1>Register</h1>
    <form method="POST" action="index.php">
      <label>Email</label>
      <input type="text" name="email">
      <label>Password</label>
      <input type="text" name="password">
      <input type="submit">
    </form>
  </div>
</main>
<?php
include_once('commons/footer.php');
?>