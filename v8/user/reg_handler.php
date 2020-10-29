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
		empty($_POST['username']) or

		empty($_POST['email']) or

		empty($_POST['pass']) or
		
		empty($_POST['rules']) or
		
		$_POST['rules']!='agree'
		
	)
	$errors[] = 'Fill in all fields';
	else
	{
		$username = trim($_POST['username']);
		$email = trim($_POST['email']);
		$pass = trim($_POST['pass']);
	}
}

if (empty($errors))
{
	if (!check($username)) $errors[] = 'Illegal characters in a user name';

	if (!checkmail($email)) $errors[] = 'E-mail is invalid or contains illegal characters';

	if (!check($pass)) $errors[] = 'Illegal characters in a password';
	
	if (strlen($pass)<$MIN_PASS_LENGTH or strlen($pass)>$MAX_PASS_LENGTH) $errors[] = 'Minimum password length is '.$MIN_PASS_LENGTH.' characters, maximum - '.$MAX_PASS_LENGTH;
	
	if (strlen($username)>$MAX_USERNAME_LENGTH) $errors[] = 'Maximum username length is '.$MAX_USERNAME_LENGTH.' characters';
}

if (empty($errors))
{
	$id = mt_rand(0, $MAX_ID);
	
	$params = array(
	':id' => $id, 
	':username' => $username,
	':email' => $email);

	$SQL = "SELECT * FROM `users` WHERE `username`=:username OR `email`=:email OR `id`=:id";
	
	try {
	$result = $DBH->prepare($SQL);
	$result->execute($params);
	}  
	catch(PDOException $e) {  
		$errors[] = 'An error occurred while accessing the database';
	}

	while ( $row = $result->fetch())
	{
		if ($row['username']==$username) $errors[] = 'User name is already taken';
		if ($row['email']==$email) $errors[] = 'E-mail is already taken';
		if ($row['id']==$id) $id = mt_rand(0, $MAX_ID);
	}
}


if (empty($errors))
{
	$salt = random_string();

	$pass = md5(md5($pass).md5($salt));

	$hash = md5(mt_rand(0, 99999));
	
	$reg_date = date("d.m.y H:i:s");
	
	$params = array(
	':id' => $id, 
	':username' => $username,
	':email' => $email,
	':pass' => $pass,
	':salt' => $salt,
	':reg_date' => $reg_date,
	':avatar' => $DEFAULT_AVATAR_NAME,
	':verified' => 'false',
	':hash' => $hash);

	$SQL = "INSERT INTO `users` (`id`, `username`, `email`, `pass`, `salt`, `reg_date`, `avatar`, `verified`,  `hash`) VALUES (:id, :username, :email, :pass, :salt, :reg_date, :avatar, :verified, :hash)";
	
	try {
	$result = $DBH->prepare($SQL);
	$result->execute($params);
	}  
	catch(PDOException $e) {  
		$errors[] = 'An error occurred while accessing the database';
	}

	$confirmurl = dirname('http://'.$_SERVER["SERVER_NAME"].$_SERVER['PHP_SELF'] ) . '/confirm.php?hash='.$hash;

	$to = $email;
	$subject = 'Подтвердите регистрацию на '.$SITE_NAME ;
	$headers = 'MIME-Version: 1.0' . "\r\n" ;
	$headers .= 'Content-type: text/html; charset=CP1251' . "\r\n" ;
	$headers .= 'From: '.$SENDER . "\r\n" ;

	$text = 'Подтвердите регистрацию на '.$SITE_NAME .'. Для этого перейдите по ссылке:
	<br>
	<br>
	<a href="'.$confirmurl.'">'.$confirmurl.'</a>';

	mail($to, $subject, $text , $headers); 
 
	$DBH = null;

}

if (!empty($errors))
{
	$_SESSION['errors'] = $errors;
	$_SESSION['username'] = $username;
	$_SESSION['email'] = $_POST['email'];
	$_SESSION['pass'] = $_POST['pass'];
	header("Location: $REGISTRATION_PAGE");
	exit;
}
else
{
	$_SESSION['id'] = $id;
	$_SESSION['username'] = $username;
	$_SESSION['verified'] = false;
	$_SESSION['hash'] = md5(mt_rand(0, 99999));
	$notifications[] = 'Please, confirm yore E-mail';
	header("Location: $INDEX_PAGE");
	exit;
}

?>