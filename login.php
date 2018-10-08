<?php
  session_start();
  $pageTitle = 'Login';

  if (isset($_SESSION['user'])) {
    header('Location: index.php'); // Redirect To Home Page
  }

  include "init.php";

  // Check if User Coming From HTTP Post Request
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST["login"])):

      $username = $_POST['username'];
      $password = $_POST['password'];
      $hashedPass = sha1($password);

      // Check if The User Exist in Database
      $stmt = $con->prepare("SELECT Username, Password FROM users WHERE username = ? AND password = ?");
      $stmt->execute(array($username, $hashedPass));
      $count = $stmt->rowCount();

      // If Count > 0 This Mean The Database Contain Record About This Username
      if ($count > 0):
        $_SESSION['user']     = $username; // Register Session Name
        header('Location: index.php'); // Redirect To Home Page
        exit();
      endif;

    else:
      header('Location: dashboard.php');
    endif;

  }
?>

<div class="container login-page">
  <h1 class="text-center">
    <span class="selected" data-class="login">Login</span> |
    <span data-class="singup">Singup</span>
  </h1>
  <!-- Start login form -->
  <form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <div class="input-container">
      <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="new-password">
    </div>
    <input type="submit" class="btn btn-primary btn-block" name="login" value="Login">
  </form>
  <!-- End login form -->

  <!-- Start singup form -->
  <form class="singup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
    <div class="input-container">
      <input type="text" class="form-control" name="username" placeholder="Username" required autocomplete="off">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password" placeholder="Password" required autocomplete="new-password">
    </div>
    <div class="input-container">
      <input type="password" class="form-control" name="password-confirmation" placeholder="Password Confirmation" required autocomplete="new-password">
    </div>
    <div class="input-container">
      <input type="email" class="form-control" name="email" required placeholder="example@domain.com">
    </div>
    <input type="submit" class="btn btn-success btn-block" name="singup" value="Singup">
  </form>
  <!-- End singup form -->

  <!-- Start -->
  <div class="the-errors">

  </div>
  <!-- End -->
</div>

<?php include $tpl . "footer.php"; ?>
