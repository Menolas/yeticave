<?php

error_reporting (E_ALL);
ini_set ('display_errors', 1);

date_default_timezone_set ('Europe/Moscow');

require('functions.php');

$link = connect_db ();


$categories = get_categories ($link);
$lots = get_lots($link);

$is_auth = rand(0, 1);

$user_name = 'Menolas'; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';


$page_content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная страница',
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'is_auth' => $is_auth]);

print($layout_content);

