<?php
session_start();
include "init.php";
if (isset($_POST['text'])) {
  $to   = ($_POST['toid']); 
  $from = ($_POST['senderid']);
  $fid = ($_POST['fid']);
  $imageid = ($_POST['imageid']);
  $text = htmlspecialchars($_POST['text']);
  $text  = mysql_real_escape_string($text);
  $time = time();
  if (empty($to) || empty($from) || empty($fid) || empty($imageid)) { 
    echo 'Не мога да продължа. Нещо липсва';
    exit();
  } else {
        $imgAuthorId = mysql_query("SELECT user_id FROM images WHERE image_id = $imageid")or die(mysql_error());
        $row = mysql_fetch_array($imgAuthorId);
        $authorId = $row['user_id'];
        addUpdate('5', $_SESSION['user_id'], $authorId, $imageid);
        mysql_query("INSERT INTO plocing (author_id, user_id, from_id, the_ploc, image, ploc_date, type) VALUES ('$from', '$to', '$fid', '$text', $imageid, '$time', 2)");  
	echo '<strong>Вие споделихте успешно!</strong>';
	exit();
    }
}
?>
