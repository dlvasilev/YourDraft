<?php
class Ploc {
    public function FrPlocs($user_id){
        $user_id = (int)$user_id;
        $user_fr_array_query = mysql_query("SELECT `friend_array` FROM `users` WHERE `user_id` = $user_id");
        $user_fr_array_row = mysql_fetch_array($user_fr_array_query);
        $user_fr_array = $user_fr_array_row['friend_array'];
        $new_fr_array = "$user_fr_array, $user_id";
        $fr_array = explode(",", $new_fr_array);
        $query = mysql_query("SELECT P.id, P.author_id, P.user_id, P.from_id, P.the_ploc, P.image, P.ploc_date, p.type, p.ploc_likes, U.username, U.first_name, U.last_name FROM plocing P, users U WHERE P.author_id = U.user_id ORDER BY P.id DESC") or die(mysql_error());
        while($row=mysql_fetch_array($query))
        foreach($fr_array as $key => $value) {
            $row_user_id = $row['user_id'];
            $row_author_id = $row['author_id'];
            if ($value == $row_user_id) {
                $data[]=$row;
            }
        }
        return $data;
    }
    public function Profile_Plocs($user_id){
	$query = mysql_query("SELECT P.id, P.author_id, P.user_id, P.from_id, P.the_ploc, P.image, P.ploc_date, p.type, p.ploc_likes, U.username, U.user_id, U.first_name, U.last_name FROM plocing P, users U WHERE P.author_id = U.user_id AND P.user_id = '$user_id' ORDER BY P.id DESC") or die(mysql_error());
        while($row=mysql_fetch_array($query))
	$data[]=$row;
	$empty = [];
        if(!empty($data)){
            return $data;
        }
        else return $empty;		
    }
    public function Comments($ploc_id){
	$query = mysql_query("SELECT C.`id`, C.`author`, C.`comment`, U.`username`, U.`user_id`, U.`first_name`, U.`last_name`, C.`created` FROM `ploc_comments` C, `users` U WHERE C.`author` = U.`user_id` AND C.`ploc_id` = '$ploc_id' ORDER BY C.id ASC ") or die(mysql_error());
	while($row=mysql_fetch_array($query))
	$data[]=$row;
        $empty = [];
        if(!empty($data)){
            return $data;
        }
        else return $empty;
    }
    public function Profile($user_id){
        $result = mysql_query("SELECT profile FROM users WHERE user_id = $user_id");
        $user_data = mysql_fetch_array($result);
        $profile = $user_data['profile'];
        return $profile;
    }
    public function Delete_Ploc($user_id, $ploc_id) {
	$query = mysql_query("DELETE FROM `ploc_comments` WHERE ploc_id = '$ploc_id' ") or die(mysql_error());
        $query = mysql_query("DELETE FROM `plocing` WHERE id = '$ploc_id' AND author_id = '$user_id'") or die(mysql_error());
        return true;  	       
    }
    public function Delete_Comment($uid, $com_id) {
	$query = mysql_query("DELETE FROM `ploc_comments` WHERE author = '$uid' and id='$com_id'") or die(mysql_error());
        return true;	       
    }
    public function Insert_Comment($uid, $ploc_id, $comment) {
	$comment = htmlentities($comment);
	$time = time();
        $query = mysql_query("SELECT id, comment FROM `ploc_comments` WHERE author = '$uid' AND ploc_id = '$ploc_id' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $result = mysql_fetch_array($query);
        $getPlocAuthorId = mysql_query("SELECT author_id FROM plocing WHERE id = $ploc_id")or die(mysql_error());
        $row = mysql_fetch_array($getPlocAuthorId);
        $authorId = $row['author_id'];
        if ($comment != $result['comment']) {
            $query = mysql_query("INSERT INTO `ploc_comments` (comment, author, ploc_id, created) VALUES ('$comment', '$uid','$ploc_id', '$time')") or die(mysql_error());
            addUpdate(2, $_SESSION['user_id'], $authorId, $ploc_id);
            $newquery = mysql_query("SELECT C.id, C.author, C.comment, C.ploc_id, C.created, U.username, U.user_id FROM comments C, users U where C.author = U.user_id AND C.author = '$uid' AND C.ploc_id = '$ploc_id' ORDER BY C.id DESC LIMIT 1");
            $result = mysql_fetch_array($newquery);
            return $result;
        } else {
            return false;
	}  
    }
    public function Insert_Ploc($uid, $ploc) {
	$ploc   = sanitize($ploc);
	$time   = time();
        $query  = mysql_query("SELECT id, the_ploc FROM `plocing` WHERE author_id = '$uid' ORDER BY id DESC LIMIT 1") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if ($update != $result['the_ploc']) {
            $query = mysql_query("INSERT INTO `plocing` (the_ploc, author_id, user_id, type, ploc_date) VALUES ('$ploc', '$uid', '$uid', '1','$time')") or die(mysql_error());
            $newquery = mysql_query("SELECT P.id, P.author_id, P.user_id, P.the_ploc, P.type, P.ploc_date, U.username, U.user_id, U.first_name, U.last_name FROM plocing P, users U WHERE P.author_id=U.user_id AND P.user_id='$uid' ORDER BY P.id DESC LIMIT 1");
            $result = mysql_fetch_array($newquery);
            return $result;
        } else {
            return false;
	}    
    }
}
?>
