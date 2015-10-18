<?php
include_once '../init.php';
if(isset($_POST['comment'])) {
    $comment    = $_POST['comment'];
    $image_id    = $_POST['image_id'];
    $cdata      = Insert_Image_Comment($session_user_id, $image_id, $comment);
    if($cdata) {
         $com_id    = $cdata['id'];
         $comment   = tolink(htmlentities($cdata['comment'] ));
         $username  = $cdata['username'];
         $uid       = $cdata['user_id'];
         $profile   = $cdata['profile'];
         $time      = $cdata['time'];
         ?>
                                <div class="imgcommentbody" id="imgcommentbody<?php echo $com_id; ?>">
                                    <div class="imgcommentimg">
                                        <img src="<?php echo $profile; ?>" class='small_face'/>
                                    </div> 
                                    <div class="imgcommenttext">
                                        <a class="imgcommentdelete" href="#" id='<?php echo $com_id; ?>' title='Изтрий'>X</a>
                                        <a href="<?php echo $username; ?>"><b><?php echo '' . $first_name . ' ' . $last_name . ''; ?></b></a> <?php echo $comment; ?>
                                        <div class="imgcommenttime"><?php time_stamp($time); ?></div>
                                    </div>
                                </div>
    <?php
    }
}
?>