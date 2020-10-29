<?php

include('../dbconnect.php');// подключение к серверу MySql и выбор БД
include('../lib/functions.php');

if (isset($_GET['hash'])) $hash=$_GET['hash'];

if (!check($hash))
{
	echo 'Error';
	exit;
}

if (empty($errors))
{
	
	$params = array(':hash' => $hash);

	$SQL= "UPDATE `users` SET `verified`='true' WHERE `hash`=:hash";
	
	try {
	$result = $DBH->prepare($SQL);
	$result->execute($params);
	}  
	catch(PDOException $e) {  
		echo 'Error';
	}

	if ($result->rowCount()>0)
	
	echo 'E-mail confirmed!';
	else
	echo 'Error';

}

?>