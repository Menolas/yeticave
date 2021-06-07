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

List of the screens:

1. Main page.
2. Sign UP page.
3. Log Inn page.
4. Creating a lot.
5. Creating a bid.

Main entities:

1. User

   Fields:
   * created time
   * email
   * name
   * password
   * avatar
   * contacts
   
2. Lot

  Fields:
  * date of creation
  * date of ending
  * category id
  * title
  * description
  * image
  * start price
  * lot step
  * created user
  * winner id
  
  Relations:
  * user - creator of the lot
  * category - category of the lot
  * winner - who won the lot
  

3. Bid

   Fields:
   * date of creation
   * amount
   * user id
   * lot id
   
   Relations:
   * Lot
   * User
   
4. Category
   
   Fields:
   * name

Only logged inn users can see and make the bids and create the lots.

Not logged Inn users can just see the lots.
