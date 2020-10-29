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

?>

<h2>Личный профиль</h2>

<?php

if (empty($errors))
{
	session_start();
	
	$id = $_SESSION['id'];
	
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
		
		echo '<img src="'.$AVATARS_FOLDER.$row['avatar'].'">'.'<br><br>';
		echo  '<a href="change_avatar.php?act=change" target="blank">Изменить</a>    <a href="change_avatar.php?act=delete" target="blank">Удалить</a><br><br>';
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