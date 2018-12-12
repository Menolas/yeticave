<?php
error_reporting (E_ALL);
ini_set ('display_errors', 1);

require_once('functions.php');

$link = connect_db();

session_start();

$user = [];

if (isset($_SESSION['user'])) {
    $user = get_user_by_id($link, $_SESSION['user']['id']);
}

$categories = get_categories($link);
    