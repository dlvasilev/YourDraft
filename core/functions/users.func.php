<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Функции на Акаунтите//
function change_profile_image($user_id, $file_temp, $file_extn) {
    $file_path = 'images/profile/' . substr(md5(time()), 0, 10) . '.' . $file_extn;
    move_uploaded_file($file_temp, $file_path);
    mysql_query("UPDATE `users` SET `profile` = '" . mysql_real_escape_string($file_path) . "' WHERE `user_id` = " . (int)$user_id);
}
function has_access($user_id, $type) {
    $user_id = (int)$user_id;
    $type    = (int)$type;
    return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = $user_id AND `type` = $type"), 0) == 1) ? true : false;
}
function update_user($update_data){
    global $session_user_id;
    $update = array();
    array_walk($update_data, 'array_sanitize');
    foreach ($update_data as $field=>$data) {
        $update[] = '`' . $field . '` = \'' . $data . '\'';
    }
    mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $session_user_id");
}
function change_password($user_id, $password) {
    $user_id = (int)$user_id;
    $password = md5($password);
    
    mysql_query("UPDATE `users` SET `password` = '$password' WHERE `user_id` = $user_id");
    }
function register_user($register_data){
    array_walk($register_data, 'array_sanitize');
    $register_data['password'] = md5($register_data['password']);
    $fields = '`' . implode('`, `', array_keys($register_data)) . '`';
    $data = '\'' . implode('\', \'', $register_data) . '\'';

    mysql_query("INSERT INTO `users` ($fields) VALUES ($data)");
}
function user_count() {
    return mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `active` = 1"), 0);
}

function user_data($user_id) {
    $data = array();
    $user_id = (int)$user_id;
    
    $func_num_args = func_num_args();
    $func_get_args = func_get_args();
    
    if ($func_num_args > 1) {
        unset($func_get_args[0]);
        $fields ='`' . implode('`, `', $func_get_args) . '`';
        $data = mysql_fetch_assoc(mysql_query("SELECT $fields FROM `users` WHERE `user_id` = $user_id "));
        return $data;
    }     
}
function logged_in() {
    return (isset($_SESSION['user_id'])) ? true : false;
}
function user_exists($username) {
    $username = sanitize($username);
    $query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username'");
    return (mysql_result($query, 0) == 1) ? true : false;
}
function email_exists($email) {
    $email = sanitize($email);
    $query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email'");
    return (mysql_result($query, 0) == 1) ? true : false;
}
function user_active($username) {
    $username = sanitize($username);
    $query = mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `active` = 1");
    return (mysql_result($query, 0) == 1) ? true : false;
}
function user_id_from_username($username) {
    $username - sanitize($username);
    return mysql_result(mysql_query("SELECT `user_id` FROM `users` WHERE `username` = '$username'"), 0, 'user_id');
}
function login($username, $password) {
    $user_id = user_id_from_username($username);
    $username = sanitize($username);
    $password = md5($password);
    return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `username` = '$username' AND `password` = '$password'"), 0) == 1) ? $user_id : false;
}
function delete_user($email){
        $user_data = user_data('email');
        $email = $user_data['email'];
        
        mysql_query("DELETE FROM `users` WHERE `user_id`='".$_SESSION['user_id']."'");
        mysql_query("DELETE FROM `images` WHERE `user_id`='".$_SESSION['user_id']."'");
        mysql_query("DELETE FROM `drafts` WHERE `user_id`='".$_SESSION['user_id']."'");
        $user_albums = mysql_query("SELECT * FROM `albums` WHERE `user_id`='".$_SESSION['user_id']."'");
        foreach(glob('uploads/'.$user_albums.'/*') as $file){
                if(is_file($file)){
                        unlink($file);
                }
        }
        foreach(glob('uploads/thumbs/'.$user_albums.'/*') as $file){
                if(is_file($file)){
                        unlink($file);
                }
        }
        rmdir('uploads/'.$user_albums.'/');
        rmdir('uploads/thumbs/'.$user_albums.'/');
}

function getDraftsProfileFromProfile($username) {
      $user_id      = user_id_from_username($username);
      $drafts = array();
      $drafts_query = mysql_query("
      SELECT `drafts`.`draft_id`, `drafts`.`timestamp`, `drafts`.`name`, LEFT(`drafts`.`description`, 50) as `description`, COUNT(`images`.`image_id`) as `image_count`
      FROM `drafts`
      LEFT JOIN `images`
      ON `drafts`.`draft_id` = `images`.`draft_id`
      WHERE `drafts`.`user_id` = $user_id
      GROUP BY `drafts`.`draft_id`
      ");
      while ($drafts_row = mysql_fetch_assoc($drafts_query)) {
        $drafts[] = array(
                  'id' => $drafts_row['draft_id'],
                  'timestamp' => $drafts_row['timestamp'],
                  'name' => $drafts_row['name'],
                  'description' => $drafts_row['description'],
                  'count' => $drafts_row['image_count']
        );
      }
      return $drafts;
}
/*
function get_profile_images() {
  $profile_images = array();
  $images_query = mysql_query("SELECT * FROM `images` WHERE `user_id` = ".$_SESSION['user_id']." ORDER BY `image_id`");
  while ($images_row = mysql_fetch_assoc($images_query)) {
    $images[] = array(
              'image_id' => $images_row['image_id'],
              'user_id' => $images_row['user_id'],
              'draft_id' => $images_row['draft_id'],
              'ext' => $images_row['ext']
    );
  }
  return $images;
}
*/
function getDraftsProfile($user_id) {
      $user_id = (int)$user_id;
      $drafts = array();
      $drafts_query = mysql_query("
      SELECT `drafts`.`draft_id`, `drafts`.`timestamp`, `drafts`.`name`, LEFT(`drafts`.`description`, 50) as `description`, COUNT(`images`.`image_id`) as `image_count`
      FROM `drafts`
      LEFT JOIN `images`
      ON `drafts`.`draft_id` = `images`.`draft_id`
      WHERE `drafts`.`user_id` = $user_id
      GROUP BY `drafts`.`draft_id`
      ");
      while ($drafts_row = mysql_fetch_assoc($drafts_query)) {
        $drafts[] = array(
                  'id' => $drafts_row['draft_id'],
                  'timestamp' => $drafts_row['timestamp'],
                  'name' => $drafts_row['name'],
                  'description' => $drafts_row['description'],
                  'count' => $drafts_row['image_count']
        );
      }
      return $drafts;
}
function getProfileImages($user_id) {
  $user_id = (int)$user_id;
  $images_query = mysql_query("SELECT * FROM `images` WHERE `user_id` = ".$user_id." ORDER BY `image_id`");
  while ($images_row = mysql_fetch_assoc($images_query)) {
    $images[] = array(
              'image_id' => $images_row['image_id'],
              'user_id' => $images_row['user_id'],
              'draft_id' => $images_row['draft_id'],
              'ext' => $images_row['ext']
    );
  }
  $empty = [];
  if(!empty($images)){
       return $images;
  }
  else return $empty;
}
function getProfilePhotos($user_id) {
  $user_id = (int)$user_id;
  $images_query = mysql_query("SELECT * FROM `images` WHERE `user_id` = ".$user_id." ORDER BY `image_id` LIMIT 4");
  while ($images_row = mysql_fetch_assoc($images_query)) {
    $images[] = array(
              'image_id' => $images_row['image_id'],
              'user_id' => $images_row['user_id'],
              'draft_id' => $images_row['draft_id'],
              'ext' => $images_row['ext']
    );
  }
  $empty = [];
  if(!empty($images)){
       return $images;
  }
  else return $empty;
}
?>
