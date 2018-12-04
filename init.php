<?php
error_reporting (E_ALL);
ini_set ('display_errors', 1);

require_once('functions.php');

$link = connect_db();
$categories = get_categories($link);
$is_auth = rand(0, 1);
$user_name = 'Menolas'; // укажите здесь ваше имя
$user_avatar = 'img/user.jpg';
    