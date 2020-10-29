<?php

function user_authorized()
{
	session_start(); 
	return isset($_SESSION['hash']);
}

?>