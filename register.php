<?php
if(count($_POST) > 0) {
  require_once("assets/php/loginfunctions.php");
  register($_POST['username'], $_POST['password']);
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
          if(isset($_GET['taken'])) {
            echo "
            <div class=\"alert alert-danger\" role=\"alert\">
              <strong></strong> That username is taken.
            </div>
            ";
          }
    ?>
      <form class="form-signin" method='post' action='?'>
        <h2 class="form-signin-heading" style="color: orange;">Please register</h2>
        <label for="inputUser" class="sr-only">Username</label>
        <input type="username" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
      </form>
      <p class="text-center" style="color: orange;">Already have an account? Click <a href='login.php'>here</a> to login.</p>
    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
