<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Функции на картинките//
function upload_image($image_temp, $image_ext, $draft_id) {
    $draft_id = (int)$draft_id;
    $time = time();
    $draft = mysql_query("SELECT name FROM drafts WHERE draft_id = $draft_id LIMIT 1");
    $draftrow = mysql_fetch_array($draft);
    $draftname = $draftrow['name'];
    mysql_query("INSERT INTO `plocing` (author_id, user_id, the_ploc, ploc_date, type) VALUES ('".$_SESSION['user_id']."', '".$_SESSION['user_id']."', 'Добави нови файлове във албум: $draftname', $time, '1')");
    mysql_query("INSERT INTO `images` VALUES ('', '".$_SESSION['user_id']."', '$draft_id', UNIX_TIMESTAMP(), '$image_ext')");
    $image_id = mysql_insert_id();
    $image_file = $image_id.'.'.$image_ext;
    move_uploaded_file($image_temp, '../uploads/'.$draft_id.'/'.$image_file);  
    create_thumb('../uploads/'.$draft_id.'/', $image_file, '../uploads/thumbs/'.$draft_id.'/');
}
function get_images($draft_id) {
  $draft_id = (int)$draft_id;
  $images = array() ;
  $image_query = mysql_query("SELECT `image_id`, `user_id`, `draft_id`, `timestamp`, `ext` FROM `images` WHERE `draft_id`=$draft_id");
  while ($images_row = mysql_fetch_assoc($image_query)) {
      $images[] = array (
          'image_id'    => $images_row['image_id'],
          'user_id'     => $images_row['user_id'],
          'draft_id'    => $images_row['draft_id'],
          'timestamp'   => $images_row['timestamp'],
          'ext'         => $images_row['ext']
     );
  }
  return $images;
}

function image_check($image_id) {
  $image_id = (int)$image_id;
  $query = mysql_query("SELECT COUNT(`image_id`) FROM `images` WHERE `image_id`=$image_id AND `user_id`=".$_SESSION['user_id']);
  return (mysql_result($query, 0) == 0) ? false : true;
}

function delete_image($image_id) {
  $image_id = (int)$image_id;

  $image_query = mysql_query("SELECT `draft_id`, `ext` FROM `images` WHERE `image_id`=$image_id AND `user_id`=".$_SESSION['user_id']);
  $image_result = mysql_fetch_assoc($image_query);
  
  $draft_id = $image_result['draft_id'];
  $image_ext = $image_result['ext'];
  
  unlink('../uploads/'.$draft_id.'/'.$image_id.'.'.$image_ext);
  unlink('../uploads/thumbs/'.$draft_id.'/'.$image_id.'.'.$image_ext);

  mysql_query("DELETE FROM `images` WHERE `image_id`=$image_id AND `user_id`=".$_SESSION['user_id']);
}
function get_image_comments($image_id) {
    $image_id = (int)$image_id;
    $query = mysql_query("SELECT C.id, C.image_id, C.comment, C.time, U.username, U.user_id, U.first_name, U.last_name, U.profile FROM image_comments C, users U WHERE C.user_id = U.user_id AND C.image_id = '$image_id' ORDER BY C.id ASC ") or die(mysql_error());
	while($row=mysql_fetch_array($query))
	$data[]=$row;
        $empty = [];
        if(!empty($data)){
            return $data;
        }
        else return $empty;
}
function Insert_Image_Comment($uid, $image_id, $comment) {
	$comment = htmlentities($comment);
	$time = time();
        $query = mysql_query("SELECT id, comment FROM `image_comments` WHERE user_id = '$uid' AND image_id = '$image_id' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $result = mysql_fetch_array($query);
        $authorQuery = mysql_query("SELECT user_id FROM images WHERE image_id = $image_id")or die(mysql_error());
        $row = mysql_fetch_array($authorQuery);
        $authorId = $row['user_id'];
        if ($comment != $result['comment']) {
            $query = mysql_query("INSERT INTO `image_comments` (comment, user_id, image_id, time) VALUES ('$comment', '$uid','$image_id', '$time')") or die(mysql_error());
            addUpdate('4', $_SESSION['user_id'], $authorId, $image_id);
            $newquery = mysql_query("SELECT C.id, C.user_id, C.comment, C.image_id, C.time, U.username, U.user_id FROM image_comments C, users U where C.user_id = U.user_id AND C.user_id = '$uid' AND C.image_id = '$imgae_id' ORDER BY C.id DESC LIMIT 1");
            $result = mysql_fetch_array($newquery);
            return $result;
        } else {
            return false;
	}  
    }
?>