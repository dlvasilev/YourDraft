<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
session_start();
include_once "init.php";
if (!isset($_SESSION['user_id']) || !isset($_SESSION['username']) || !isset($_SESSION['useremail']) || !isset($_SESSION['userpass'])) {
	echo "Трябва да влезете";
	exit();
}
if (!isset($_POST['post_type']) || !isset($_POST['post_body']) || !isset($_POST['uid']) || !isset($_POST['upass'])) {
	echo "ERROR: Ne e vuvedena dostatu4no informaciq";
	exit();
}
$post_type = $_POST['post_type'];
$post_title = $_POST['post_title'];
$post_title = sanitize($post_title);
$post_body = $_POST['post_body'];
$post_body = sanitize($post_body);
$member_id = preg_replace('#[^0-9]#i', '', $_POST['uid']);
$member_password = mysql_real_escape_string($_POST['upass']);
$post_author = preg_replace('#[^A-Za-z0-9]#i', '', $_SESSION['username']);
if ($_SESSION['user_id'] != $member_id|| !isset($_SESSION['username']) || !isset($_SESSION['useremail']) || !isset($_SESSION['userpass'])) {
	echo "ERROR: inforamciqta koqto ni davata e e oburkana";
	exit();
}
$u_id = $member_id;
$u_name = mysql_real_escape_string($_SESSION['username']);
$u_email = mysql_real_escape_string($_SESSION['useremail']);
$u_pass = mysql_real_escape_string($_SESSION['userpass']);
$sql = mysql_query("SELECT * FROM users WHERE user_id='$u_id' AND username='$u_name' AND email='$u_email' AND password='$u_pass'");
$numRows = mysql_num_rows($sql);
if ($numRows < 1) {
	    echo "ERROR: Nqma vi v sistemata";
	    exit();
}
if ($post_type == "a") {
	if (strlen($post_title) < 10) { echo "Zaglavieto vi e tvurde malko"; exit(); }
        $time = time();
	$sql = mysql_query("INSERT INTO qastage (post_author, post_author_id, date_time, type, question_title, post_body) 
     VALUES('$post_author','$member_id','$time','a','$post_title','$post_body')") or die (mysql_error());
	$this_id = mysql_insert_id();
	header("location: ../qastage/view_question.php?id=$this_id"); 
    exit();
}
if ($post_type == "b") {
	$this_id = preg_replace('#[^0-9]#i', '', $_POST['tid']);
	if ($this_id == "") { echo "Nomera na temata go nqma"; exit(); }
        $time = time();
	$sql = mysql_query("INSERT INTO qastage (post_author, post_author_id, otid, date_time, type, post_body) VALUES('$post_author','$member_id','$this_id','$time','b','$post_body')") or die (mysql_error());
	$post_body = stripslashes($post_body);
	echo $post_body;
}
?>