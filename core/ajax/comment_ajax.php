<?php
include_once '../init.php';
$Wall = new Ploc();
if(isset($_POST['comment'])) {
    $comment    = $_POST['comment'];
    $ploc_id    = $_POST['ploc_id'];
    $cdata      = $Wall->Insert_Comment($session_user_id, $ploc_id, $comment);
    if($cdata) {
         $com_id    = $cdata['id'];
         $comment   = tolink(htmlentities($cdata['comment'] ));
         $time      = $cdata['created'];
         $username  = $cdata['username'];
         $uid       = $cdata['author'];
         $cface     = $Wall->Profile($uid);
         ?>
        <div class="stcommentbody" id="stcommentbody<?php echo $com_id; ?>">
            <div class="stcommentimg">
                <img src="<?php echo $cface; ?>" class='small_face'/>
            </div> 
            <div class="stcommenttext">
                <a class="stcommentdelete" href="#" id='<?php echo $com_id; ?>'>X</a>
                <b><?php echo $username; ?></b> <?php echo $comment; ?>
                <div class="stcommenttime"><?php time_stamp($time); ?></div> 
            </div>
        </div>
    <?php
    }
}
?>
