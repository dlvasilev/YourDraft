<?php
include_once '../init.php';
$Wall = new Ploc();
if(isset($_POST['id'])){
    $com_id     = $_POST['id'];
    $data       = $Wall->Delete_Comment($session_user_id, $com_id);
    echo $data;
}
?>
