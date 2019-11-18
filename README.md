# php_ContactForm

HTML5 and PHP7.x form to save contact information in a mysql or mariadb database.

This project use bootstrap 4.x (css framework), jquery and some jquery plugins like datatable. All required files are integrated via a CDN.

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
SQL script to create the required tables. (tested with mariadb 10.1)

#### More information 
- https://getbootstrap.com/
- https://jquery.com/
- https://datatables.net/
