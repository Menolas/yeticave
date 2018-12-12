<?php

require('init.php');

$values = [];
$errors = [];

// проверка отправлена ли форма

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // проверяем валидность полей

    //валидность адреса электронной почты

    if (isset($_POST['email'])) {

        $values['email'] = trim($_POST['email']);

        if ($values['email'] !== '' && filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {

          $emails = get_users_emails($link);

          foreach ($emails as $email) {

            if ($email['email'] === $values['email']) {
              $errors['email'] = 'Пользователь с таким адресом электронной почты уже существует';
            }
          }
        
        } else {
            $errors['email'] = 'Некорректно введен адрес электронной почты';
        }

    } else {

        $errors['email'] = 'Введите адрес своей электронной почты';
    }

    // валидность пароля

    if (isset($_POST['password'])) {

        $values['password'] = trim($_POST['password']);

        if ($values['password'] === '') {

            $errors['password'] = 'Введите свой пароль';
        } else {
            $values['password'] = password_hash($values['password'], PASSWORD_DEFAULT);
        }

    } else {

        $errors['password'] = 'Введите свой пароль';
    }

    // валидность поля именни

    if (isset($_POST['name'])) {

        $values['name'] = trim($_POST['name']);

        if ($values['name'] === '') {

            $errors['name'] = 'Введите свое имя';
        }

    } else {

        $errors['name'] = 'Введите свое имя';
    }

    // валидность поля контактов

    if (isset($_POST['contacts'])) {

        $values['contacts'] = trim($_POST['contacts']);

        if ($values['contacts'] === '') {

            $errors['contacts'] = 'Введите свои контактные данные';
        }
    } else {

        $errors['contacts'] = 'Введите свои контактные данные';
    }

    // проверка на валидность загруженного файла

    if (isset($_FILES['avatar']) && $_FILES['avatar']['name'] !== '') {

      $image = image_uploaded($_FILES['avatar'], 'img/user-pics/');

      if ($image) {

        $values['avatar'] = $image;

      } else {

        $errors['avatar'] = 'Загружаемый файл должен быть формата jpg/jpeg/png';
      }

    } else {

        $values['avatar'] = 'placeholder.png';
    }

    if (count($errors) === 0) {
      
      $res = db_insert_user ($link, $values['email'], $values['name'], $values['password'], $values['avatar'], $values['contacts']);

      if ($res) {
        $lot_id = mysqli_insert_id($link);
        header("Location: login.php");
        die;
      }
    }
}

$page_content = include_template('sign-up.php', [
    'categories' => $categories,
    'errors' => $errors,
    'values' => $values]);

$layout_content = include_template ('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная страница',
    'user' => $user]);

print($layout_content);
