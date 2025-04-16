# Montana-Route-Planner

Created for my Web Science course at Montana Technological University.

PROBLEM:
Traveling Montana's interstates in winter can be dangerous, especially since weather conditions change often.

SOLUTION:
Create a full-stack, interactive web application that allows users to select a start and end point along Montana's interstate system (I-90, I-94, and I-15), and return forecasts along their selected route using the National Weather Service API. The project also included a secure login form to allow an admin user to access a statistics screen showing the most common selected routes for analysis by users.

TECHNOLOGY STACK:
HTML
CSS
JavaScript (limited - mainly for API calls and parsing)
PHP
MySQL


INSTALLATION GUIDE:

1. The contents of the MontanaRoutePlanner folder should be placed at the root level of the web server (in my case, the www folder of AMPPS).
2. For the purpose of easy installation, we are keepign the default phpMyAdmin user (U: root, P: mysql). If you would like to change the credentials, you are free to do so; however, you must remember to change the credentials in the PHP files.
3. Log in to phpMyAdmin (or similar DB interface) and run the code contained in generateTables.sql to set up the DB structure and contents.
4. Access the project from index.php.
