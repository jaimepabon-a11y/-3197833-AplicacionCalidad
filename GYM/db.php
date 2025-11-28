<?php
// GYM/GYM/db.php
$db_password = getenv('DB_PASSWORD'); 
$pdo = new PDO('mysql:host=localhost;dbname=gym_db', 'root', $db_password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("set names utf8");
?>
