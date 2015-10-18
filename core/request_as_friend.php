<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Приятелство - Код//
session_start();
$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);
if (!isset($_SESSION['wipit'])) {
    echo  'Error: Сесията ти вече е изтекла. Моля презаредете страницата';
    exit();
}
if ($sessWipit != $thisWipit) {
    echo  'Нещо се е объркало';
    exit();
}
if ($thisWipit == "") {
    echo  'Error: Грешка..';
    exit();
}
include_once 'database/connect.php';
if($_POST["request"] == "requestFriendship") {
    $mem1 = preg_replace('#[^0-9]#i', '', $_POST['mem1']);
    $mem2 = preg_replace('#[^0-9]#i', '', $_POST['mem2']);
    if(!$mem1 || !$mem2 || !$thisWipit) {
        echo 'Error: Нещо липсва';
        exit();
    }
    if($mem1 == $mem2) {
        echo 'Error: Не можеш да добавиш себе си';
        exit();
    }
    $sql = mysql_query("SELECT `id` FROM `friend_requests` WHERE `mem1`='$mem1' AND `mem2`='$mem2' LIMIT 1");
    $numRows = mysql_num_rows($sql);
    if ($numRows > 0) {
        echo 'Вече сте изпратили покана за приятелство. Моля изчакайте тя да бъде подтвърдена';
        exit(); 
    }
    $sql = mysql_query("SELECT `id` FROM `friend_requests` WHERE `mem1`='$mem2' AND `mem2`='$mem1' LIMIT 1");
    $numRows = mysql_num_rows($sql);
    if ($numRows > 0) {
        echo 'Вие сте приятели.';
        exit();
    }
    $sql = mysql_query("INSERT INTO friend_requests (mem1, mem2, timedate) VALUES ('$mem1','$mem2', now())") or die(mysql_error("ERROR: проблем с БД"));
echo 'Поканата за приятелство е изпратена успешно. Моля изчакайте нейното одобрение.';
exit();
}
if ($_POST["request"] == "acceptFriend") {
    $reqID = preg_replace('#[^0-9]#i', '', $_POST['reqID']);
	$sql = "SELECT * FROM friend_requests WHERE id='$reqID' LIMIT 1";
	$query = mysql_query($sql) or die ("Имаме грешка във системата...");
	$num_rows = mysql_num_rows($query); 
	if ($num_rows < 1) {
		echo 'Излезе някаква грешка..';
		exit();
	}
    while ($row = mysql_fetch_array($query)) { 
	$mem1 = $row["mem1"];
	$mem2 = $row["mem2"];
    }
	$sql_frnd_arry_mem1 = mysql_query("SELECT friend_array FROM users WHERE user_id='$mem1' LIMIT 1"); 
	$sql_frnd_arry_mem2 = mysql_query("SELECT friend_array FROM users WHERE user_id='$mem2' LIMIT 1"); 
	while($row=mysql_fetch_array($sql_frnd_arry_mem1)) {$frnd_arry_mem1 = $row["friend_array"];}
	while($row=mysql_fetch_array($sql_frnd_arry_mem2)) {$frnd_arry_mem2 = $row["friend_array"];}
	$frndArryMem1 = explode(",", $frnd_arry_mem1);
	$frndArryMem2 = explode(",", $frnd_arry_mem2);
        if (in_array($mem2, $frndArryMem1)) {echo  'Вие сте приятели'; exit();}
	if (in_array($mem1, $frndArryMem2)) {echo  'Вие сте приятели'; exit();}
	if ($frnd_arry_mem1 != "") {$frnd_arry_mem1 = "$frnd_arry_mem1,$mem2";} else {$frnd_arry_mem1 = "$mem2";}
	if ($frnd_arry_mem2 != "") {$frnd_arry_mem2 = "$frnd_arry_mem2,$mem1";} else {$frnd_arry_mem2 = "$mem1";}
        $UpdateArrayMem1 = mysql_query("UPDATE users SET friend_array='$frnd_arry_mem1' WHERE user_id='$mem1'") or die (mysql_error());
        $UpdateArrayMem2 = mysql_query("UPDATE users SET friend_array='$frnd_arry_mem2' WHERE user_id='$mem2'") or die (mysql_error());
	$deleteThisPendingRequest = mysql_query("DELETE FROM friend_requests WHERE id='$reqID' LIMIT 1"); 
    echo "Успешно станахте приятели!";
    exit();
}
if ($_POST["request"] == "denyFriend") {
    $reqID = preg_replace('#[^0-9]#i', '', $_POST['reqID']);
    $deleteThisPendingRequest = mysql_query("DELETE FROM friend_requests WHERE id='$reqID' LIMIT 1"); 
    echo "Поканата е отхвърлена";
    exit();
}
if ($_POST["request"] == "removeFriendship") {
	$mem1 = preg_replace('#[^0-9]#i', '', $_POST['mem1']);
        $mem2 = preg_replace('#[^0-9]#i', '', $_POST['mem2']);
	if (!$mem1 || !$mem2 || !$thisWipit) {
		echo  'Нещо липсва...';
    	exit(); 
	}
	$sql_frnd_arry_mem1 = mysql_query("SELECT `friend_array` FROM `users` WHERE `user_id`='$mem1' LIMIT 1"); 
	$sql_frnd_arry_mem2 = mysql_query("SELECT `friend_array` FROM `users` WHERE `user_id`='$mem2' LIMIT 1"); 
	while($row=mysql_fetch_array($sql_frnd_arry_mem1)) { $frnd_arry_mem1 = $row["friend_array"]; }
	while($row=mysql_fetch_array($sql_frnd_arry_mem2)) { $frnd_arry_mem2 = $row["friend_array"]; }
	$frndArryMem1 = explode(",", $frnd_arry_mem1);
	$frndArryMem2 = explode(",", $frnd_arry_mem2);
	foreach ($frndArryMem1 as $key => $value) {
			  if ($value == $mem2) {
			      unset($frndArryMem1[$key]);
			  } 
        }
	foreach ($frndArryMem2 as $key => $value) {
			  if ($value == $mem1) {
			      unset($frndArryMem2[$key]);
			  } 
        } 
    $newStringForMem1 = implode(",", $frndArryMem1);
    $newStringForMem2 =  implode(",", $frndArryMem2);
    $sql = mysql_query("UPDATE `users` SET `friend_array`='$newStringForMem1' WHERE `user_id`='$mem1'");
    $sql = mysql_query("UPDATE `users` SET `friend_array`='$newStringForMem2' WHERE `user_id`='$mem2'");
    echo 'Вие вече не сте приятели';
    exit(); 
}
?>
