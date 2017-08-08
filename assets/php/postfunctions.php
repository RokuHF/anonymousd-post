<?php

function checkUser($user, $loginservername, $dblogin, $dblogin_user, $dblogin_pass) {

	//Get user's correct hash from db
	try {

		$conn = new PDO("mysql:host=$loginservername;dbname=$dblogin", $dblogin_user, $dblogin_pass);
		$sql = "SELECT password FROM users WHERE username = :user";
		$conn = $conn->prepare($sql);
		$conn->bindParam(':user', $user, PDO::PARAM_STR);
		$conn->execute();
		$correcthash = $conn->fetchColumn();
		$conn = null; // close connection afterwards

	} catch (PDOException $e) {
		echo $e->getMessage();
	}
	if($correcthash == NULL || $correcthash == "") {
		return false;
	} else {
		return true;
	}
}


function post($name, $comment, $servername, $dbname, $db_user, $db_pass, $target) {
	if($name == "" || $name == NULL) {
	$name = "Anonymous";
	}
	if($comment == "" || $comment == NULL) {
	die(header("Location: ./?nocomment"));
	}
	if(strlen($name) > 180) {
	die(header("Location: ./?toolong"));
	}

	if(strlen($comment) > 180) {
	die(header("Location: ./?toolong"));
	}
	$time = time();
	try {
	        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_user, $db_pass);
	        // set the PDO error mode to exception
	        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	        
	        $name = $conn->quote($name);
	        $comment = $conn->quote($comment);
	        $target = $conn->quote($target);
	        $sql = "INSERT INTO posts (time, name, Comment, target)
	        VALUES ($time, $name, $comment, $target)";
	        // use exec() because no results are returned
	        $conn->exec($sql);
	    }
	catch(PDOException $e)
	    {
	      echo $e->getMessage();
	    }
	$conn = null;
	//die(header("Location: ./?success"));
}

function get_posts($fromuser, $servername, $dbname, $db_user, $db_pass) {
		 try { 	
                      $conn = new PDO("mysql:host=$servername;dbname=$dbname", $db_user, $db_pass);
                      // set the PDO error mode to exception
                      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                      $sql = "SELECT ID, Name, Target, Comment, Time  FROM posts WHERE `Target` = :target ORDER BY time DESC LIMIT 25";
                      // use exec() because no results are returned
                      $conn = $conn->prepare($sql);
                      $conn->bindParam(':target', $fromuser, PDO::PARAM_STR);
                      $conn->execute();
                      return $conn->fetchAll();
                  } catch(PDOException $e)  {
                      echo $e->getMessage();
                  }

                  $conn = null;
}


?>