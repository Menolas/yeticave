USE yeticave;

-- заполняем таблицы

INSERT INTO categories (id, name) VALUES
  (1, 'Доски и лыжи'),
  (2, 'Ботинки'),
  (3, 'Одежда'),
  (4, 'Инструменты'),
  (5, 'Разное'),
  (6, 'Крепления');

INSERT INTO users SET
  id = 1,
  created_at = '2014-06-06 00:00:00',
  email = 'silva_ho@hotmail.com',
  name = 'Сильвана',
  password = 'bloodyhell',
  avatar = 'silva.jpg',
  contacts = 'Northrend, Dalaran City, Sunreavers Sunctuary';

INSERT INTO users SET
  id = 2,
  created_at = '2016-01-01 00:00:00',
  email = 'pendalf_syniy@hotmail.com',
  name = 'Пендальф',
  password = 'magickforever',
  avatar = 'pend.png',
  contacts = 'Northrend, Dalaran City, Runeweaver square, Dalaran Inn';

INSERT INTO lots SET
  id = 1,
  created_at = '2018-09-30 12:06:34',
  end_date = '20.10.2018',
  category_id = 1,
  title = '2014 Rossignol District Snowboard',
  description = 'Те, кому когда-либо приходилось делать в квартире ремонт, наверное, обращали внимание на старые газеты, наклеенные под обоями. Как правило, пока все статьи не перечитаешь, ничего другого делать не можешь. Интересно же — обрывки текста, чья-то жизнь... Так же и с рыбой. Пока заказчик не прочтет всё, он не успокоится. Бывали случаи, когда дизайн принимался именно из-за рыбного текста, который, разумеется, никакого отношения к работе не имел.',
  image = 'lot-1.jpg',
  start_price = 10999,
  lot_step = 100,
  user_id = 1;

INSERT INTO lots SET
  id = 2,
  created_at = '2018-09-30 13:06:34',
  end_date = '20.10.2018',
  category_id = 1,
  title = 'DC Ply Mens 2016/2017 Snowboard',
  description = 'Те, кому когда-либо приходилось делать в квартире ремонт, наверное, обращали внимание на старые газеты, наклеенные под обоями. Как правило, пока все статьи не перечитаешь, ничего другого делать не можешь. Интересно же — обрывки текста, чья-то жизнь... Так же и с рыбой. Пока заказчик не прочтет всё, он не успокоится. Бывали случаи, когда дизайн принимался именно из-за рыбного текста, который, разумеется, никакого отношения к работе не имел.',
  image = 'lot-2.jpg',
  start_price = 159999,
  lot_step = 100,
  user_id = 2;

INSERT INTO lots SET
  id = 3,
  created_at = '2018-09-30 14:06:34',
  end_date = '20.10.2018',
  category_id = 6,
  title = 'Крепления Union Contact Pro 2015 года размер L/XL',
  description = 'Те, кому когда-либо приходилось делать в квартире ремонт, наверное, обращали внимание на старые газеты, наклеенные под обоями. Как правило, пока все статьи не перечитаешь, ничего другого делать не можешь. Интересно же — обрывки текста, чья-то жизнь... Так же и с рыбой. Пока заказчик не прочтет всё, он не успокоится. Бывали случаи, когда дизайн принимался именно из-за рыбного текста, который, разумеется, никакого отношения к работе не имел.',
  image = 'lot-3.jpg',
  start_price = 8000,
  lot_step = 100,
  user_id = 1;

INSERT INTO lots SET
  id = 4,
  created_at = '2018-09-30 16:06:34',
  end_date = '20.10.2018',
  category_id = 2,
  title = 'Ботинки для сноуборда DC Mutiny Charocal',
  description = 'Те, кому когда-либо приходилось делать в квартире ремонт, наверное, обращали внимание на старые газеты, наклеенные под обоями. Как правило, пока все статьи не перечитаешь, ничего другого делать не можешь. Интересно же — обрывки текста, чья-то жизнь... Так же и с рыбой. Пока заказчик не прочтет всё, он не успокоится. Бывали случаи, когда дизайн принимался именно из-за рыбного текста, который, разумеется, никакого отношения к работе не имел.',
  image = 'lot-4.jpg',
  start_price = 10999,
  lot_step = 100,
  user_id = 1;

INSERT INTO lots SET
  id = 5,
  created_at = '2018-09-30 18:06:34',
  end_date = '20.10.2018',
  category_id = 3,
  title = 'Куртка для сноуборда DC Mutiny Charocal',
  description = 'Те, кому когда-либо приходилось делать в квартире ремонт, наверное, обращали внимание на старые газеты, наклеенные под обоями. Как правило, пока все статьи не перечитаешь, ничего другого делать не можешь. Интересно же — обрывки текста, чья-то жизнь... Так же и с рыбой. Пока заказчик не прочтет всё, он не успокоится. Бывали случаи, когда дизайн принимался именно из-за рыбного текста, который, разумеется, никакого отношения к работе не имел.',
  image = 'lot-5.jpg',
  start_price = 7500,
  lot_step = 100,
  user_id = 2;

INSERT INTO lots SET
  id = 6,
  created_at = '2018-09-30 10:06:34',
  end_date = '20.10.2018',
  category_id = 5,
  title = 'Маска Oakley Canopy',
  description = 'Те, кому когда-либо приходилось делать в квартире ремонт, наверное, обращали внимание на старые газеты, наклеенные под обоями. Как правило, пока все статьи не перечитаешь, ничего другого делать не можешь. Интересно же — обрывки текста, чья-то жизнь... Так же и с рыбой. Пока заказчик не прочтет всё, он не успокоится. Бывали случаи, когда дизайн принимался именно из-за рыбного текста, который, разумеется, никакого отношения к работе не имел.',
  image = 'lot-6.jpg',
  start_price = 5400,
  lot_step = 100,
  user_id = 1;

INSERT INTO bids SET 
  amount = 9000,
  created_at = '2018-09-30 20:06:34',
  lot_id = 3,
  user_id = 2;

INSERT INTO bids SET 
  amount = 5700,
  created_at = '2018-09-30 21:06:34',
  lot_id = 6,
  user_id = 2;

INSERT INTO bids SET 
  amount = 7500,
  created_at = '2018-09-30 19:06:34',
  lot_id = 5,
  user_id = 1;

INSERT INTO bids SET 
  amount = 10999,
  created_at = '2018-09-30 22:06:34',
  lot_id = 4,
  user_id = 2;

INSERT INTO bids SET
    amount = 9800,
    user_id = 1,
    lot_id = 3;

-- получить все категории

SELECT * FROM categories;

-- получить самые новые открытые лоты 

SELECT l.title, l.start_price, l.image, c.name
FROM lots l
JOIN categories c ON c.id = l.category_id
WHERE l.end_date > NOW()
ORDER BY l.created_at DESC;

-- показать лот по его id

SELECT l.title, l.start_price, l.image, l.end_date, c.name
FROM lots l
JOIN categories c ON c.id = l.category_id
WHERE l.id = $id;

-- обновить название лота по его идентификатору

UPDATE lots SET title = 'Ковер самолет'
WHERE id = $id;

-- получить список самых свежих ставок для лота по его идентификатору

SELECT * FROM bets
WHERE lot_id = $id
ORDER BY created_at DESC;
