<?php

$SITE_HOST = 'http://tim-server.hol.es/';
$SITE_DIR = 'site/';

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

$INDEX_PAGE = 'http://tim-server.hol.es/site/index.php';

$REGISTRATION_PAGE = 'http://tim-server.hol.es/site/user/registration.php';
$LOGIN_PAGE = 'http://tim-server.hol.es/site/user/login.php';
$LOGOUT_PAGE = 'http://tim-server.hol.es/site/user/logout.php';
$PROFILE_PAGE = 'http://tim-server.hol.es/site/user/profile.php';

echo RelativePath('http://tim-server.hol.es/site/user/login.php');

?>