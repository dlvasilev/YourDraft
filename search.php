<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Търсене - Страница//
include 'core/init.php';
include 'include/overall/homeheader.php';
?>
<div id="Search">
    <div id="SearchHead">Търсене на Хора / Групи / Проекти</div>
    <div id="SearchBody">
        <form action=""><input id="search" type="text" size="113"/></form>
        <div id="search_results"></div>
        <script type="text/javascript" src="js/search.js"></script>
    </div>
</div>
<div id="Search">
    <div id="SearchHead">Търсене по занимания</div>
    <div id="SearchBody">
        <form action=""><input id="searchint" type="text" size="113"/></form>
        <div id="searchint_results"></div>
        <script type="text/javascript" src="js/search.js"></script>
    </div>
</div>
<?php include 'include/overall/homefooter.php'; ?>