<?php
function create_project($project_name, $project_description) {
    $project_name = sanitize($project_name);
    $project_description = sanitize($project_description);
    mysql_query("INSERT INTO `projects` VALUES ('', '$project_name', '$project_description', '".$_SESSION['user_id']."', '".$_SESSION['username']."', 'images/nonep.png')");
    $projectIdQuery = mysql_query("SELECT id FROM projects WHERE `project_name` = '$project_name'  AND `discription` = '$project_description' AND `admin_user` = '".$_SESSION['username']."' LIMIT 1");
    $projectIdRow = mysql_fetch_array($projectIdQuery);
    $projectID = $projectIdRow['id'];
    $projectArrayQuery = mysql_query("SELECT project_array FROM users WHERE `user_id`='".$_SESSION['user_id']."' LIMIT 1") or die(mysql_error());
    while($row=mysql_fetch_array($projectArrayQuery)) {$projectArryUser = $row["project_array"];}
    if ($projectArryUser != "") {$projectArryUser = "$projectArryUser,$projectID";} else {$projectArryUser = "$projectID";}
    mysql_query("UPDATE users SET project_array='$projectArryUser' WHERE `user_id`='".$_SESSION['user_id']."'") or die (mysql_error());
}
function create_project_dir($project_id) {
    mkdir('../project_directory/'.$project_id.'/home/');
}
function upload_file($file_temp, $file_name, $file_ext, $file_size, $project_id) {
    $project_id = (int)$project_id;
    mysql_query("INSERT INTO `project_files` VALUES ('', '$project_id', '$file_name', '$file_size', '$file_ext', '1', UNIX_TIMESTAMP())");
    mkdir('../project_directory/'.$project_id.'');
    mkdir('../project_directory/'.$project_id.'/home');
    move_uploaded_file($file_temp, '../project_directory/'.$project_id.'/home/'.$file_name);
}
function get_files($project_id) {
  $project_id = (int)$project_id;
  $files = array() ;
  $file_query = mysql_query("SELECT `id`, `project_id`, `name`, `size`, `ext`, `type`, `timestamp` FROM `project_files` WHERE `project_id`= '$project_id'");
  while ($files_row = mysql_fetch_assoc($file_query)) {
      $files[] = array (
          'id'          => $files_row['id'],
          'project_id'  => $files_row['project_id'],
          'name'        => $files_row['name'],
          'size'        => $files_row['size'],
          'ext'         => $files_row['ext'],
          'type'        => $files_row['type'],
          'timestamp'   => $files_row['timestamp']
     );
  }
  return $files;
}
class Projects {
    public function getProjectsYouIn($userID) {   
        $userGroupsQuery = mysql_query("SELECT `project_array` FROM `users` WHERE user_id = $userID") or die(mysql_error());
        $row = mysql_fetch_array($userGroupsQuery);
        $groupArray = $row['project_array'];
        if ($groupArray == "") {
            return false;
        } else {
            $explodeGroupArray = explode(",", $groupArray);
            return $explodeGroupArray;
        }
    }
}
?>