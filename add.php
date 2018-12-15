<?php

require('init.php');

$title = 'Yeticave - Добавление нового лота';

if (isset($_SESSION['user'])) {
    $user = get_user_by_id($link, $_SESSION['user']['id']);
} else {
  http_response_code(403);
  die();
}

$values = [];
$errors = [];
$selected = "";
$category_id = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// проверяем валидность полей
    
    if (isset($_POST['title'])) {
      $values['title'] = trim($_POST['title']);
      if ($values['title'] === '') {
        $errors['title'] = 'Введите наименование лота';
      } 
    } else {
        $errors['title'] = 'Введите наименование лота'; 
    }
    
    if (isset($_POST['category'])) {
      $values['category'] = trim($_POST['category']);
      $category_id = $values['category'];
      if ($values['category'] == 0) {
        $errors['category'] = 'Выберите категорию';
      }
    } else {
        $errors['category'] = 'Выберите категорию';
    }

    if (isset($_POST['description'])) {
      $values['description'] = trim($_POST['description']);
      if ($values['description'] === '') {
        $errors['description'] = 'Напишите краткое описание лота';
      }
    } else {
        $errors['description'] = 'Напишите краткое описание лота';
    }
    
    if (empty($_POST['start_price'])) {
      $errors['start_price'] = 'Введите стартовую цену лота';
    } else {
        if ($_POST['start_price'] <= 0) {
          $errors['start_price'] = 'Числовое значение больше нуля'; 
        } else {
            $values['start_price'] = trim($_POST['start_price']); 
        }
    }
    
    if (empty($_POST['lot_step'])) {
      $errors['lot_step'] = 'Введите минимальный шаг ставки';
    } else {
        if ($_POST['lot_step'] <= 0) {
          $errors['lot_step'] = 'Целое значение больше нуля';
        } else {
            $values['lot_step'] = trim($_POST['lot_step']);
        }
    }

    if (empty($_POST['end_date'])) {
      $errors['end_date'] = 'Введите дату окончания торгов';
    } else {
        $values['end_date'] = date('Y-m-d', strtotime($_POST['end_date']));

        if ((strtotime($_POST['end_date']) - time()) < time_left_till_midnight()) {
          $errors['end_date'] = 'Дата окончания торгов не может быть назначена меньше чем через сутки';
        }
    }

    if (isset($_FILES['image']) && $_FILES['image']['name'] !== '') {
      
      $image = image_uploaded($_FILES['image'], 'img/');

      if ($image) {
        $values['image'] = $image;

      } else {
        $errors['image'] = 'Загружаемый файл должен быть формата jpg/jpeg/png';
      }
    } else {
        $errors['image'] = 'Вы не загрузили файл';  
    }
    
    // если массив ошибок не содержит таковых загружаем лот в базу данных и редиректим на страницу демонстрации этого лота

    if (count($errors) === 0) {
      
      $res = db_insert_lot ($link, $values['category'], $values['title'], $values['description'], $values['start_price'], $values['end_date'], $values['image'], $values['lot_step'], $user['id']);

      if ($res) {
        $lot_id = mysqli_insert_id($link);
        header("Location: lot.php?id=" . $lot_id);
        die;
      }
    }
}

$page_content = include_template('add.php', [
    'errors' => $errors,
    'values' => $values,
    'categories' => $categories,
    'selected' => $selected,
    'category_id' => $category_id]);

$layout_content = include_template ('layout.php', [
  'page_content' => $page_content,
  'categories' => $categories,
  'title' => $title,
  'user' => $user]);

print($layout_content);
