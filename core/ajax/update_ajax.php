<?php
    include_once '../init.php';
    $user_id = $_SESSION['user_id'];
    $query = mysql_query("SELECT id FROM updates WHERE to_id = $user_id AND seen = '0'");
    while($row = mysql_fetch_array($query))
    $data[] = $row;
    foreach ($data as $value) {
        $id = $value['id'];
        mysql_query("UPDATE updates SET seen='1' WHERE id = '$id'");
    }
?>
