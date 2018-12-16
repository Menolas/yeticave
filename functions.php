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
}

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
}

function get_categories ($con) {
  $sql = "
    SELECT id, name FROM categories";
  $categories = db_run_query ($con, $sql);
  return $categories;
}

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
}

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
}

function format_sum ($num) {
    $res = number_format(ceil($num), 0, '', ' ');
    $res = $res . " &#8381;";
    return $res;
}

/**
 * ВЫчислить время оставшееся до полуночи.
 *
 * @return integer
 */
function time_left_till_midnight_format () {

  $tomorrow_midnight = strtotime('tomorrow midnight');
  $left = $tomorrow_midnight - time();
  $hours = floor($left / 3600);
  $min = floor(($left - ($hours * 3600)) / 60);
  $till_midnight = $hours . ':' . $min;
  return $till_midnight;
}

/**
 * ВЫчислить время оставшееся до полуночи.
 *
 * @return integer
 */
function time_left_till_midnight () {

  $tomorrow_midnight = strtotime('tomorrow midnight');
  $till_midnight = $tomorrow_midnight - time();
  return $till_midnight;
}

function get_lots ($con) {
  $sql = "
    SELECT l.id, l.title, l.start_price, l.image, l.description, l.end_date, 
      c.name AS category_name
    FROM lots l
    JOIN categories c ON c.id = l.category_id
    WHERE l.end_date > NOW()
    ORDER BY l.created_at DESC;";

  $lots = db_run_query($con, $sql);
  return $lots;
}

function get_lot ($con, $id) {
  $sql = "
    SELECT l.id, l.title, l.start_price, l.image, l.description, l.end_date, 
      c.name AS category_name, MAX(b.amount) AS current_price, l.lot_step, l.user_id, MAX(b.amount) + l.lot_step AS min_bid
    FROM lots l
    JOIN categories c ON c.id = l.category_id
    JOIN bids b ON b.lot_id = l.id
    WHERE l.id = $id;";
  $lot = db_run_query($con, $sql);

  if (count($lot)) {
    return $lot;
  }
  return false;
}

/**
 * Получить количество лотов из базы данных удовлетворяющих параметру поиска.
 *
 * @param object $con Ссылка для подключения к базе данных *
 * @param string $search Строка поиска
 *
 * @return integer
 */
function get_searched_lots ($con, $search) {
  $sql = "
    SELECT l.id
    FROM lots l
    WHERE MATCH(l.title, l.description) AGAINST('$search');";

    $lots = db_run_query($con, $sql);
    
    return $lots;
}

/**
 * Получить лоты из базы данных удовлетворяющие параметру поиска.
 *
 * @param object $con Ссылка для подключения к базе данных *
 * @param string $search Строка поиска
 * @param integer $page_items Количество страниц для пагинации
 * @param integer $offset Количество объектов на которое производится смещение по таблице данных
 *
 * @return array|false
 */
function get_lots_searched ($con, $search, $page_items, $offset) {

  $sql_search_lot = "
    SELECT l.id, l.title, l.start_price, l.image, c.name AS category_name, l.description, MAX(b.amount) + l.lot_step AS min_bid, MAX(b.amount) AS current_price, l.end_date
    FROM lots l
    JOIN categories c ON c.id = l.category_id
    LEFT JOIN bids b ON b.lot_id = l.id
    WHERE MATCH(l.title, l.description) AGAINST('$search')
    GROUP BY l.id
    ORDER BY l.created_at DESC LIMIT " . $page_items . " OFFSET " . $offset;

    $lots_searched = db_run_query($con, $sql_search_lot);

    if (count($lots_searched)) {
      return $lots_searched;
    }
    return false;
}

/**
 * Получить массив лотов без победителей у кторых закончилось время торгов
 *
 * @param object $con Ссылка для подключения к базе данных *
 *
 * @return array
 */
function get_no_winners_lots ($con) {
  $sql = "
    SELECT l.id, l.title
    FROM lots l
    WHERE l.winner_id IS NULL AND l.end_date <= CURDATE()
    GROUP BY l.id;";

  $lots = db_run_query($con, $sql);
 
  if ($lots) {
    return $lots;
  }
  return false;
}

