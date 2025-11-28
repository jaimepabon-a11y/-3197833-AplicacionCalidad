<?php
// GYM/GYM/db.php
$pdo = new PDO('mysql:host=localhost;dbname=gym_db', 'root', '1234');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec("set names utf8");
?>
