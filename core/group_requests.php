<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Покани в Група - Код//
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
if($_POST["request"] == "requestGroupmember") {
    $user = preg_replace('#[^0-9]#i', '', $_POST['user']);
    $group = preg_replace('#[^0-9]#i', '', $_POST['group']);
    if(!$user || !$group || !$thisWipit) {
        echo 'Error: Нещо липсва';
        exit();
    }
    $sql = mysql_query("SELECT `id` FROM `group_requests` WHERE `user`='$user' AND `group`='$group' LIMIT 1");
    $numRows = mysql_num_rows($sql);
    if ($numRows > 0) {
        echo 'Вече сте изпратили покана за членство. Моля изчакайте тя да бъде подтвърдена';
        exit(); 
    }
    $sql = mysql_query("SELECT `id` FROM `group_requests` WHERE `user`='$group' AND `group`='$user' LIMIT 1");
    $numRows = mysql_num_rows($sql);
    if ($numRows > 0) {
        echo 'Ти вече си член.';
        exit();
    }
    $sql = mysql_query("INSERT INTO group_requests (`user`, `group`, `timedate`) VALUES ('$user','$group', now())") or die(mysql_error());
echo 'Поканата за членство е изпратена успешно. Моля изчакайте нейното одобрение.';
exit();
}
if ($_POST["request"] == "acceptGroup") {
    $reqID = preg_replace('#[^0-9]#i', '', $_POST['reqID']);
	$sql = "SELECT * FROM group_requests WHERE `id`='$reqID' LIMIT 1";
	$query = mysql_query($sql) or die ("Имаме грешка във системата...");
	$num_rows = mysql_num_rows($query); 
	if ($num_rows < 1) {
		echo 'Излезе някаква грешка..';
		exit();
	}
    while ($row = mysql_fetch_array($query)) { 
	$user = $row["user"];
	$group = $row["group"];
    }
	$sql_group_arry_user = mysql_query("SELECT group_array FROM users WHERE `user_id`='$user' LIMIT 1") or die(mysql_error()); 
	$sql_group_arry_group = mysql_query("SELECT users_array FROM groups WHERE `id`='$group' LIMIT 1") or die(mysql_error()); 
	while($row=mysql_fetch_array($sql_group_arry_user)) {$group_arry_user = $row["group_array"];}
	while($row=mysql_fetch_array($sql_group_arry_group)) {$group_arry_group = $row["users_array"];}
	$groupArryUser = explode(",", $group_arry_user);
	$groupArryGroup = explode(",", $group_arry_group);
        if (in_array($group, $groupArryUser)) {echo  'Вие сте приятели'; exit();}
	if (in_array($user, $groupArryGroup)) {echo  'Вие сте приятели'; exit();}
	if ($group_arry_user != "") {$group_arry_user = "$group_arry_user,$group";} else {$group_arry_user = "$group";}
	if ($group_arry_group != "") {$group_arry_group = "$group_arry_group,$user";} else {$group_arry_group = "$user";}
        $UpdateArrayUser = mysql_query("UPDATE users SET group_array='$group_arry_user' WHERE `user_id`='$user'") or die (mysql_error());
        $UpdateArrayGroup = mysql_query("UPDATE groups SET users_array='$group_arry_group' WHERE `id`='$group'") or die (mysql_error());
	$deleteThisPendingRequest = mysql_query("DELETE FROM group_requests WHERE `id`='$reqID' LIMIT 1"); 
    echo "Успешно станахте член!";
    exit();
}
if ($_POST["request"] == "denyGroup") {
    $reqID = preg_replace('#[^0-9]#i', '', $_POST['reqID']);
    $deleteThisPendingRequest = mysql_query("DELETE FROM group_requests WHERE id='$reqID' LIMIT 1"); 
    echo "Поканата е отхвърлена";
    exit();
}
if ($_POST["request"] == "removeGroupship") {
	$user = preg_replace('#[^0-9]#i', '', $_POST['user']);
        $group = preg_replace('#[^0-9]#i', '', $_POST['group']);
	if (!$user || !$group || !$thisWipit) {
		echo  'Нещо липсва...';
    	exit(); 
	}
	$sql_group_arry_user = mysql_query("SELECT `group_array` FROM `users` WHERE `user_id`='$user' LIMIT 1"); 
	$sql_group_arry_group = mysql_query("SELECT `users_array` FROM `groups` WHERE `id`='$group' LIMIT 1"); 
	while($row=mysql_fetch_array($sql_group_arry_user)) { $group_arry_user = $row["group_array"]; }
	while($row=mysql_fetch_array($sql_group_arry_group)) { $group_arry_group = $row["users_array"]; }
	$groupArryUser = explode(",", $group_arry_user);
	$groupArryGroup = explode(",", $group_arry_group);
	foreach ($groupArryUser as $key => $value) {
			  if ($value == $group) {
			      unset($groupArryUser[$key]);
			  } 
        }
	foreach ($groupArryGroup as $key => $value) {
			  if ($value == $user) {
			      unset($groupArryGroup[$key]);
			  } 
        } 
    $newStringForUser = implode(",", $groupArryUser);
    $newStringForGroup =  implode(",", $groupArryGroup);
    $sql = mysql_query("UPDATE `users` SET `group_array`='$newStringForUser' WHERE `user_id`='$user'");
    $sql = mysql_query("UPDATE `groups` SET `users_array`='$newStringForGroup' WHERE `id`='$group'");
    echo 'Вече не сте член';
    exit(); 
}
?>