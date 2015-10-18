<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Чат //
include '../core/init.php';
protect_page();
include '../include/overall/header.php';
$Chat = new Chat();
if (isset($_GET['id']) && $_GET['id'] != "") {
    $user_id = preg_replace('#[^0-9]#i', '', $_GET['id']);
} else {
   echo "ERROR: U CANT USE SQL INJECTION HERE :P";
   exit();
}
$query   = mysql_query("SELECT `username`, `first_name`, `last_name`, `profile`, `discription` FROM `users` WHERE `user_id` = '$user_id' LIMIT 1");
$row     = mysql_fetch_assoc($query);
$username = $row['username'];
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$profile = $row['profile'];
$discription = $row['discription'];
$msgsarray = $Chat->Messages($session_user_id, $user_id);
?>
<script type="text/javascript">
    function refresh_messages(){
      $('#chat').load(location.href + ' #chat');
    }
    setInterval("refresh_messages();",500);
</script>
<div id="chatBox">
    <div class="ploc_content" id="ploc_content">
        <div class="stbody">
            <div class="stimg">
                <img src="../<?php echo $profile; ?>" class='big_face'/>
            </div> 
            <div class="sttext">
                <a href="../<?php echo $username; ?>"><b><?php echo '' . $first_name . ' ' . $last_name . ''; ?></b></a><br /><?php echo $discription;?>
                <div class="sttime">Username: <?php echo $username; ?></div> 
            </div> 
        </div>
    </div>
    <div id="chat">
        <?php include 'load_chatmsg.php'; ?>
    </div>
    <div class="ploc"><br />
            <form method="post" action="" name="post_form">
            <textarea name="post_field" id="post_field"></textarea><br />
                <div id="button_block">
                    <input type="hidden" value="<?php echo $user_id; ?>" name="to_id" id="to_id" />
                    <input type="submit" value=" Изпрати "  id="update_button"  class="send_button"/>
                    <input type="submit" value=" Отказ " name="cancel" id="cancel" />
                    <div id='flashmessage'>
                        <div id="flash"></div>
                    </div>
                </div>
            </form>
    </div>
</div>
<?php 
include '../include/overall/footer.php'; ?> 
