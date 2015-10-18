<?php
foreach($msgsarray as $data) {
    $msg_id         = $data['id'];
    $msg            = htmlentities($data['message']);
    $time           = $data['time'];
    $username       = $data['username'];
    $to_id          = $data['to_id'];
    $from_id        = $data['from_id'];
    $first_name     = $data['first_name'];
    $last_name      = $data['last_name'];
    $profile        = $Chat->Profile($from_id);
?>
   <div class="stbody" id="stbody<?php echo $ploc_id;?>">
        <div class="stimg">
            <img src="../<?php echo $profile; ?>" class='big_face'/>
        </div> 
        <div class="sttext">
            <a href="../<?php echo $username; ?>"><b><?php echo '' . $first_name . ' ' . $last_name . ''; ?></b></a><br /><?php echo $msg;?>
            <div class="sttime"><?php time_stamp($time);?></div> 
        </div> 
    </div>
<?php
}
?>
