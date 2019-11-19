# php_ContactForm

HTML5 and PHP 7.x form to save contact information in a mysql or mariadb database.

This project use bootstrap 4.x (css framework), jquery and some jquery plugins like datatable. All required files are integrated via a CDN.

# Installation 

1. Setup a webserver (Apache, nginx, etc.) with PHP 7.x (mod_php or php7.x-fpm). Please check if you have also installed the php-mysql module to connect with mysql/mariadb databases
2. Setup a MySQL or MariaDB Database 
3. Download or clone the git repositotry (git clone https://github.com/nfurmanczak/php_ContactForm.git)
4. Move the html and php file into your document root 
5. Import the database.sql file (mysql < database.sql) to create the database and user
   

### css/min.css 
A simple css file which is used by formular.php. 

### formular.php 
Contains the form for querying the data. The input fields are arranged via the bootstrap form grid system. The validation of the data is done on the client side using javascript and regex patern in the form.

### dbinsert.php 
php file to insert the user data into the mysql or mariadb database using prepared sql queries. The file also contains a debug mode and an option to send the user data via email (php mail). To send emails you need a working mta (like postfix or exim). 

### erfolg.html and fehler.html 
Contains html content to give the user feedback if his data has been saved successfully. The message is displayed via a bootstrap modal popup. 

### mysql_connect.php 
mysqli connector to the local mysql or mariadb database. The connector file is used by formular.php and datenbankinhalt.php. Please make sure you enter the correct login credentials.

### datenbankinhalt.php 
php file with to display the database content with the jquery plugin datatables. 

### database.sql 
SQL script to create the required database and tables. (tested with mariadb 10.1, can maybe not work with other versions from mysql or mariadb)

#### More information 
- https://getbootstrap.com/
- https://jquery.com/
- https://datatables.net/
