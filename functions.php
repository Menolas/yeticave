<?php

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
};
;