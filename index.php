<?php

error_reporting (E_ALL);
ini_set ('display_errors', 1);

require('functions.php');


$categories = ['Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'];
$lots = [
  [
    'name' => '2014 Rossignol District Snowboard',
    'category' => 'Доски и лыжи',
    'price' => '10999',
    'url_path' => 'img/lot-1.jpg'],
  [
    'name' => 'DC Ply Mens 2016/2017 Snowboard',
    'category' => 'Доски и лыжи',
    'price' => '159999',
    'url_path' => 'img/lot-2.jpg'],
  [
    'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
    'category' => 'Крепления',
    'price' => '8000',
    'url_path' => 'img/lot-3.jpg'],
  [
    'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
    'category' => 'Ботинки',
    'price' => '10999',
    'url_path' => 'img/lot-4.jpg'],
  [
    'name' => 'Куртка для сноуборда DC Mutiny Charocal',
    'category' => 'Одежда',
    'price' => '7500',
    'url_path' => 'img/lot-5.jpg'],
  [
    'name' => 'Маска Oakley Canopy',
    'category' => 'Разное',
    'price' => '5400',
    'url_path' => 'img/lot-6.jpg']
];
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

