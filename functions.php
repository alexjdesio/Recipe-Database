<?php

function url_for($file) {
  // add the leading '/' if not present
  if($file[0] != '/') {
    $file = "/" . $file;
  }
  return WWW_ROOT . $file;
}

function redirect($location) {
  header("Location: " . $location);
  exit;
}

function is_post_request() {
  return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function is_get_request() {
  return $_SERVER['REQUEST_METHOD'] == 'GET';
}

function h($text){
  return htmlspecialchars($text);
}

function connect_to_db(){
  $host = 'localhost';
  $user = 'webuser';
  $password = 'password';
  $database = 'recipes';
  $db = mysqli_connect($host,$user,$password,$database);
  return $db;
}

//Returns the file extension
function file_extension($file){
  $file_pathinfo = pathinfo($file);
  return $file_pathinfo['extension'];
}

//Checks if file contains php code
function contains_php($file) {
	$file_contents = file_get_contents($file);
	$position = strpos($contents, '<?php');
  return $position !== false;
}


?>
