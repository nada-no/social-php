<?php
//start session before everything else executes
// session_start(); //working in the model ;)
include_once 'registerHelper.php';


?>

<main>

  <div>
    <h1>Log in</h1>
    <?php
    if (isset($_GET['error'])) {
      if ($_GET['error'] == 'bad_login') {
    ?> <p>Incorrect credentials!</p>
    <?php
      }
    }
    ?>

    <form method="POST" action="dashboard.php">
      <label>Email</label>
      <input type="text" name="email">
      <label>Password</label>
      <input type="text" name="password">
      <input type="submit">
    </form>
    <a href="register.php">Sign in</a>
  </div>
</main>
<?php
include_once('commons/footer.php');
?>