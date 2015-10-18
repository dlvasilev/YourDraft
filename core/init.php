<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Главния файл, зарежда всички други нужни файлове в целия сайт//
session_start();
//error_reporting(0);
require 'database/connect.php';
require 'functions/general.func.php';
include 'functions/updates.func.php';
require 'functions/users.func.php';
include 'functions/draft.func.php';
include 'functions/image.func.php';
include 'functions/thumb.func.php';
include 'functions/group.func.php';
include 'functions/project.func.php';
include 'functions/like.func.php';
include 'functions/wall.func.php';
include 'functions/chat.func.php';
include 'functions/advert.func.php';
include 'functions/time_stamp.php';
include 'functions/tolink.php';
$url = "http://localhost:2705/yourdraftv4/";
if (logged_in() === true) {
    $session_user_id = $_SESSION['user_id'];
    $user_data = user_data($session_user_id, 'user_id', 'username', 'password', 'first_name', 'last_name', 'email', 'city', 'country', 'website', 'interests', 'hobbies', 'works', 'type', 'profile', 'friend_array', 'group_array', 'project_array', 'phone', 'skype', 'facebook', 'discription', 'portfolio');
    $_SESSION['username'] = $user_data['username'];
    $_SESSION['useremail'] = $user_data['email'];
    $_SESSION['userpass'] = $user_data['password'];
    if (user_active($user_data['username']) === false) {
        session_destroy();
        header('Location: index.php');
        exti();
    }
}
$errors = array();
/*
if (!isset($_SESSION['wipit'])) {
            $_SESSION['wipit'];
}
*/
$thisRandNum = rand(9999999999999, 9999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
?>
