<?php
function create_group($group_name, $group_description) {
    $group_name = sanitize($group_name);
    $group_description = sanitize($group_description);
    mysql_query("INSERT INTO `groups` VALUES ('', '$group_name', '$group_description', '".$_SESSION['user_id']."', '".$_SESSION['username']."', 'images/noneg.png')");
    $groupIdQuery = mysql_query("SELECT id FROM groups WHERE `group_name` = '$group_name'  AND `discription` = '$group_description' AND `admin_user` = '".$_SESSION['username']."' LIMIT 1");
    $groupIdRow = mysql_fetch_array($groupIdQuery);
    $groupID = $groupIdRow['id'];
    $groupArrayQuery = mysql_query("SELECT group_array FROM users WHERE `user_id`='".$_SESSION['user_id']."' LIMIT 1") or die(mysql_error());
    while($row=mysql_fetch_array($groupArrayQuery)) {$groupArryUser = $row["group_array"];}
    if ($groupArryUser != "") {$groupArryUser = "$groupArryUser,$groupID";} else {$groupArryUser = "$groupID";}
    mysql_query("UPDATE users SET group_array='$groupArryUser' WHERE `user_id`='".$_SESSION['user_id']."'") or die (mysql_error());
}
class Groups {
    public function getGroupsYouIn($userID) {   
        $userGroupsQuery = mysql_query("SELECT `group_array` FROM `users` WHERE user_id = $userID") or die(mysql_error());
        $row = mysql_fetch_array($userGroupsQuery);
        $groupArray = $row['group_array'];
        if ($groupArray == "") {
            return false;
        } else {
            $explodeGroupArray = explode(",", $groupArray);
            return $explodeGroupArray;
        }
    }
}
?>
