<?php

include('../config/config.php');

function RelativePath($abs_path)
{
	global $SITE_HOST, $SITE_DIR;
	
	$start = strlen($SITE_HOST.$SITE_DIR);

	$path = substr($abs_path, $start);

	$mydir = substr($_SERVER['PHP_SELF'], strlen($SITE_DIR)+1);

	$mydir = dirname($mydir);
	$mydir = explode('/', $mydir);
	$n = count($mydir);
	
	for ($i = 0; $i < $n; $i++)
	{
	  $relative_path =  $relative_path.'../';
	}
	
	$relative_path.= $path;

	return $relative_path;

}

function check($str)
{
	return preg_match("/^([a-zA-Z0-9_\-\.]*)$/", $str);
}

function checkmail($str)
{
	return filter_var($str, FILTER_VALIDATE_EMAIL) && preg_match("/^([a-zA-Z0-9@_\-\.]*)$/", $str);
}

function only_numbers($str)
{
	return preg_match("/^([0-9])+$/", $str);
}

function random_string ($length = 32) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$result = '';
	for ($i = 0; $i <= $length; $i++) {
		$result .= $characters[mt_rand (0, strlen ($characters) - 1)];
	}
	return $result;
}
?>