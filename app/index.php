<?php
include 'registerHelper.php';

?>

<main>

  <div>
    <h1>Log in</h1>
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