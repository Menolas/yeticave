# Личный проект «YetiCave»
studying project (PHP step 1 - HTML Academy)

Used Technologies: PHP 7.0+ / MySQL 5.7+.

«YetiCave» — this is an online auction. The service helps users find and place bids on existing lots, as well as create their own lots.

After creating an account, the users can start placing bids and creating their lots.

The main scenarios for using the site:

* creation of lots
* creating bids
* viewing lots

BD credentials MySQL: root / ''.

The BD scheme is in the root of the project (schema.sql).

Implemented Functionality:

* Sign UP of new users.
* Log Inn sign upped users.
* Creating and deleting the lots.
* Sorting and filtering lots by categories.
* Searching for lots by part of the title.
* Creating new bids.
* server validation of the forms with displaying all errors.

Список экранов:

1. Главная страница (боковое меню и список задач).
2. Регистрация аккаунта.
3. Авторизация на сайте (модальное окно).
4. Добавление лота.
5. Добавление ставки.

Основные сущности:

1. Лот

  Поля:
  дата создания
  название
  
  Связи:
  автор — пользователь, создавший задачу;
  проект — проект, к которому принадлежит задача.
  Пользователь
  Представляет зарегистрированного пользователя.


2. Ставка

   Поля:
   дата создания;
   название;


Сайт могут использовать только зарегистрированные пользователи.

Анонимный пользователь всегда видит только страницу входа на сайт.
