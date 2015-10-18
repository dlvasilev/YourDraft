<?php
include_once '../init.php';
$Chat = new Chat();
if(isset($_POST['message'])) {
    $msg      = $_POST['message'];
    $to_id    = $_POST['to_id'];
    $data     = $Chat->Send_msg($session_user_id, $to_id, $msg);
    if($data) {
        $msg_id         = $data['id'];
        $msg            = htmlentities($data['message']);
        $time           = $data['time'];
        $from_id        = $data['from_id'];
        $to_id          = $data['to_id'];
        $username       = $data['username'];
        $firstname      = $data['first_name'];
        $lastname       = $data['last_name'];
        $face           = $Chat->Profile($from_id);
        ?>
   <div class="stbody" id="stbody<?php echo $msg_id;?>">
        <div class="stimg">
            <img src="<?php echo $profile; ?>" class='big_face'/>
        </div> 
        <div class="sttext">
            <a href="<?php echo $username; ?>"><b><?php echo '' . $first_name . ' ' . $last_name . ''; ?></b></a><br /><?php echo $msg;?>
            <div class="sttime"><?php time_stamp($time);?></div> 
        </div> 
    </div>
<?php
}
}
?>