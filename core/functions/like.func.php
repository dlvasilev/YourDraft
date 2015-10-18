<?php
// Posts
function ploc_exists($ploc_id) {
    $ploc_id = (int)$ploc_id;
    return (mysql_result(mysql_query("SELECT COUNT(`id`) FROM `plocing` WHERE `id` = '$ploc_id'"), 0) == 0) ? false : true;
}
function previously_liked($ploc_id) {
    $ploc_id = (int)$ploc_id;
    return (mysql_result(mysql_query("SELECT COUNT(`like_id`) FROM `ploc_likes` WHERE `user_id` = " . $_SESSION['user_id'] . " AND `ploc_id` = '$ploc_id'"), 0) == 0) ? false : true;
}
function like_count($ploc_id) {
    $ploc_id = (int)$ploc_id;
    return (int)mysql_result(mysql_query("SELECT `ploc_likes` FROM `plocing` WHERE `id` = '$ploc_id'"), 0, 'ploc_likes');   
}
function add_like($ploc_id) {
    $ploc_id = (int)$ploc_id;
    mysql_query("UPDATE `plocing` SET `ploc_likes` = `ploc_likes` + 1 WHERE `id` = '$ploc_id'");
    mysql_query("INSERT INTO `ploc_likes` (`user_id`, `ploc_id`) VALUES (".$_SESSION['user_id'].", $ploc_id)");
    $getPlocAuthorId = mysql_query("SELECT author_id FROM plocing WHERE id = $ploc_id")or die(mysql_error());
    $row = mysql_fetch_array($getPlocAuthorId);
    $authorId = $row['author_id'];
    if($_SESSION['user_id'] != $authorId){
        addUpdate('1', $_SESSION['user_id'], $authorId, $ploc_id);
    }
}
?>
