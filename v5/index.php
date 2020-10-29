<html>
<head>
<title>Index page</title> 
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
</head>
<body>
<h1>Index page</h1>
<br>
<?php

include ('lib/auth.php');

if (user_authorized())
echo 'РџСЂРёРІРµС‚СЃС‚РІСѓРµРј, '.$_SESSION['username'].
'<br><br>
<a href="logout.php">Р’С‹Р№С‚Рё</a>';
else
echo '<a href="registration/registration.php">Р РµРіРёСЃС‚СЂР°С†РёСЏ</a>
<br>
<a href="registration/login.php">Р’РѕР№С‚Рё</a>';
?>
</body>
</html>