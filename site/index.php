<html>
<head>
<title>Index page</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1>Index page</h1>
<br>
<?php

include('lib/auth.php');
include('lib/last_activity.php');
include('config/config.php');


if (user_authorized())
{
include ('lib/last_activity.php');
echo 'РџСЂРёРІРµС‚СЃС‚РІСѓРµРј, <a href="'.$PROFILE_PAGE.'">'.$_SESSION['username'].
'</a><br><br>
<a href="'.$LOGOUT_PAGE.'">Р’С‹Р№С‚Рё</a>';
}
else
echo '<a href="'.$REGISTRATION_PAGE.'">Р РµРіРёСЃС‚СЂР°С†РёСЏ</a>
<br>
<a href="'.$LOGIN_PAGE.'">Р’РѕР№С‚Рё</a>';
?>
</body>
</html>