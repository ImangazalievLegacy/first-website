<?php

include('../dbconnect.php');// подключение к серверу MySql и выбор БД
include('../lib/functions.php');
include('../lib/auth.php');

$MAX_ID = 99999;

$INDEX_PAGE = '../index.php';

$REGISTRATION_PAGE = 'registration.php';

$SITE_NAME = 'TIM Server';

$SENDER = 'TIM-Server';

$MIN_PASS_LENGTH = 6;
$MAX_PASS_LENGTH = 15;
$MAX_LOGIN_LENGTH = 15;


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
	$errors[count($errors)] = 'Fill in all fields';
	else
	{
		$username = $_POST['username'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
	}
}

if (empty($errors))
{
	if (!check($username)) $errors[] = 'Illegal characters in a user name';

	if (!checkmail($email)) $errors[] = 'E-mail is invalid or contains illegal characters';

	if (!check($pass)) $errors[] = 'Illegal characters in a password';
	
	if (strlen($pass)<$MIN_PASS_LENGTH or strlen($pass)>$MAX_PASS_LENGTH) $errors[] = 'Minimum password length is '.$MIN_PASS_LENGTH.' characters, maximum - '.$MAX_PASS_LENGTH;
	
	if (strlen($pass)>$MAX_LOGIN_LENGTH) $errors[] = 'Maximum login length is '.$MAX_LOGIN_LENGTH.' characters';
}

if (empty($errors))
{
	$id = mt_rand(0, $MAX_ID);
	$username = mysql_real_escape_string($username);
	$email = mysql_real_escape_string($email);
	$pass = mysql_real_escape_string($pass);

	$SQL = "SELECT * FROM `users` WHERE `username`='$username' OR `email`='$email' OR `id`='$id'";

	$data= mysql_query($SQL) or  $errors[] = 'An error occurred while accessing the database';

	while ( $row = mysql_fetch_array ( $data ))
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

	$SQL= "INSERT INTO `users` (`id`, `username`, `email`, `pass`, `salt`, `reg_date`, `verified`,  `hash`) VALUES ('$id', '$username', '$email', '$pass', '$salt', '$reg_date', 'false', '$hash')";

	$data= mysql_query($SQL) or  $errors[] = 'An error occurred while accessing the database';

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

	mysql_close();

}

if (!empty($errors))
{
	$_SESSION['errors'] = $errors;
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