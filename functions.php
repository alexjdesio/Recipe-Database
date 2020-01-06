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
?>
