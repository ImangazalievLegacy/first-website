<?php

function check($str)
{
return preg_match("/^([a-zA-Z0-9_\-\.]*)$/", $str);
}

function checkmail($str)
{
return filter_var($str, FILTER_VALIDATE_EMAIL) && preg_match("/^([a-zA-Z0-9@_\-\.]*)$/", $str);
}

function printerrors($errors)
{
if (!empty($errors))
{
	echo "<b>When registering the following errors occurred:</b><br>";

	foreach($errors AS $error)
	{
		echo $error."<br>";
	}
	
	exit;
}
else
{
	echo 'OK<br>';
}
}

?>