<?php

include('../lib/dbconnect.php');// подключение к серверу MySql и выбор БД
include('../lib/functions.php');
include('../config/config.php');
include('../lib/auth.php');

if (!user_authorized())
{
	header("Location: $INDEX_PAGE");
	exit;
}

if (isset($_GET['act']))
{
	$act = $_GET['act'];
}

if ($act == 'change')
{

	$_SESSION['next_uri'] = 'http://tim-server.hol.es/site/user/change_avatar.php?act=uploaded';
	$_SESSION['upload_dir'] = '../images/users/avatars/';
	
	$redir_url = $SITE_HOST.$SITE_DIR.'lib/upload_image.php';


	header("Location: $redir_url");

	exit;
}


if ($act == 'uploaded')
{
	$params = array(
	':avatar_filename' => $_SESSION['avatar_filename'],
	':id' => $_SESSION['id']);
	

	$SQL= "UPDATE `users` SET `avatar`=:avatar_filename WHERE `id`=:id";
	
	try {
	$result = $DBH->prepare($SQL);
	$result->execute($params);
	}  
	catch(PDOException $e) {  
		echo 'Error';
	}
	
	unset($_SESSION['avatar_filename']);

	if ($result->rowCount()>0)
	
	echo 'Avatar changed!';
	else
	echo 'Error change';
}

if ($act == 'delete')
{

	$params = array(
	':id' => $_SESSION['id'],
	':avatar_filename' => $DEFAULT_AVATAR_NAME
	);

	$SQL= "UPDATE `users` SET `avatar`=:avatar_filename WHERE `id`=:id";
	
	try {
	$result = $DBH->prepare($SQL);
	$result->execute($params);
	}  
	catch(PDOException $e) {  
		echo 'Error';
	}

	if ($result->rowCount()>0)
	
	echo 'Deleted';
	else
	echo 'Error delete';
}

?>