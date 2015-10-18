<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Код за излизане//
session_start();
include 'init.php';
mysql_query("UPDATE `users` SET `here`='0' WHERE `user_id` = '" . $_SESSION['user_id'] . "'") or die(mysql_error());
session_destroy();
header('Location: ../home');
?>
