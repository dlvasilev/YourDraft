<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Търсене PHP - код//
require 'database/connect.php';
if(isset($_POST['search_term'])) {
   $search_term = mysql_real_escape_string(htmlentities($_POST['search_term']));
        if (!empty($search_term)) {
            $search = mysql_query("SELECT `username`, `discription`, `first_name`, `last_name`, `profile`, `works` FROM `users` WHERE `username` LIKE '%$search_term%'");
            $result_count = mysql_num_rows($search);
            $suffix = ($result_count != 1) ? 'и' : ' ';
            echo '<h1>Профили:</h1>';
            echo '<p>Вашата заявка: <b>', $search_term, '</b> връща <b>', $result_count, '</b> резултат', $suffix, '</p>';
            while ($results_row = mysql_fetch_assoc($search)) {
                echo '  <table><tr><td>&nbsp;<img src="',  $results_row['profile'], '" alt="Avatar" style="width: 60px; height: 60px;"/></td>
                        <td><p><strong><a href="', $results_row['username'], '">', $results_row['username'],'</a></strong><br />
                        Име: ', $results_row['first_name'] , ' ', $results_row['last_name'] , ' <br /> Кратко описание: ', $results_row['discription'],'<br />
                        Интереси / занимания: ', $results_row['works'] , '</p></td></tr></table>';
            }
            $search = mysql_query("SELECT `id`, `group_name`, `discription` FROM `groups` WHERE `group_name` LIKE '%$search_term%'");
            $result_count = mysql_num_rows($search);
            $suffix = ($result_count != 1) ? 'и' : ' ';
            echo '<h1>Групи:</h1>';
            echo '<p>Вашата заявка: <b>', $search_term, '</b> връща <b>', $result_count, '</b> резултат', $suffix, '</p>';
            while ($results_row = mysql_fetch_assoc($search)) {
                echo '<p><strong>
                    <a href="group/open_group.php?id=', $results_row['id'], '">', $results_row['group_name'],'</a></strong>
                    <br />Кратко описание: ', $results_row['discription'],'</p><hr>';
            }
            $search = mysql_query("SELECT `id`, `project_name`, `discription` FROM `projects` WHERE `project_name` LIKE '%$search_term%'");
            $result_count = mysql_num_rows($search);
            $suffix = ($result_count != 1) ? 'и' : ' ';
            echo '<h1>Проекти:</h1>';
            echo '<p>Вашата заявка: <b>', $search_term, '</b> връща <b>', $result_count, '</b> резултат', $suffix, '</p>';
            while ($results_row = mysql_fetch_assoc($search)) {
                echo '<p><strong>
                    <a href="project/open_project.php?id=', $results_row['id'], '">', $results_row['project_name'],'</a></strong>
                    <br />Кратко описание: ', $results_row['discription'],'</p><hr>';
            }
        }
}

if(isset($_POST['searchint_term'])) {
   $searchint_term = mysql_real_escape_string(htmlentities($_POST['searchint_term']));
        if (!empty($searchint_term)) {
            $search = mysql_query("SELECT `username`, `discription`, `first_name`, `last_name`, `profile`, `works` FROM `users` WHERE `works` LIKE '%$searchint_term%'");
            $result_count = mysql_num_rows($search);
            $suffix = ($result_count != 1) ? 'и' : ' ';
            echo '<h1>Профили:</h1>';
            echo '<p>Вашата заявка: <b>', $searchint_term, '</b> връща <b>', $result_count, '</b> резултат', $suffix, '</p>';
            while ($results_row = mysql_fetch_assoc($search)) {
                echo '  <table><tr>
                        <td>&nbsp;<img src="',  $results_row['profile'], '" alt="Avatar" style="width: 60px; height: 60px;"/></td>
                        <td><p><strong><a href="', $results_row['username'], '">', $results_row['username'],'</a></strong><br />
                        Име: ', $results_row['first_name'] , ' ', $results_row['last_name'] , ' <br /> Кратко описание: ', $results_row['discription'],'<br />
                        Интереси / занимания: ', $results_row['works'] , '</p>
                        </td></tr></table>';
            }
        }
}
?>
