<?php
include_once '../init.php';
$Wall = new Ploc();
if(isset($_POST['the_ploc'])) {
    $ploc     = $_POST['the_ploc'];
    $data     = $Wall->Insert_Ploc($session_user_id, $ploc);
    if($data) {
        $ploc_id        = $data['id'];
        $the_ploc       = tolink(htmlentities($data['the_ploc']));
        $time           = $data['ploc_date'];
        $uid            = $data['author_id'];
        $username       = $data['username'];
        $firstname      = $data['first_name'];
        $lastname       = $data['last_name'];
        $face           = $Wall->Profile($uid);
        $commentsarray  = $Wall->Comments($ploc_id);
        ?>
        <div class="stbody" id="stbody<?php echo $ploc_id;?>">
            <div class="stimg">
                <img src="<?php echo $face;?>" class='big_face'/>
            </div> 
            <div class="sttext">
                <a class="stdelete" href="#" id="<?php echo $ploc_id;?>" title='Изтрий'>X</a>
                <a href="<?php echo $username; ?>"><b><?php echo '' . $firstname . ' ' . $lastname . ''; ?></b></a><br /><?php echo $the_ploc;?>
            <div class="sttime"><a href="#" onclick="like_add('<?php echo $ploc_id; ?>');" class="like">Харесвам</a> | <a href='#' class='commentopen' id='<?php echo $ploc_id;?>' title='Коментари'>Напиши коментар </a> | <?php time_stamp($time);?></div> 
            <div id="stexpandbox">
                <div id="stexpand"></div>
            </div>
            <div class="commentcontainer" id="commentload<?php echo $ploc_id;?>">
            <?php include 'load_ploc_comments.php'; ?>
            </div>
                <div class="commentupdate" style='display:none' id='commentbox<?php echo $ploc_id;?>'>
                    <div class="stcommentimg">
                        <img src="<?php echo $face;?>" class='small_face'/>
                    </div> 
                    <div class="stcommenttext" >
                        <form method="post" action="">
                            <textarea name="comment" class="comment" maxlength="200"  id="ctextarea<?php echo $ploc_id;?>"></textarea><br />
                            <input type="submit"  value=" Коментар "  id="<?php echo $ploc_id;?>" class="comment_button"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}
?>
