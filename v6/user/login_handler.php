<?php

include('../lib/dbconnect.php');// подключение к серверу MySql и выбор БД
include('../lib/functions.php');
include('../lib/auth.php');
include('../config/config.php');

if (user_authorized())
{
	header("Location: $INDEX_PAGE");
	exit;
}


if (empty($errors))
{
	if (
		empty($_POST['email']) or

		empty($_POST['pass'])
	)
	$errors[] = 'Fill in all fields';
	else
	{
		$email = $_POST['email'];
		$pass = $_POST['pass'];

	}
}

if (empty($errors))
{
	if (!checkmail($email)) $errors[] = 'E-mail is invalid or contains illegal characters';

	if (!check($pass)) $errors[] = 'Illegal characters in a password';
	
	if (strlen($pass)<$MIN_PASS_LENGTH or strlen($pass)>$MAX_PASS_LENGTH) $errors[] = 'Minimum password length is '.$MIN_PASS_LENGTH.' characters, maximum - '.$MAX_PASS_LENGTH;
	
	if (strlen($username)>$MAX_USERNAME_LENGTH) $errors[] = 'Maximum username length is '.$MAX_USERNAME_LENGTH.' characters';
}


if (empty($errors))
{
	
	$params = array(':email' => $email);

	$SQL = "SELECT * FROM `users` WHERE `email`=:email LIMIT 1";
	
	try {
	$result = $DBH->prepare($SQL);
	$result->execute($params);
	}  
	catch(PDOException $e) {  
		$errors[] = 'An error occurred while accessing the database';
	}

	$row_count = $result->rowCount();
	
	if ($row_count == 0) $errors[] = 'User with this E-mail was not found';
	else
	{
		$row = $result->fetch();
		$salt = $row['salt'];
		$pass = md5(md5($pass).md5($salt));
		if ($pass != $row['pass'])
		{
			$errors[] = 'Wrong password';
		}
		else
		{
			$id = $row['id'];
			$username = $row['username'];
			$verified = $row['verified'];
		}
	}
}

if (!empty($errors))
{
	$_SESSION['errors'] = $errors;
	$_SESSION['email'] = $_POST['email'];
	header("Location: $LOGIN_PAGE");
	exit;
}
else
{
	$_SESSION['id'] = $id;
	$_SESSION['username'] = $username;
	$_SESSION['verified'] = $verified;
	$_SESSION['hash'] = md5(mt_rand(0, 99999));
	header("Location: $INDEX_PAGE");
	exit;
}


?>