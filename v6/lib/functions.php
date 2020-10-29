<?php

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