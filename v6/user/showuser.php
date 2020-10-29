<?php

include('../lib/dbconnect.php');// подключение к серверу MySql и выбор БД
include('../lib/functions.php');

if (empty($errors))
{
	if (
		empty($_GET['id'])
	)
	$errors[] = 'Empty ID';
	else
	{
		$id = $_GET['id'];
	}
}

if (empty($errors))
{
	if (!only_numbers($id)) $errors[] = 'ID contains illegal characters';
}


if (empty($errors))
{
	
	$params = array(':id' => $id);

	$SQL = "SELECT * FROM `users` WHERE `id`=:id LIMIT 1";
	
	try {
	$result = $DBH->prepare($SQL);
	$result->execute($params);
	}  
	catch(PDOException $e) {  
		$errors[] = 'An error occurred while accessing the database';
	}

	$row_count = $result->rowCount();
	
	if ($row_count == 0) $errors[] = 'User with this ID was not found';
	else
	{
		$row = $result->fetch();
		
		echo 'Username: '.$row['username'].'<br>';
		echo 'E-mail: '.$row['email'].'<br>';
		echo 'Registration Date: '.$row['reg_date'].'<br>';
		echo 'Verified: '.$row['verified'].'<br>';
	}
}

foreach($errors AS $error)
{
	echo $error."<br>";
}

?>