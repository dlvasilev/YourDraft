<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Всички проекти //
include '../core/init.php';
protect_page();
include '../include/overall/header.php';
?>
<div id="infoBox">
     <div id="infoBoxHead">Проекти</div>
     <div id="infoBoxBody">
            <p>Тук можеш да видиш всички проекти в които участваш.</p>
     </div>
</div>
<?php 
$projects         = new Projects();
$projectArray     = $projects->getProjectsYouIn($session_user_id);
include 'load_project.php'; 
?>
<br /><div class="button"><a href="new_project.php">Нов Проект</a></div>
<?php
include '../include/overall/footer.php'; 
?> 