CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME DEFAULT NOW() NOT NULL,
  email CHAR(64) NOT NULL,
  name CHAR(64) NOT NULL,
  password CHAR(64) NOT NULL,
  avatar CHAR(128),
  contacts TEXT NOT NULL,
  UNIQUE KEY (email),
  INDEX (email)
);

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(64),
  UNIQUE KEY (name)
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  created_at DATETIME DEFAULT NOW() NOT NULL,
  end_date DATE NOT NULL,
  category_id INT(8) NOT NULL,
  title CHAR(128) NOT NULL,
  description TEXT NOT NULL,
  image CHAR(128) NOT NULL,
  start_price INT(16) NOT NULL,
  lot_step CHAR(128) NOT NULL,
  user_id INT(8) NOT NULL,
  winner_id INT(8),
  INDEX (end_date),
  INDEX (created_at),
  FULLTEXT lots_search (title, description)
);

CREATE TABLE bids (
  id INT AUTO_INCREMENT PRIMARY  KEY,
  created_at DATETIME DEFAULT NOW() NOT NULL,
  amount INT(16) NOT NULL,
  user_id INT(8) NOT NULL,
  lot_id INT(8) NOT NULL,
  INDEX (created_at),
  INDEX (lot_id)
);
