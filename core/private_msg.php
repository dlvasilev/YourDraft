<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Лични съобщения - код //
session_start();
$thisWipit = $_POST['thisWipit'];
$sessWipit = base64_decode($_SESSION['wipit']);
if (!isset($_SESSION['wipit']) || !isset($_SESSION['user_id'])) {
	echo  '<strong>Сесията ви е изтекла. Моля презаредете страницата</strong>';
    exit();
}
else if ($_SESSION['user_id'] != $_POST['senderID']) {
	echo  '<strong>ГРЕШКА!</strong>';
    exit();
}
else if ($sessWipit != $thisWipit) {
	echo  '<strong>Forged submission</strong>';
    exit();
}
else if ($thisWipit == "" || $sessWipit == "") {
	echo  '<strong>Нещо липсва</strong>';
    exit();
}
require_once "database/connect.php";
$checkuserid = $_POST['senderID'];
$prevent_dp = mysql_query("SELECT id FROM private_messages WHERE from_id='$checkuserid' AND time_sent between subtime(now(),'0:0:20') and now()");
$nr = mysql_num_rows($prevent_dp);
if ($nr > 0){
	echo 'Трябва да изчакаш малко.';
	exit();
}
$sql = mysql_query("SELECT id FROM private_messages WHERE from_id='$checkuserid' AND DATE(time_sent) = DATE(NOW()) LIMIT 40");
$numRows = mysql_num_rows($sql);
// for removing
if ($numRows > 30) {
	echo 'Можеш да пращаш само 30 съобщения на ден.';
    exit();
}
// yep
if (isset($_POST['message'])) { 
  $to   = ($_POST['rcpntID']); 
  $from = ($_POST['senderID']);
  $toName   = ($_POST['rcpntName']); 
  $fromName = ($_POST['senderName']); 
  $sub = htmlspecialchars($_POST['subject']);
  $msg = htmlspecialchars($_POST['message']);
  $sub  = mysql_real_escape_string($sub);
  $msg  = mysql_real_escape_string($msg);
  if ( empty($from) || empty($toName) || empty($fromName) || empty($sub) || empty($msg)) { 
    echo 'Не мога да продължа. Нещо липсва';
    exit();
  } else { 
        $sqldeleteTail = mysql_query("SELECT * FROM private_messages WHERE to_id='$to' ORDER BY time_sent DESC LIMIT 0,100"); 
        $dci = 1;
        while($row = mysql_fetch_array($sqldeleteTail)){ 
                $pm_id = $row["id"];
		if ($dci > 99) {
			$deleteTail = mysql_query("DELETE FROM private_messages WHERE id='$pm_id'"); 
		}
		$dci++; 
        }
   $sql = "INSERT INTO private_messages (to_id, from_id, time_sent, subject, message) VALUES ('$to', '$from', now(), '$sub', '$msg')"; 
    if (!mysql_query($sql)) { 
	    echo 'Имаме проблем със връзката.';
	    exit();
    } else { 
	echo '<strong>Съобщението е изпратено успешно!</strong>';
	exit();
    }
  }
}
?>
