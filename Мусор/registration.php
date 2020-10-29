<html>
<head>
<title>Р РµРіРёСЃС‚СЂР°С†РёСЏ</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
</head>
<body>
<?php

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

$id = mt_rand(0, 99999);

if (
empty($_POST['nickname']) or

empty($_POST['email']) or

empty($_POST['pass'])
)
$errors[count($errors)] = 'Р—Р°РїРѕР»РЅРёС‚Рµ РІСЃРµ РїРѕР»СЏ';
else
{
$nickname = $_POST['nickname'];
$email = $_POST['email'];
$pass = $_POST['pass'];
echo 'Р’СЃРµ РїРѕР»СЏ Р·Р°РїРѕР»РЅРµРЅС‹<br>';
}

if (count($errors)>0)
{
parray($errors);
exit;
}

if (preg_match("/^([a-zA-Z0-9_\-\.]*)$/", $nickname)
)
{
  echo 'Р’Р°Р»РёРґРЅС‹Р№ РЅРёРє<br>';
}
else
{
  $errors[count($errors)] = 'Р—Р°РїСЂРµС‰РµРЅРЅС‹Рµ СЃРёРјРІРѕР»С‹ РІ РЅРёРєРµ';
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

$nickname = mysql_real_escape_string($nickname);
$email = mysql_real_escape_string($email);
$pass = mysql_real_escape_string($pass);

$SQL = "SELECT * FROM `users` WHERE `nickname`='$nickname'";

$data = mysql_query($SQL) or die( mysql_error()) ; 

$count = mysql_num_rows($data);


if ( $count > 0) 
{
  $errors[count($errors)] = 'РќРёРє СѓР¶Рµ Р·Р°РЅСЏС‚';
}

$SQL = "SELECT * FROM `users` WHERE `email`='$email'";

$data = mysql_query($SQL) or die( mysql_error()) ; 

$count = mysql_num_rows($data);


if ( $count > 0) 
{
  $errors[count($errors)] = 'E-mail СѓР¶Рµ Р·Р°РЅСЏС‚';
}

if (count($errors)>0)
{
parray($errors);
exit;
}

$hash = md5($email.$pass);
$hash = md5($hash.$id);

$pass = md5($pass);

$SQL= "INSERT INTO `users` (`id`, `nickname`, `email`, `pass`,  `verified`,  `hash`) VALUES ('$id', '$nickname', '$email', '$pass', 'false', '$hash')";


$data= mysql_query($SQL) or die( mysql_error()) ; 

  $confirmurl = 'http://tim-server.hol.es/site/confirm.php?hash='.$hash;

  $to = $email;
  $subject = 'РџРѕРґС‚РІРµСЂРґРёС‚Рµ СЂРµРіРёСЃС‚СЂР°С†РёСЋ РЅР° TIM Server';
  $headers = 'MIME-Version: 1.0' . "\r\n" ;
  $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n" ;
  $headers .= 'From: TIM-Server' . "\r\n" ;

  $text = 'РџРѕРґС‚РІРµСЂРґРёС‚Рµ СЂРµРіРёСЃС‚СЂР°С†РёСЋ РЅР° TIM Server. Р”Р»СЏ СЌС‚РѕРіРѕ РїРµСЂРµР№РґРёС‚Рµ РїРѕ СЃСЃС‹Р»РєРµ:
  <br>
  <br>
  <a href="'.$confirmurl.'">'.$confirmurl.'</a>';

  mail($to, $subject, $text , $headers);

?>
</body>
</html>