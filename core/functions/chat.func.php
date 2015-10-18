<?php
class Chat {
    public function Messages($from_id, $to_id){
	$query = mysql_query("SELECT C.id, C.from_id, C.to_id, C.message, C.time, U.user_id, U.username, U.user_id, U.first_name, U.last_name FROM chat C, users U WHERE ((C.from_id = U.user_id AND C.to_id = '$to_id' AND C.from_id = '$from_id') OR (C.from_id = U.user_id AND C.to_id = '$from_id' AND C.from_id= '$to_id')) ORDER BY C.id ASC") or die(mysql_error());
        while($row=mysql_fetch_array($query))
	$data[]=$row;
	return $data;		
    }
    public function Profile($user_id){
        $result = mysql_query("SELECT profile FROM users WHERE user_id = $user_id");
        $user_data = mysql_fetch_array($result);
        $profile = $user_data['profile'];
        return $profile;
    }
    public function Delete_msg($from_id, $ploc_id) {
        $query = mysql_query("DELETE FROM `chat` WHERE id = '$msg_id' AND from_id = '$from_id'") or die(mysql_error());
        return true;  	       
    }
    public function Send_msg($from_id, $to_id, $msg) {
	$msg    = htmlentities($msg);
	$time   = time();
        $query  = mysql_query("SELECT id, message FROM `chat` WHERE from_id = '$to_id' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if ($update != $result['message']) {
            $query = mysql_query("INSERT INTO `chat` (message, from_id, to_id, time) VALUES ('$msg', '$from_id', '$to_id','$time')") or die(mysql_error());
            $newquery = mysql_query("SELECT C.id, C.from_id, C.to_id, C.message, C.time, U.username, U.user_id, U.first_name, U.last_name FROM chat C, users U WHERE C.from_id=U.user_id AND C.to_id='$to_id' ORDER BY C.id DESC LIMIT 1");
            $result = mysql_fetch_array($newquery);
            return $result;
        } else {
            return false;
	}    
    }
}
?>