<?php
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == 1) {
  die(header("Location: ./"));
}

if(count($_POST) > 0) {
  require_once("assets/php/loginfunctions.php");
  if(login($_POST['username'], $_POST['password'])) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['loggedin'] = 1;
    die(header("Location: ./"));
  } else {
    die(header("Location: ./login.php?wrongpassword"));
  }
}


?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Anonymous Posting.">
    <meta name="author" content="RJ">
    <link rel="icon" href="../../favicon.ico">

    <title>Log In</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body style="background-color: #000;">

    <div class="container">
    <?php
          if(isset($_GET['wrongpassword'])) {
            echo "
            <div class=\"alert alert-danger\" role=\"alert\" style=\"color: #000; font-size: 150%;\">
              <strong>Oh snap!</strong> Incorrect login details.
            </div>
            ";
          }
              if(isset($_GET['registered'])) {
              echo "
              <div class=\"alert alert-info\" role=\"alert\">
                <img src='info.png'> Registered successfully.
              </div>
              ";
            }
    ?>
      <form class="form-signin" method='post' action='?'>
        <h2 class="form-signin-heading" style="color: orange;">Please log in</h2>
        <label for="inputUser" class="sr-only">Username</label>
        <input type="username" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Log in</button>
      </form>
      <p class="text-center" style="color: orange;">Don't have an account? Click <a href='register.php'>here</a> to register.</p>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
