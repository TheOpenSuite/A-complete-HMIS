<?php
$host = 'db';        // Docker service name
$user = 'user';      // From MYSQL_USER
$pass = 'password';  // From MYSQL_PASSWORD
$db   = 'my_db';     // From MYSQL_DATABASE
$mysqli=new mysqli($host,$user, $pass, $db);
?>
