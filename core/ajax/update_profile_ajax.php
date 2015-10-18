<?php
include("../init.php");
if($_POST['data_phone']){
    $data = $_POST['data_phone'];
    $data = mysql_escape_String($data);
    $sql = "UPDATE users SET phone = '$data' WHERE user_id ='$session_user_id'";
    mysql_query( $sql);
}
if($_POST['data_city']){
    $data = $_POST['data_live'];
    $data = mysql_escape_String($data);
    $sql = "UPDATE users SET city = '$data' WHERE user_id ='$session_user_id'";
    mysql_query( $sql);
}
if($_POST['data_email']){
    $data = $_POST['data_email'];
    $data = mysql_escape_String($data);
    $sql = "UPDATE users SET email = '$data' WHERE user_id ='$session_user_id'";
    mysql_query( $sql);
}
if($_POST['data_discription']){
    $data = $_POST['data_discription'];
    $data = mysql_escape_String($data);
    $sql = "UPDATE users SET discription = '$data' WHERE user_id ='$session_user_id'";
    mysql_query( $sql);
}
if($_POST['data_skype']){
    $data = $_POST['data_skype'];
    $data = mysql_escape_String($data);
    $sql = "UPDATE users SET skype = '$data' WHERE user_id ='$session_user_id'";
    mysql_query( $sql);
}
if($_POST['data_facebook']){
    $data = $_POST['data_facebook'];
    $data = mysql_escape_String($data);
    $sql = "UPDATE users SET facebook = '$data' WHERE user_id ='$session_user_id'";
    mysql_query( $sql);
}
if($_POST['data_website']){
    $data = $_POST['data_website'];
    $data = mysql_escape_String($data);
    $sql = "UPDATE users SET website = '$data' WHERE user_id ='$session_user_id'";
    mysql_query( $sql);
}
?>