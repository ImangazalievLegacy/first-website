<?php

include('dbconnect.php');// подключение к серверу MySql и выбор БД
include_once('auth.php');
include('../config/config.php');

if (user_authorized())
{
	session_start();
	$id = $_SESSION['id'];

	if ($_SESSION['visited_pages_number'] >= $STEP_OF_RECORDING_USER_ACTIVITY)
	{
		$last_activity_time = date("d.m.y H:i:s");

		$params = array(
		':id' => $id,
		':last_activity_time' => $last_activity_time);

		$SQL= "UPDATE `online` SET `last_activity_time`=:last_activity_time WHERE `id`=:id";
			
		try {
			$result = $DBH->prepare($SQL);
			$result->execute($params);
		}  
		catch(PDOException $e) {  
			echo 'Error UPDATE';
		}

		$row_count = $result->rowCount();
			
		if ($row_count == 0){	

			$SQL = "INSERT INTO `online` (`id`, `last_activity_time`) VALUES (:id, :last_activity_time)";
				
			try {
				$result = $DBH->prepare($SQL);
				$result->execute($params);
			}  
			catch(PDOException $e) {  
				echo 'Error INSERT'.$e;
			}
		}
		$_SESSION['visited_pages_number'] = 0;
	}
	else
	{
		$_SESSION['visited_pages_number']++;
	}
}

?>