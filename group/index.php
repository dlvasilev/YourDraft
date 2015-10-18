<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Всички групи //
include '../core/init.php';
protect_page();
include '../include/overall/header.php';
?>
<div id="infoBox">
     <div id="infoBoxHead">Групи</div>
     <div id="infoBoxBody">
            <p>Тук можеш да видиш всички групи в сайта и всички в които участваш.</p>
     </div>
</div>
<?php 
        $groups         = new Groups();
        $groupArray     = $groups->getGroupsYouIn($session_user_id);
        include 'load_group.php';
?>
<?php
    echo $displayList;
?>
<br /><div class="button"><a href="new_group.php">Нова Група</a></div>
<?php include '../include/overall/footer.php'; ?> 