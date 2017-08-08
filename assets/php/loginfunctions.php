<?php

function checkUser($user, $loginservername, $dblogin, $dblogin_user, $dblogin_pass) {
	require_once("assets/php/dbconfig.php");
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
		//echo $e->getMessage();
	}
	if($correcthash == NULL || $correcthash == "") {
		return false;
	} else {
		return true;
	}
}

function register($username, $password)
{
	require_once("assets/php/dbconfig.php");
	if(checkUser($username, $loginservername, $dblogin, $dblogin_user, $dblogin_pass)) {
		die(header("Location: register.php?taken"));
	}
	//Insert user's details into db
	try {
		$password = password_hash($password, PASSWORD_BCRYPT); //Hash password using BCRYPT, is salted, default strength of 10
		$time = time();
		$conn = new PDO("mysql:host=$loginservername;dbname=$dblogin", $dblogin_user, $dblogin_pass);
		$sql = "INSERT INTO users (username, password, ip, regtime)
                VALUES (:user, :pass, :ip, :time)";
		$conn = $conn->prepare($sql);
		$conn->bindParam(':user', $username, PDO::PARAM_STR);
		$conn->bindParam(':pass', $password, PDO::PARAM_STR);
		$conn->bindParam(':ip', $_SERVER["REMOTE_ADDR"], PDO::PARAM_STR);
		$conn->bindParam(':time', $time, PDO::PARAM_INT);
		$conn->execute();
		$conn = null; // close connection afterwards
		die(header("Location: ./login.php?registered"));
	} catch (PDOException $e) {
		die(header("Location: ./register.php?taken"));
	}

}



function login($username, $password)
{
	require_once("assets/php/dbconfig.php");

	//Get user's correct hash from db
	try {

		$conn = new PDO("mysql:host=$loginservername;dbname=$dblogin", $dblogin_user, $dblogin_pass);
		$sql = "SELECT password FROM users WHERE username = :user";
		$conn = $conn->prepare($sql);
		$conn->bindParam(':user', $username, PDO::PARAM_STR);
		$conn->execute();
		$correcthash = $conn->fetchColumn();
		$conn = null; // close connection afterwards

	} catch (PDOException $e) {
		//echo $e->getMessage();
	}
	if(password_verify($password, $correcthash)) {
		return "true";
	}

	
}

function logout()
{
	session_destroy();
	header("Location: ./");
}


?>