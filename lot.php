<?php

require('init.php');

$title = 'Yeticave - лот';

if (!isset($_GET['id'])) {
  
  $page_content = include_template('404.php', [
	'categories' => $categories]);
  $layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная страница',
    'user' => $user]);
  print($layout_content);
  die();
  
} else {
    $id = $_GET['id'];
    if (!get_lot($link, $id)) {
        
      $page_content = include_template('404.php', [
	    'categories' => $categories,
            'bids' => $bids]);
      $layout_content = include_template('layout.php', [
		'page_content' => $page_content,
		'categories' => $categories,
		'title' => $title,
		'user' => $user]);
      print($layout_content);
      die();
    }
}

$id = $_GET['id'];
$lot = get_lot($link, $id)[0];
$bids = db_get_bids($link, $id);

$page_content = include_template('lot.php', [
	'categories' => $categories,
	'id' => $id,
        'lot' => $lot,
        'user' => $user,
        'link' => $link,
        'bids' => $bids]);
$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'user' => $user]);

print($layout_content);