/**
 * Найти пользователя по id в базе данных.
 *
 * @param object $con Ссылка для подключения к базе данных *
 * @param integer $id ID пользователя
 *
 * @return array|false
 */
function get_user_by_id ($con, $id) {

  $sql_get_user = "
    SELECT * FROM users WHERE id = $id;";
  $user = db_run_query($con, $sql_get_user);

  if (count($user)) {
    return $user[0];
  } 
  return false;
}

/**
 * Получить ставки для конкретного лота по его id.
 *
 * @param object $con Ссылка для подключения к базе данных *
 * @param integer $lot_id Id лота
 *
 * @return array
 */
function db_get_bids ($con, $lot_id) {

  $sql_get_bids = "
    SELECT u.name, b.amount, b.created_at, b.user_id
    FROM bids b
    JOIN users u ON u.id = b.user_id
    JOIN lots l ON l.id = b.lot_id
    WHERE l.id = $lot_id
    ORDER BY b.created_at DESC;";

    $bids = db_run_query($con, $sql_get_bids);
    
    return $bids;
}

/**
 * Отформатировать дату создания ставки в человеческий формат.
 *
 * @param string $time Дата создания ставки
 *
 * @return string
 */
function get_time_bid_created ($time) {

  $time_gone = time() - strtotime($time);

  if ($time_gone < 60) {
    return "только что";
  } else if ($time_gone < 3600) {
      return floor($time_gone / 60) . " минут назад";
  } else if ($time_gone < 86400) {
      return floor($time_gone / 3600) . " часов назад";
  }

  return floor($time_gone / 86400) . " дней назад";
}

/**
 * Получить расширение файла.
 *
 * @param array $key член массива $_FILE под ключом ['image']
 *
 * @return string
 */
function get_file_extention ($key) {
  
  $file_tmp_name = $key['tmp_name'];
  $type = mime_content_type($file_tmp_name);

  switch ($type) {
    case 'image/png':
      return '.png';
    case 'image/jpeg':
      return '.jpeg';
    case 'image/jpg':
      return '.jpg';
    default:
     return '';
  }
}

/**
 * Загрузить полученный файл.
 *
 * @param string $key член массива $_FILE под ключом ['image']
 * @param string $dic Имя папки куда загружается файл
 *
 * @return string|false
 */
function image_uploaded ($key, $dic) {

  $file_extention = get_file_extention($key);
  if ($file_extention) {
    $file_name = uniqid() . $file_extention;
    move_uploaded_file($key['tmp_name'], $dic . $file_name);
    return $file_name;

  } 
  return false;
}

/**
 * Добавить лот в базу данных.
 *
 * @param object $con Ссылка для подключения к базе данных
 * @param number $category ID категория лота
 * @param string $title Название лота
 * @param string $description Описание лота
 * @param number $start_price Стартовая цена лота
 * @param string $end_date Дата оконцания торгов лота
 * @param string $image URL изображения пользователя
 * @param number $lot_step Шаг ставки
 * @param number $user_id Id пользователя
 *
 * @return object|false
 */
function db_insert_lot (
  $con, $category, $title, $description, $start_price, $end_date, $image, 
  $lot_step, $user_id) {

  $filtered_title = mysqli_real_escape_string($con, $title);
  $filtered_description = mysqli_real_escape_string($con, $description);
  $filtered_start_price = mysqli_real_escape_string($con, $start_price);
  $filtered_end_date = mysqli_real_escape_string($con, $end_date);
  $filtered_lot_step = mysqli_real_escape_string($con, $lot_step);
  $filtered_user_id = mysqli_real_escape_string($con, $user_id);
  $sql = "
    INSERT INTO lots SET
    category_id = '$category',
    title = '$filtered_title',
    description = '$filtered_description', 
    start_price = $filtered_start_price,
    end_date = '$filtered_end_date',
    image = '$image',
    lot_step = '$filtered_lot_step',
    user_id = '$filtered_user_id';";

  $res = mysqli_query($con, $sql);
  
  if (!$res) {
    $error = mysqli_error($con);
    print("Ошибка MySQL:" . $error);
    die();
  }
  return $res;
}

