<?php

require('init.php');

if (!isset($_GET['id'])) {
  
  $page_content = include_template('404.php', [
	'categories' => $categories]);
  $layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная страница',
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'is_auth' => $is_auth]);
  print($layout_content);
  die();
  
} else {
    $id = $_GET['id'];
    if (!get_lot($link, $id)) {
        
      $page_content = include_template('404.php', [
	    'categories' => $categories]);
      $layout_content = include_template('layout.php', [
		'page_content' => $page_content,
		'categories' => $categories,
		'title' => 'Yeticave - Главная страница',
		'user_name' => $user_name,
		'user_avatar' => $user_avatar,
		'is_auth' => $is_auth]);
      print($layout_content);
      die();
    }
}

$id = $_GET['id'];
$lot = get_lot($link, $id)[0];
var_dump($lot);
die();

$page_content = include_template('lot.php', [
	'categories' => $categories,
	'id' => $id,
    'lot' => $lot]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная страница',
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'is_auth' => $is_auth]);

print($layout_content);
