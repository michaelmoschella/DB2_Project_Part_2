Use xampp control panel to start apache and mysql

Commands to set up the database:

mysql -u root
GRANT ALL PRIVILEGES ON *.* TO root@Localhost
CREATE DATABASE DB2;
USE DB2;
source C:\xampp\htdocs\DB2\sql\create_tables.sql

Then you should be able to view db2 at: http://localhost/phpmyadmin
and
start the app at: http://localhost/DB2/useless.html
