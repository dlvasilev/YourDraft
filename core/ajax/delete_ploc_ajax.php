<?php
error_reporting(0);
include_once '../init.php';
$Wall = new Ploc();
if(isset($_POST['ploc_id'])){
    $ploc_id    = $_POST['ploc_id'];
    $data       = $Wall->Delete_Ploc($session_user_id, $ploc_id);
    echo $data;
}
?>
