<?php
class Adverts { 
    public function GetAdverts() {
        $query = mysql_query("SELECT A.id, A.from_id, A.name, A.content, A.image, A.date, U.username, U.first_name, U.last_name, U.profile FROM advertise A, users U WHERE A.from_id = U.user_id ORDER BY rand() LIMIT 15");
        while($row=mysql_fetch_array($query))
	$data[]=$row;
	return $data;   
    }
    public function GetMyAdverts($user_id) {
        $user_id = (int)$user_id;
        $query = mysql_query("SELECT A.id, A.from_id, A.name, A.content, A.image, A.date, U.username, U.first_name, U.last_name, U.profile FROM advertise A, users U WHERE A.from_id = U.user_id AND U.user_id = $user_id");
        while($row=mysql_fetch_array($query))
	$data[]=$row;
	return $data;   
    }
    public function AdvertsCount($advert_id) {
        $advert_id    = (int)$advert_id;
        $query        = mysql_query("SELECT `likes_user_id` FROM `advertise` WHERE `id` = '$advert_id'");
        $row          = mysql_fetch_array($query);
        $array        = $row["likes_user_id"];
        if ($array != "") {
            $likesExplode = explode(",", $array);
            $likesCount   = count($likesExplode);
        }
        else $likesCount = 0;
        return $likesCount;
    }
}
function advert_exists($advert_id) {
    $advert_id = (int)$advert_id;
    return (mysql_result(mysql_query("SELECT COUNT(`id`) FROM `advertise` WHERE `id` = '$advert_id'"), 0) == 0) ? false : true;
}
function advert_previously_liked($advert_id) {
    $advert_id    = (int)$advert_id;
    $user_id      = $_SESSION['user_id'];
    $query        = mysql_query("SELECT `likes_user_id` FROM `advertise` WHERE `id` = '$advert_id'");
    $row          = mysql_fetch_array($query);
    $array        = $row["likes_user_id"];
    if (!in_array($user_id, $array) === true) {
        return false;
    }
    else return true;
}
function advert_like_count($advert_id) {
    $advert_id    = (int)$advert_id;
    $query        = mysql_query("SELECT `likes_user_id` FROM `advertise` WHERE `id` = '$advert_id'");
    $row          = mysql_fetch_array($query);
    $array        = $row["likes_user_id"];
    if ($array != "") {
        $likesExplode = explode(",", $array);
        $likesCount   = count($likesExplode);
    }
    else $likesCount = 0;
    return $likesCount;   
}
function advert_add_like($advert_id) {
    $advert_id = (int)$advert_id;
    $user_id = $_SESSION['user_id'];
    $query = mysql_query("SELECT likes_user_id FROM advertise WHERE id='$advert_id' LIMIT 1");
    $row = mysql_fetch_array($query);
    $array = $row['likes_user_id'];
    if ($array != '') {
        $newarray = ''.$array.', '.$user_id.'';
    }
    else $newarray = $user_id;
    mysql_query("UPDATE advertise SET likes_user_id = '$newarray' WHERE id='$advert_id'");
}
?>
