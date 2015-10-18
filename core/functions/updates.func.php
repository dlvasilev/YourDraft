<?php
class Updates {
    public function getUpdates($user_id) {
        $user_id = (int)$user_id;
        $query = mysql_query("SELECT A.id, A.from_id, A.to_id, A.type, A.seen, A.datetime, A.link, U.user_id, U.username, U.first_name, U.last_name, U.profile FROM updates A, users U WHERE A.to_id= $user_id AND A.from_id = U.user_id ORDER BY id DESC") or die(mysql_error());
        while($row=mysql_fetch_array($query))
	$data[]=$row;
	return $data;
    }
    public function gotUpdates($user_id) {
        $user_id = (int)$user_id;
        $query = mysql_query("SELECT seen FROM updates WHERE to_id = $user_id AND seen = '0'");
        $numRows = mysql_num_rows($query);
        return $numRows;
    }
}
function addUpdate($type, $from_id, $to_id, $link) {
    $time = time();
    mysql_query("INSERT INTO updates (from_id, to_id, type, link, seen, datetime) VALUES ($from_id, $to_id, $type, $link, '0', $time)") or die(mysql_error());
}
?>
