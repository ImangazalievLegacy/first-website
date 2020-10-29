<?php

include('../lib/auth.php');

$INDEX_PAGE = '../index.php';

if (user_authorized())
{
	header("Location: $INDEX_PAGE");
	exit;
}

?>

<html>

<head>

	<META HTTP-EQUIV="Content-Type" Content="text/html; charset=windows-1251">
	
	<meta name="viewport" content="width=device-width">
	
	<title>Вход</title>
	
	    <style>
      .error {
		background-color: rgb(255, 36, 36);
		border: solid 2px rgb(170, 0, 0);
		font-color:	rgb(255, 255, 255);	
      }
    </style>

</head>

<body>

<h2>Регистрация</h2>

<?php

	session_start(); 
	if (isset($_SESSION['errors']))
	{
		echo '<div class="error">';
		echo "<b>When registering the following errors occurred:</b><br>";

		foreach($_SESSION['errors'] AS $error)
		{
			echo $error."<br>";
		}
		echo '</div>';
		
		unset($_SESSION['errors']);
	}

?>

<form method="POST" action="login_handler.php">

<p>E-mail: </p> 
<input type="text" name="email" value="<?php echo $_SESSION['email']; unset($_SESSION['email']); ?>" />
<p>Пароль: </p> 
<input id="pass" type="password" name="pass" /><label>

<input type="checkbox"  id="check"/>Показать пароль<br /></label><br>
<input type="submit" value="Вход" />

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script>
	$('#check').change(function() {
		var $pass = $('#pass');
		if (!$pass.next().is('.pass-show')) {

			$('<input class="pass-show">').val($pass.val()).hide().insertAfter($pass);
		}

		if ($(this).is(':checked')) {
		$pass.hide().next().show();
		}
		else {
			$pass.show().next().hide();
		}
	});
</script>

</form>

</body>
</html>