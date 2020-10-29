<html>
<head>
<title>Registration</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php

include('../dbconnect.php');// подключение к серверу MySql и выбор БД
include('../lib/functions.php');

$MAX_ID = 99999;

$INDEX_PAGE = '../index.php';

$SITE_NAME = 'TIM Server';

$SENDER = 'TIM-Server';

if (empty($errors))
{
	if (
		empty($_POST['username']) or

		empty($_POST['email']) or

		empty($_POST['pass'])
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
}

if (empty($errors))
{
	$username = mysql_real_escape_string($username);
	$email = mysql_real_escape_string($email);
	$pass = mysql_real_escape_string($pass);

	$SQL = "SELECT * FROM `users` WHERE `username`='$username' OR `email`='$email'";

	$data= mysql_query($SQL) or  $errors[] = 'An error occurred while accessing the database on line '.__LINE__;

	while ( $row = mysql_fetch_array ( $data ))
	{
		if ($row['username']==$username) $errors[] = 'User name is already taken';
		if ($row['email']==$email) $errors[] = 'E-mail is already taken';	
	}
}


if (empty($errors))
{
	$id = mt_rand(0, $MAX_ID);

	$salt = mt_rand(0, 999999);
	$salt = md5($salt);

	$pass = md5($pass);
	$pass = md5($pass.$salt);

	$hash = md5(mt_rand(0, 99999));

	$SQL= "INSERT INTO `users` (`id`, `username`, `email`, `pass`, `salt`, `verified`,  `hash`) VALUES ('$id', '$username', '$email', '$pass', '$salt', 'false', '$hash')";

	$data= mysql_query($SQL) or  $errors[] = 'An error occurred while accessing the database on line '.__LINE__;

	$confirmurl = dirname('http://'.$_SERVER["SERVER_NAME"].$_SERVER['REQUEST_URI'] ) . '/confirm.php?hash='.$hash;

	$to = $email;
	$subject = 'Подтвердите регистрацию на '.$SITE_NAME ;
	$headers = 'MIME-Version: 1.0' . "\r\n" ;
	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n" ;
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
	echo "<b>When registering the following errors occurred:</b><br>";

	foreach($errors AS $error)
	{
		echo $error."<br>";
	}
	
	exit;
}
else
{
	echo 'OK<br>';
}

?>
</body>
</html>