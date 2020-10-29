<?php

$ROOT_FOLDER = '/site/';

$DEFAULT_AVATAR_PATH = 'images/users/avatars/default.txt';

$path = substr($_SERVER['PHP_SELF'], strlen($ROOT_FOLDER));

echo 'Path 2: '.$path.'<br>';

$path = dirname($path);
$path = explode('/', $path);
$n = count($path);

echo '$n: '.$n.'<br>';

for ($i = 0; $i < $n; $i++)
{
  $relative_path =  $relative_path.'../';
}

echo 'Relative Path: '.$relative_path.'<br>';
echo 'Relative Path: '.$relative_path.$DEFAULT_AVATAR_PATH;

?>