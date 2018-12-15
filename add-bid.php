<?php

require('init.php');

$user = [];
$values = [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(403);
  die();
}

if (!isset($_SESSION['user'])) {
  header("Location: login.php");
  die();
}
  
$user = get_user_by_id($link, $_SESSION['user']['id']);

$id = $_POST['lot_id'];
$lot = get_lot($link, $id)[0];

$_POST['amount'] = trim($_POST['amount'] ?? '');

if (!empty($_POST['amount'])) {

  $values['amount'] = $_POST['amount'];

  if (isset($lot['min_bid']) && $values['amount'] >= $lot['min_bid']) {

    $res = db_insert_bid ($link, $values['amount'], $user['id'], $id);

  } else {

      if (!isset($lot['min_bid']) && $values['amount'] >= $lot['start_price']) {
        $res = db_insert_bid ($link, $values['amount'], $user['id'], $id);
      }
  }
}

header("Location: lot.php?id=" . $id);
die();
