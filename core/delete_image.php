<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Изтриване на картинка //
include 'init.php';

if (!logged_in()) {
   header('Location: ../index.php');
   exit();
}

if (image_check($_GET['image_id']) === false) {
   header('Location: ../user/drafts.php');
   exit();
}

if (isset($_GET['image_id']) || empty($_GET['image_id'])) {
   delete_image($_GET['image_id']);
   header('Location: '.$_SERVER['HTTP_REFERER']);
   exit();
}

?>