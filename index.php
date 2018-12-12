<?php

//php -S 127.0.0.1:8000

require('init.php');

$lots = get_lots($link);

$page_content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots]);

$layout_content = include_template('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная страница',
    'user' => $user]);

print($layout_content);
