<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл за вързката със сървъра 
$connect_error = 'Не мога да се свържа със сървъра :(((';
mysql_connect('localhost', 'root', '') or die($connect_error); // Сървър, Сървър_Акаунт, Парола
mysql_select_db('yourdraft') or die($connect_error);  // База данни
mysql_query("SET NAMES utf8"); // Колация
?>
