<?php
session_start();



/*
TO-DO:
  -[DONE] Move post functions into assets/php/postfunctions.php, which still needs to be made
  -Create profile.php, GET user is variable that sets which user we're working with.
  -


*/


require_once("assets/php/dbconfig.php");
require_once("assets/php/postfunctions.php");

if(!isset($_GET['user']) || $_GET['user'] == NULL) {
  die(header("Location: ./?nouser"));
}

if(!checkUser($_GET['user'], $loginservername, $dblogin, $dblogin_user, $dblogin_pass)) {
  die(header("Location: ./?nouser"));
}

if(isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
} else {
  $username = "USER IS NOT SIGNED IN.";
}
  if(count($_POST) > 0) {
    $name = htmlspecialchars($_POST['name']);
    $comment = htmlspecialchars($_POST['comment']);
    post($name, $comment, $servername, $dbname, $db_user, $db_pass, $_GET['user']);
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

    <title><?php echo $sitetitle; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="dashboard.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container-fluid">
        <div class="navbar-header">
        
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
         
          <a class="navbar-brand" style='color: orange;' href="./"><?php echo $sitetitle; ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <?php
            if($username == "USER IS NOT SIGNED IN.") {
              echo '<li><a href="./login.php">Login</a></li>';
            } else {
              echo "<li><a href=\"./profile.php?user=$username\">Your Page</a></li>";
              echo "<li><a href=\"./logout.php\">Log Out</a></li>";
            }
            ?>
            
          </ul>
          <!--
          <form class="navbar-form navbar-right">
            <input type="text" class="form-control" placeholder="Search...">
          </form>
          -->
        </div>
      </div>
    </nav>
    <?php
    if(isset($_GET['toolong'])) {
      echo "
        <div class=\"alert alert-danger\" role=\"alert\">
          <strong>Oh snap!</strong> Your comment was more than 180 characters.
        </div>
        ";
    }
    if(isset($_GET['nocomment'])) {
      echo "
      <div class=\"alert alert-danger\" role=\"alert\">
        <strong>Oh snap!</strong> Your comment can't be blank.
      </div>
      ";
    }
    if(isset($_GET['success'])) {
      echo "
      <div class=\"alert alert-info\" role=\"alert\">
        <img src='info.png'> Comment posted successfully.
      </div>
      ";
    }
    ?>
    <div class="container-fluid">
    <!--
      <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li class="active"><a href="#">Overview <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Reports</a></li>
            <li><a href="#">Analytics</a></li>
            <li><a href="#">Export</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item</a></li>
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
            <li><a href="">More navigation</a></li>
          </ul>
          <ul class="nav nav-sidebar">
            <li><a href="">Nav item again</a></li>
            <li><a href="">One more nav</a></li>
            <li><a href="">Another nav item</a></li>
          </ul>
        </div>

        -->
        
        <div class="col-sm-1 col-sm-offset-1 col-md-10 col-md-offset-1 main">
        <br>
        <form method='post' action='./profile.php?success&user=<?php echo $_GET['user']; ?>' class="form-group" style="padding-right: 10px;">
            <label for="InputName">Name</label>
            <input type="text" id='name' name='name' class="form-control" placeholder="Anonymous" maxlength="45"> 
            <label for="InputText">Comment</label>
            <input type="text" id='comment' name='comment' class="form-control" placeholder="Comment" maxlength="180"> <br>
            <button type="Submit" class="btn btn-default">Post</button>
          </form>
          <h1 class="page-header">Posts</h1>
          <h6 class="">Only the last 25 posts are shown. All posts are anonymous.. Post whatever you want. No rules. Let's not spam, so I don't have to add a captcha system.</h6>

          <!--
          <div class="row placeholders">
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
            <div class="col-xs-6 col-sm-3 placeholder">
              <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
              <h4>Label</h4>
              <span class="text-muted">Something else</span>
            </div>
          </div>
          -->
          <!-- <h2 class="sub-header">Section title</h2> -->
          <div class="table-responsive" style="width:100%;">
            <table class="table table-striped table-bordered" style="table-layout: fixed;">
              <thead>
                <tr>
                  <th>Time</th>
                  <th>Name</th>
                  <th>Text</th>
                </tr>
              </thead>
              <tbody>
                <tr>


                <?php
                  $posts = get_posts($_GET['user'], $servername, $dbname, $db_user, $db_pass);
                  foreach ($posts as $post) {
                    $time = $post['Time'];
                    $time = gmdate("m-d-Y H:i:s", $time);
                    $name = htmlspecialchars($post['Name']);
                    $post = htmlspecialchars($post['Comment']);
                    echo "<tr>";
                    echo "<td>$time</td>";
                    echo "<td>$name</td>";
                    echo "<td style=\"word-wrap: break-word;\">$post";
                    if($_GET['user'] == $_SESSION['username']) {
                      //echo " [<a href='delete.php?post=$id'>Delete</a>]</td>";
                      echo "</td>";
                    } else {
                      echo "</td>";
                    }
                    echo "</tr>";
                  }


                ?>
               
              </tbody>
            </table>
            <?php
                if($posts == NULL || $posts == "") {
                  echo "<p class=\"text-center\">There are no posts yet.</p>";
                }
            ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../../dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="../../assets/js/vendor/holder.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
