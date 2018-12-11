<?php

require('init.php');

$values = [];
$errors = [];
$user = [];

// проверка отправлена ли форма

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // проверяем валидность полей

    //валидность адреса электронной почты

    if (isset($_POST['email'])) {

        $values['email'] = trim($_POST['email']);

        if ($values['email'] !== '' && filter_var($values['email'], FILTER_VALIDATE_EMAIL)) {
          
          $user = find_user_by_email($link, $values['email']);

          if(!find_user_by_email($link, $values['email'])) {
            
            $errors['email'] = 'Пользователя с таким адресом электронной почты не существует';
          } 
        } else {
        
            $errors['email'] = 'Некорректно введен адрес электронной почты';
        }

    } else {

        $errors['email'] = 'Введите адрес своей электронной почты';
    }

    // соответствие пароля юзеру с введенным ранее email

    if (isset($_POST['password'])) {

        $values['password'] = trim($_POST['password']);

        if ($values['password'] === '') {

            $errors['password'] = 'Введите свой пароль';

        } else {
            
            if (password_verify($values['password'], $user['password'])) {
              
            } else {
              $errors['password'] = 'Неверный пароль';
            }
        }

    } else {

        $errors['password'] = 'Введите свой пароль';
    }

    // если в массиве ошибок таковых нет то перенаправляем пользователя на главную страницу 

    if (count($errors) === 0) {
      $_SESSION['user'] = $user;
      header("Location: index.php");
      die;
    } else {
        $page_content = include_template('login.php', [
          'categories' => $categories,
          'errors' => $errors,
          'values' => $values,
          'user' => $user]);
    }
}

$page_content = include_template('login.php', [
    'categories' => $categories,
    'errors' => $errors,
    'values' => $values,
    'user' => $user]);

$layout_content = include_template ('layout.php', [
    'page_content' => $page_content,
    'categories' => $categories,
    'title' => 'Yeticave - Главная страница',
    'user_name' => $user_name,
    'user_avatar' => $user_avatar,
    'is_auth' => $is_auth]);

print($layout_content);

