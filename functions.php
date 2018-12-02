<?php

/**
 * Подключиться к базе данных.
 *
 * @return object
 */
function connect_db () {

  $link = mysqli_connect('127.0.0.1', 'root', 'r512lock', 'yeticave');
  mysqli_set_charset($link, 'utf8');

  if (!$link) {

  print('Ошибка подключения:' . mysqli_connect_error());
  die();
  }

  return $link;
};

/**
 * Получить данные из базы.
 *
 * @param object $con Ссылка для подключения к базе данных *
 * @param string $request SQL запрос
 *
 * @return array
 */
function db_run_query ($con, $request) {

  $result = mysqli_query($con, $request);

  if (!$result) {
    $error = mysqli_error($con);
    print("Ошибка MySQL:" . $error);
    die();
  } else {
    $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
  }
  return $result;
};

function get_categories ($con) {
  $sql = "
    SELECT id, name FROM categories";
  $categories = db_run_query ($con, $sql);
  return $categories;
};

/**
 * Отфильтровать строку от HTML тегов.
 *
 * @param string $str Данные введенные пользователем в поле формы
 *
 * @return string
 */
function esc($str) {

  $text = strip_tags($str);

  return $text;
};

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!file_exists($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
};

function format_sum ($num) {
    $res = number_format(ceil($num), 0, '', ' ');
    $res = $res . " &#8381;";
    return $res;
};

/**
 * ВЫчислить время оставшееся до полуночи.
 *
 * @return integer
 */
function time_left_till_midnight () {

  $tomorrow_midnight = strtotime('tomorrow midnight');
  $left = $tomorrow_midnight - time();
  $hours = floor($left / 3600);
  $min = floor(($left - ($hours * 3600)) / 60);
  $till_midnight = $hours . ':' . $min;
  return $till_midnight;
};

function get_lots ($con) {
  $sql = "
    SELECT l.title, l.start_price, l.image, l.description, l.end_date, c.name AS category_name
    FROM lots l
    JOIN categories c ON c.id = l.category_id
    WHERE l.end_date > NOW()
    ORDER BY l.created_at DESC;";

  $lots = db_run_query($con, $sql);
  return $lots;
};
