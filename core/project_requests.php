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
if($_POST["request"] == "requestProjectmember") {
    $user = preg_replace('#[^0-9]#i', '', $_POST['user']);
    $project = preg_replace('#[^0-9]#i', '', $_POST['project']);
    if(!$user || !$project || !$thisWipit) {
        echo 'Error: Нещо липсва';
        exit();
    }
    $sql = mysql_query("SELECT `id` FROM `project_requests` WHERE `user`='$user' AND `project`='$project' LIMIT 1");
    $numRows = mysql_num_rows($sql);
    if ($numRows > 0) {
        echo 'Вече сте изпратили покана за членство. Моля изчакайте тя да бъде подтвърдена';
        exit(); 
    }
    $sql = mysql_query("INSERT INTO project_requests (`user`, `project`, `timedate`) VALUES ('$user','$project', now())") or die(mysql_error());
echo 'Поканата за членство е изпратена успешно. Моля изчакайте нейното одобрение.';
exit();
}
if ($_POST["request"] == "acceptProject") {
    $reqID = preg_replace('#[^0-9]#i', '', $_POST['reqID']);
	$sql = "SELECT * FROM project_requests WHERE `id`='$reqID' LIMIT 1";
	$query = mysql_query($sql) or die ("Имаме грешка във системата...");
	$num_rows = mysql_num_rows($query); 
	if ($num_rows < 1) {
		echo 'Излезе някаква грешка..';
		exit();
	}
    while ($row = mysql_fetch_array($query)) { 
	$user = $row["user"];
	$project = $row["project"];
    }
	$sql_project_arry_user = mysql_query("SELECT project_array FROM users WHERE `user_id`='$user' LIMIT 1") or die(mysql_error()); 
	$sql_project_arry_project = mysql_query("SELECT users_array FROM projects WHERE `id`='$project' LIMIT 1") or die(mysql_error()); 
	while($row=mysql_fetch_array($sql_project_arry_user)) {$project_arry_user = $row["project_array"];}
	while($row=mysql_fetch_array($sql_project_arry_project)) {$project_arry_project = $row["users_array"];}
	$projectArryUser = explode(",", $project_arry_user);
	$projectArryproject = explode(",", $project_arry_project);
        if (in_array($project, $projectArryUser)) {echo  'Вие сте член'; exit();}
	if (in_array($user, $projectArryproject)) {echo  'Вие сте член'; exit();}
	if ($project_arry_user != "") {$project_arry_user = "$project_arry_user,$project";} else {$project_arry_user = "$project";}
	if ($project_arry_project != "") {$project_arry_project = "$project_arry_project,$user";} else {$project_arry_project = "$user";}
        $UpdateArrayUser = mysql_query("UPDATE users SET project_array='$project_arry_user' WHERE `user_id`='$user'") or die (mysql_error());
        $UpdateArrayProject = mysql_query("UPDATE projects SET users_array='$project_arry_project' WHERE `id`='$project'") or die (mysql_error());
	$deleteThisPendingRequest = mysql_query("DELETE FROM project_requests WHERE `id`='$reqID' LIMIT 1"); 
    echo "Успешно станахте член!";
    exit();
}
if ($_POST["request"] == "denyProject") {
    $reqID = preg_replace('#[^0-9]#i', '', $_POST['reqID']);
    $deleteThisPendingRequest = mysql_query("DELETE FROM project_requests WHERE id='$reqID' LIMIT 1"); 
    echo "Поканата е отхвърлена";
    exit();
}
if ($_POST["request"] == "removeProjectship") {
	$user = preg_replace('#[^0-9]#i', '', $_POST['user']);
        $project = preg_replace('#[^0-9]#i', '', $_POST['project']);
	if (!$user || !$project || !$thisWipit) {
		echo  'Нещо липсва...';
    	exit(); 
	}
	$sql_project_arry_user = mysql_query("SELECT `project_array` FROM `users` WHERE `user_id`='$user' LIMIT 1"); 
	$sql_project_arry_project = mysql_query("SELECT `users_array` FROM `projects` WHERE `id`='$project' LIMIT 1"); 
	while($row=mysql_fetch_array($sql_project_arry_user)) { $project_arry_user = $row["project_array"]; }
	while($row=mysql_fetch_array($sql_project_arry_project)) { $project_arry_project = $row["users_array"]; }
	$projectArryUser = explode(",", $project_arry_user);
	$projectArryProject = explode(",", $project_arry_project);
	foreach ($projectArryUser as $key => $value) {
			  if ($value == $project) {
			      unset($projectArryUser[$key]);
			  } 
        }
	foreach ($projectArryProject as $key => $value) {
			  if ($value == $user) {
			      unset($projectArryProject[$key]);
			  } 
        } 
    $newStringForUser = implode(",", $projectArryUser);
    $newStringForProject =  implode(",", $projectArryProject);
    $sql = mysql_query("UPDATE `users` SET `project_array`='$newStringForUser' WHERE `user_id`='$user'");
    $sql = mysql_query("UPDATE `projects` SET `users_array`='$newStringForProject' WHERE `id`='$project'");
    echo 'Вече не сте член';
    exit(); 
}
?>