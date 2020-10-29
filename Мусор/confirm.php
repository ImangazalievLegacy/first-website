<?php

$host = 'mysql.hostinger.ru';
$user = 'u559327328_user';
$password = '250797';
$base = 'u559327328_users';

$hash=$_GET['hash'];

$myConnect = mysql_connect($host,$user,$password);
mysql_select_db($base,$myConnect);


$SQL= "SELECT * FROM `users` WHERE `hash`='$hash'";

$data = mysql_query($SQL) or die( mysql_error()) ;

$count = mysql_num_rows($data);


if ( $count == 0 ) {

echo "Не найдено!";

} else {

$SQL= "UPDATE `users` SET `verified`='true' WHERE `hash`='$hash'";

$data = mysql_query($SQL) or die( mysql_error()) ;

echo "Подтверждено!";

}

?>