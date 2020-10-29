<html>
<head>
<title>Р’С…РѕРґ</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php

session_start();

if (isset($_SESSION['nickname']))
{
  header('Location: http://tim-server.hol.es/');
}

function parray($sarray)
{
for ($i = 0; $i<(count($sarray)); $i++)
{
  echo $sarray[$i].'<br>';
}
}

$host = 'mysql.hostinger.ru';
$user = 'u559327328_user';
$password = '250797';
$base = 'u559327328_users';

$myConnect = mysql_connect($host,$user,$password);
mysql_select_db($base,$myConnect);

if (
empty($_POST['email']) or

empty($_POST['pass'])
)
$errors[count($errors)] = 'Р—Р°РїРѕР»РЅРёС‚Рµ РІСЃРµ РїРѕР»СЏ';
else
{
$email = $_POST['email'];
$pass = $_POST['pass'];
echo 'Р’СЃРµ РїРѕР»СЏ Р·Р°РїРѕР»РЅРµРЅС‹<br>';
}

if (count($errors)>0)
{
parray($errors);
exit;
}

if (
filter_var($email, FILTER_VALIDATE_EMAIL)
&& preg_match("/^([a-zA-Z0-9@_\-\.]*)$/", $email)
)
{
  echo 'Р’Р°Р»РёРґРЅС‹Р№ email<br>';
}
else
{
  $errors[count($errors)] = 'РќРµРІР°Р»РёРґРЅС‹Р№ e-mail РёР»Рё Р·Р°РїСЂРµС‰РµРЅС‹Рµ СЃРёРјРІРѕР»С‹';
}

if (preg_match("/^([a-zA-Z0-9_\-\.]*)$/",$pass)
)
{
  echo 'Р’Р°Р»РёРґРЅС‹Р№ РїР°СЂРѕР»СЊ<br>';
}
else
{
  $errors[count($errors)] = 'Р—Р°РїСЂРµС‰РµРЅС‹Рµ СЃРёРјРІРѕР»С‹ РІ РїР°СЂРѕР»Рµ';
}

$SQL = "SELECT * FROM `users` WHERE `email`='$email'";

$data = mysql_query($SQL) or die( mysql_error()) ; 

$count = mysql_num_rows($data);

if ( $count = 0) 
{
  $errors[count($errors)] = 'РўР°РєРѕР№ e-mail РЅРµ Р·Р°СЂРµРіРёСЃС‚СЂРёСЂРѕРІР°РЅ';
}

if (count($errors)>0)
{
parray($errors);
exit;
}

$myrow = mysql_fetch_array($data);
if (md5($pass) = $myrow['pass']){
$hash = md5($email.microtime());
session_start();

$SQL= "UPDATE `users` SET `hash`='$hash' WHERE `email`='$email'";

$data = mysql_query($SQL) or die( mysql_error()) ;

$_SESSION['hash'] = $hash;

$_SESSION['nickname'] = $myrow['nickname'];

echo 'РџСЂРёРІРµС‚СЃС‚РІСѓРµРј, '.$myrow['nickname'];
}

?>
</body>
</html>