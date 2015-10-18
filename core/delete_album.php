<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Изтриване на вече съществъващ драфт //
include 'init.php';

if (!logged_in()) {
   header('Location: ../index.php');
   exit();
}

if (draft_check($_GET['draft_id']) == false) {
   header('Location: ../index.php');
   exit();
}

if (isset($_GET['draft_id'])) {
   $draft_id = $_GET['draft_id'];
   delete_draft($draft_id);
   header('Location: ../index.php');
   exit();
}

?>