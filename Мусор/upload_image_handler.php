<?php

echo 'test<br>';

function GetExt($filename)
{
  $elements = explode(".", $filename);
  $last_element = count($elements)-1;
  return $elements[$last_element];
}

$MAX_AVATAR_FILE_SIZE = 1024*1024;
$MAX_AVATAR_WIDTH = 500;
$MAX_AVATAR_HEIGHT = 1500;
$USER_AVATAR_FIELD_NAME = 'userfile';
$USER_AVATAR_UPLOAD_DIR = 'images/';

if (empty($errors))
{
	$mime = $_FILES[$USER_AVATAR_FIELD_NAME]['type'];

	if ($mime != "image/gif" && $mime != "image/jpeg" && $mime != "image/png") $errors[] = 'Only gif, png, jpg 1';
}

if (empty($errors))
{
	$filename = $_FILES[$USER_AVATAR_FIELD_NAME]["name"];
	 echo 'name '.$_FILES[$USER_AVATAR_FIELD_NAME]["name"];

	$ext = GetExt($filename);

	if ($ext != "gif" && $ext != "jpeg" && $ext != "jpg" && $ext != "png") $errors[] = 'Only gif, png, jpg, jpeg 2';
}

if (empty($errors))
{
	if($_FILES[$USER_AVATAR_FIELD_NAME]['size'] == 0 or $_FILES[$USER_AVATAR_FIELD_NAME]['size'] > $MAX_AVATAR_FILE_SIZE) $errors[] = 'Max File Size: '.$MAX_AVATAR_FILE_SIZE;
}
	
if (empty($errors))
{
	$new_filename = date(YmdHis).rand(100,1000).'.'.$ext; 
	$new_filepath = $USER_AVATAR_UPLOAD_DIR.$new_filename; 

	if (move_uploaded_file($_FILES[$USER_AVATAR_FIELD_NAME]['tmp_name'], $new_filepath))
	{
	  $size = getimagesize($filepath); 
	  if ($size[0] > $MAX_AVATAR_WIDTH && $size[1] > $MAX_AVATAR_HEIGHT)
	  {
		$errors[] = 'Max iamge size: '.$MAX_AVATAR_WIDTH.':'.$MAX_AVATAR_HEIGHT;
		unlink($new_filepath);
	  }
	}
	else
	{
	 $errors[] = 'Error. Return back and try again';
	}
}

if (empty($errors))
{
	echo 'OK';
}
else
{
	foreach($errors AS $error)
	{
		echo $error."<br>";
	}
}

?>