<?php
class Admin {
    public function getUsers() {
        $query = mysql_query("SELECT * FROM users");
        while($row = mysql_fetch_array($query))
        $data[]=$row;
        return $data;
    }
    public function userUpdate($update_data, $user_id){
        $user_id = (int)$user_id;
        $update = array();
        array_walk($update_data, 'array_sanitize');
        foreach ($update_data as $field=>$data) {
            $update[] = '`' . $field . '` = \'' . $data . '\'';
        }
        mysql_query("UPDATE `users` SET " . implode(', ', $update) . " WHERE `user_id` = $user_id");
    }
}
?>
