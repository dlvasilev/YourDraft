<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Маркирай каот прочетено съобщението - Код//
session_start();
require_once "database/connect.php";
$messageid = preg_replace('#[^0-9]#i', '', $_POST['messageid']); 
$ownerid = preg_replace('#[^0-9]#i', '', $_POST['ownerid']);
$my_id = $_SESSION['user_id'];
if ($ownerid != $my_id) {
	exit();
} else {
    mysql_query("UPDATE private_messages SET opened='1' WHERE id='$messageid' LIMIT 1"); 
}
?>