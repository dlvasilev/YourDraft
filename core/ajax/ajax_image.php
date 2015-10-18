<?php
include('../database/connect.php');
session_start();
$session_user_id = $_SESSION['user_id'];
$t_width = 100;
$t_height = 100;
$time = time();
$new_name = "small_".$session_user_id."_".$time.".jpg";
$path = "../../images/profile/";
if(isset($_GET['t']) and $_GET['t'] == "ajax") {
    extract($_GET);
    $ratio = ($t_width/$w);
    $nw = ceil($w * $ratio);
    $nh = ceil($h * $ratio);
    $nimg = imagecreatetruecolor($nw,$nh);
    $im_src = imagecreatefromjpeg($path.$img);
    imagecopyresampled($nimg,$im_src,0,0,$x1,$y1,$nw,$nh,$w,$h);
    imagejpeg($nimg,$path.$new_name,90);
    mysql_query("UPDATE users SET profile='images/profile/$new_name' WHERE user_id='$session_user_id'");
    echo $new_name;
    exit;
}
?>