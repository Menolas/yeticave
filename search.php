<?php

require('init.php');

$title = 'Yeticave - результаты поиска';
$lots_searched = [];

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['search'])) {
  
  $search_unfiltered = trim($_GET['search']) ?? '';
  $search = mysqli_real_escape_string($link, $search_unfiltered);

  if ($search !== '') {
    
    // Считаем сколько всего лотов нашлось по переданному запросу
    $lots_searched = get_searched_lots($link, $search);
    $items_count = count($lots_searched);

    // Максимальное кол-во лотов на странице
    $page_items = 9;

    // Кол-во страниц
    $pages_count = ceil($items_count / $page_items);
    
    // Массив с номерами страниц
    $pages = range(1, $pages_count);

    // Текущая страница. Если не задана то будет "1"
    $current_page = $_GET['page'] ?? 1;

    // Оффсет для каждой страницы
    $offset = ($current_page - 1) * $page_items;

    
    // запрашиваем лоты по указанному поисковому запросу
    $lots_searched = get_lots_searched($link, $search, $page_items, $offset);
    
    // ссылка для пагинатора
    $page_link = 'search.php?search=' . $search . '&';

    if ($lots_searched = get_lots_searched($link, $search, $page_items, $offset)) {

        $pagination = include_template('pagination.php', [
          'pages_count' => $pages_count,
          'pages' => $pages,
          'current_page' => $current_page,
          'page_link' => $page_link]);

        $page_content = include_template('search.php', [
          'categories' => $categories,
          'pagination' => $pagination,
          'lots_searched' => $lots_searched,
          'page_items' => $page_items,
          'offset' => $offset,
          'pages' => $pages,
          'pages_count' => $pages_count,
          'current_page' => $current_page,
          'link' => $link,
          'search' => $search]);

        $layout_content = include_template ('layout.php', [
          'page_content' => $page_content,
          'categories' => $categories,
          'title' => $title,
          'user' => $user,
          'search' => $search]);
    }
  }
}

$pagination = include_template('blocks/pagination.php', [
          'pages_count' => $pages_count,
          'pages' => $pages,
          'current_page' => $current_page,
          'page_link' => $page_link]);

$page_content = include_template('search.php', [
          'categories' => $categories,
          'pagination' => $pagination,
          'lots_searched' => $lots_searched,
          'page_items' => $page_items,
          'offset' => $offset,
          'pages' => $pages,
          'pages_count' => $pages_count,
          'current_page' => $current_page,
          'link' => $link,
          'search' => $search]);

$layout_content = include_template ('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'user' => $user,
    'search' => $search]);

print($layout_content);