/**
 * Добавить зарегестрированного пользователя в базу данных.
 *
 * @param object $con Ссылка для подключения к базе данных
 * @param string $email Емейл пользователя
 * @param string $name Имя пользователя
 * @param string $password Пароль пользователя
 * @param string $avatar URL аватара пользователя
 * @param string $contacts Контакты пользователя
 *
 * @return object|false
 */
function db_insert_user ($con, $email, $name, $password, $avatar, $contacts) {

  $filtered_email = mysqli_real_escape_string($con, $email);
  $filtered_name = mysqli_real_escape_string($con, $name);
  $filtered_password = mysqli_real_escape_string($con, $password);
  $filtered_contacts = mysqli_real_escape_string($con, $contacts);
  $sql = "
    INSERT INTO users SET
    email = '$filtered_email',
    name = '$filtered_name',
    password = '$filtered_password',
    avatar = '$avatar',
    contacts = '$filtered_contacts';";
  $res = mysqli_query($con, $sql);

  if (!$res) {
    $error = mysqli_error($con);
    print("Ошибка MySQL" . $error);
    die();
  }
  return $res;
}

/**
 * Добавить ставку для определенного лота от определенного пользователя в базу данных.
 *
 * @param object $con Ссылка для подключения к базе данных
 * @param integer $amount Сумма ставки
 * @param integer $id Id пользователя *
 * @param integer $id Id лота
 *
 * @return object|false
 */
function db_insert_bid ($con, $amount, $user_id, $lot_id) {

  $filtered_amount = mysqli_real_escape_string($con, $amount);
  $filtered_user_id = mysqli_real_escape_string($con, $user_id);
  $filtered_lot_id = mysqli_real_escape_string($con, $lot_id);
  $sql_insert_bid = "
    INSERT INTO bids SET
    amount = $filtered_amount,
    user_id = $filtered_user_id,
    lot_id = $filtered_lot_id;";

  $res = mysqli_query($con, $sql_insert_bid);

  if (!$res) {
    $error = mysqli_error($con);
    print("Ошибка MySQL" . $error);
    die();
  }
  return $res;
}

/**
 * Получить массив емейлов пользователей  из базы данных.
 *
 * @param object $con Ссылка для подключения к базе данных
 *
 * @return array
 */
function get_users_emails ($con) {

  $sql_emails = "SELECT email FROM users";
  $result = db_run_query($con, $sql_emails);
  return $result;
}

/**
 * Найти пользователя по емейлу в базе данных.
 *
 * @param object $con Ссылка для подключения к базе данных *
 * @param string $email Емейл пользователя
 *
 * @return array|false
 */
function find_user_by_email ($con, $email) {

  $filtered_email = mysqli_real_escape_string($con, $email);
  $sql_find_email = "
    SELECT * FROM users WHERE email = '$filtered_email';";
  $user = db_run_query($con, $sql_find_email);

  if (count($user)) {
    return $user[0];
  } 
  return false;
}

/**
 * Выяснить есть ли в массиве ставок для определенного лота ставки сделанные определенным пользователем.
 *
 * @param object $con Ссылка для подключения к базе данных *
 * @param number $id Id пользователя *
 * @param number $id Id лота
 *
 * @return boolean
 */
function find_user_bid ($con, $id, $lot) {
  
  $sql_find_bid = "
  SELECT b.lot_id
  FROM bids b
  WHERE b.user_id = $id;";
  $bids = db_run_query($con, $sql_find_bid);

  if ($bids) {
    foreach ($bids as $bid) {
      if ($bid['lot_id'] === $lot) {
        return true;
      }
    } 
  }
  return false;
}

/**
 * Вычислить не закончилось ли время торгов для конкретного лота.
 *
 * @param string $time Время окончания торгов.
 *
 * @return boolean
 */
function is_time_left ($time) {

  $time_left = strtotime($time) - time();
  if ($time_left > 0) {
    return true;
  }
  return false;
}

/**
 * Вычислить время оставшееся до окончания торгов для конкретного лота.
 *
 * @param array $lot Лот.
 *
 * @return string
 */
function time_left ($lot) {
    
  $time_left = strtotime($lot['end_date']) - time();
  $hours = floor($time_left / 3600);
  $minutes = floor(($time_left % 3600) / 60);
  $time_left = $hours . ":" . $minutes;

  return $time_left;
}
