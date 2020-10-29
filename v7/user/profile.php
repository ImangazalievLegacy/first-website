<?php

include('../lib/auth.php');
include('../config/config.php');

if (user_authorized())
{
	header("Location: $INDEX_PAGE");
	exit;
}

<html>

<head>

	<META HTTP-EQUIV="Content-Type" Content="text/html; charset=windows-1251">
	
	<meta name="viewport" content="width=device-width">
	
	<title>Редактирование профиля</title>

</head>

<body>

<h2>Редактирование профиля</h2>