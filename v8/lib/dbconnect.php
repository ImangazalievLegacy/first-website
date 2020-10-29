<?php

//данные о хосте, пользователе и базе данных
$host = 'mysql.hostinger.ru';
$user = 'u559327328_user';
$pass = '250797';
$dbname = 'u559327328_users';

$PDO_driver = 'mysql';

try {
    $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
	$DBH->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );  
}  
catch(PDOException $e) {  
    $errors[] = 'Failed to connect to MySQL server!';
}

?>