<?php

//данные о хосте, пользователе и базе данных
$host = 'mysql.hostinger.ru';
$user = 'u559327328_user';
$password = '250797';
$dbname = 'u559327328_users';
 
// подключаемся и выбираем бд, которую указали выше
if(!mysql_connect($host,$user,$password))
{
	$errors[] = 'Failed to connect to MySQL server!';
}
elseif(!mysql_select_db($dbname))
{
	$errors[] = 'Unable to select database!';
}
?>