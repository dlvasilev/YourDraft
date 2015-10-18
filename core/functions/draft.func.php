<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Драфт Функциите //
function draft_data($draft_id) {
  $draft_id = (int)$draft_id;

  $args = func_get_args();
  unset($args[0]);
  $fields = '`'.implode('`, `', $args).'`';

  $query = mysql_query("SELECT $fields FROM `drafts` WHERE `draft_id`=$draft_id");
  $query_result = mysql_fetch_assoc($query);
  foreach ($args as $field) {
    $args[$field] = $query_result[$field];
  }
  return $args;
}

function draft_check($draft_id) {
  $draft_id = (int)$draft_id;
  $query = mysql_query("SELECT COUNT(`draft_id`) FROM `drafts` WHERE `draft_id`=$draft_id");
  return (mysql_result($query, 0) == 1) ? true : false;
}

function get_drafts() {
  $drafts = array();
  
  $drafts_query = mysql_query("
  SELECT `drafts`.`draft_id`, `drafts`.`timestamp`, `drafts`.`name`, LEFT(`drafts`.`description`, 50) as `description`, COUNT(`images`.`image_id`) as `image_count`
  FROM `drafts`
  LEFT JOIN `images`
  ON `drafts`.`draft_id` = `images`.`draft_id`
  WHERE `drafts`.`user_id` = ".$_SESSION['user_id']."
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

function create_draft($draft_name, $draft_description) {
  $draft_name = sanitize($draft_name);
  $draft_description = sanitize($draft_description);
  $time = time();
  mysql_query("INSERT INTO plocing (author_id, user_id, the_ploc, ploc_date) VALUES ('".$_SESSION['user_id']."', '".$_SESSION['user_id']."', 'Създаде нов Албум: <strong>".$draft_name."</strong>', $time)");
  mysql_query("INSERT INTO `drafts` VALUES ('', '".$_SESSION['user_id']."', UNIX_TIMESTAMP(), '$draft_name', '$draft_description')");
  mkdir('../uploads/'.mysql_insert_id(), 0744);
  mkdir('../uploads/thumbs/'.mysql_insert_id(), 0744);
}

function edit_draft($draft_id, $draft_name, $draft_description) {
  $draft_id = (int)$draft_id;
  $draft_name = sanitize($draft_name);
  $draft_description = sanitize($draft_description);
  
  mysql_query("UPDATE `drafts` SET `name`='$draft_name', `description`='$draft_description' WHERE `draft_id`=$draft_id AND `user_id`=".$_SESSION['user_id']);
}

function delete_draft($draft_id){
        $draft_id = (int)$draft_id;
        mysql_query("DELETE FROM `images` WHERE `draft_id`='$draft_id' AND `user_id`='".$_SESSION['user_id']."'");
        mysql_query("DELETE FROM `drafts` WHERE `draft_id`='$draft_id' AND `user_id`='".$_SESSION['user_id']."'");
        foreach(glob('uploads/'.$draft_id.'/*') as $file){
                if(is_file($file)){
                        unlink($file);
                }
        }
        foreach(glob('uploads/thumbs/'.$draft_id.'/*') as $file){
                if(is_file($file)){
                        unlink($file);
                }
        }
        rmdir('uploads/'.$draft_id.'/');
        rmdir('uploads/thumbs/'.$draft_id.'/');
}
?>