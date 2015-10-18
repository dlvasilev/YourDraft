<?php
//////////////////////////
//      YOURDRAFT       //
//   CREATED BY DANGAM  //
//     Project 2012     //
//////////////////////////
// Файл: Отворена Група //
include '../core/init.php';
protect_page();
if (isset($_GET['id']) && $_GET['id'] != "") {
    $sid = preg_replace('#[^0-9]#i', '', $_GET['id']);
} else {
   echo "ERROR: URL :(((";
   exit();
}
$sql = mysql_query("SELECT * FROM groups WHERE id='$sid' LIMIT 1");
$numRows = mysql_num_rows($sql);
if ($numRows < 1) {
    echo "ERROR: Ne su6testvuva tazi grupa :(((";
    exit();
}
while($row = mysql_fetch_array($sql)) {
    $group_name = $row["group_name"];
    $group_discription = $row['discription'];
    $group_img = $row['image'];
}
include '../include/overall/header.php';
if (!isset($_SESSION['wipit'])) {
    session_register('wipit');
}
$thisRandNum = rand(9999999999999, 999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
?>
<script type="text/javascript">
function addAsGroupship(a,b) {
            var url = "../core/group_requests.php";
            var thisRandNum = "<?php echo $thisRandNum; ?>";
            $("#groupHeadAMembBox").text("Моля изчакайте...").show();
            $.post(url,{ request: "requestGroupmember", user: a, group: b, thisWipit: thisRandNum}, function(data) {
              $("#groupHeadAMembBox").html(data).show().fadeOut(12000);  
            });
}
function acceptGroup(x) {
            var url = "../core/group_requests.php";
            var thisRandNum = "<?php echo $thisRandNum; ?>";
            $.post(url,{ request: "acceptGroup", reqID: x, thisWipit: thisRandNum}, function(data){
                $("#req"+x).html(data).show();
            })
}
function denyGroup(x) {
            var url = "../core/group_requests.php";
            var thisRandNum = "<?php echo $thisRandNum; ?>";
            $.post(url,{ request: "denyGroup", reqID: x, thisWipit: thisRandNum}, function(data){
                $("#req"+x).html(data).show();
            })
}
function removeGroupship(a,b) {
            var url = "../core/group_requests.php";
            var thisRandNum = "<?php echo $thisRandNum; ?>";
            $("#groupHeadMenuRMemb").text("Моля изчакайте...").show();
            $.post(url,{ request: "removeGroupship", user: a, group: b, thisWipit: thisRandNum}, function(data) {
              $("#groupHeadMenuRMemb").html(data).show().fadeOut(12000);  
            });
}
</script>
<div id="groupContent">
    <div id="groupHead">
        <div id="groupHeadCol1">
            <div id="groupHeadImage"><img src="../<?php echo $group_img; ?>"></div>
            <div id="projectHeadMenu">
                <div id="groupHeadMenuMembers"><img src="../images/friends.png" alt="Members"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont('groupHeadMembersBox');">Членове</a></div>
                <?php 
                $sqlArray = mysql_query("SELECT `users_array` FROM `groups` WHERE `id`= $sid LIMIT 1");
                while($row =  mysql_fetch_array($sqlArray)) {$user_array = $row['users_array'];}
                $user_array = explode(",", $user_array);
                if (in_array($session_user_id, $user_array)) {
                        $userLink = '<div id="groupHeadMenuRMemb"><img src="../images/remove_fr.png" alt="Remove Memebership"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont(\'groupHeadRMembBox\');">Премахни членство</a></div>';
                } else {
                        $userLink = '<div id="groupHeadMenuAMemb"><img src="../images/add_fr.png" alt="Add Memebership"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont(\'groupHeadAMembBox\');">Стани член</a></div>';
                }
                echo $userLink;
                $sql = mysql_query("SELECT admin_user FROM groups WHERE id = $sid LIMIT 1");
                $rowadmin = mysql_fetch_array($sql);
                $admin = $rowadmin['admin_user'];
                if ($_SESSION['username'] == $admin) {
                ?>
                <div id="groupHeadMenuInvitations"><img src="../images/cv.png" alt="Invitations"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont('groupHeadInvitationsBox');">Покани</a></div>
                <?php
                }
                ?>
                <div class="Containers" id="groupHeadAMembBox">
                            <div id="groupHeadAMembHead"><p>Стани член</p></div>
                            <p>Наистина ли искаш да станеш член в тази група?</p>
                            <a href="#" class="like" onclick="return false" onmousedown="javascript: addAsGroupship(<?php echo $_SESSION['user_id'];?> , <?php echo $sid; ?>)">Да!</a>
                            <a href="#" class="like" onclick="return false" onmousedown="javascript: toggleCont('groupHeadAMembBox');">Не</a>
                </div>
                <div class="Containers" id="groupHeadRMembBox">
                            <div id="groupHeadRMembHead"><p>Отказ от членство</p></div>
                            <p>Наистина ли искаш да изтриеш своето членство в тази група?</p>
                            <a href="#" class="like" onclick="return false" onmousedown="javascript: removeGroupship(<?php echo $_SESSION['user_id']; ?> , <?php echo $sid; ?>)">Да!</a>
                            <a href="#" class="like" onclick="return false" onmousedown="javascript: toggleCont('groupHeadRMembBox');">Не</a>
                            </p>
                </div>
                <div class="Containers" id="groupHeadMembersBox">
                    <div id="groupHeadMembersHead"><p>Членове</p></div>
                    <?php
                                 $data = mysql_query("SELECT * FROM groups WHERE `id`='$sid' LIMIT 1");
                                 $get = mysql_fetch_array($data);
                                 $group_array = $get["users_array"];
                                 $memberslist .= "";
                                 if ($group_array != "") {
                                     $membersArray = explode(",", $group_array);
                                     $membersCount = count($membersArray);
                                     $membersArray = array_slice($membersArray, 0, 99999999);
                                     $i = 0;
                                     $memberslist .= '<div id="profilefrdisplay">';
                                     foreach($membersArray as $key => $value) {
                                       $i++;
                                       $sqlName = mysql_query("SELECT `username`, `first_name`, `last_name`, `profile` FROM `users` WHERE `user_id` ='$value' LIMIT 1") or die (mysql_error());
                                       while ($row = mysql_fetch_array($sqlName)) {$friendFirstName = $row["first_name"]; $friendLastName = $row["last_name"]; $frpic= $row['profile']; $frlink = $row['username'];}
                                       $memberslist .= '<div class="friendDisplay" title="' . $friendFirstName . ' ' . $friendLastName . '"><a href="../'. $frlink . '"><img src="../'. $frpic . '" width="50px" border="0"/></a><p>' . $friendFirstName . ' ' . $friendLastName . '</p></div>';
                                   }
                                   $memberslist .= '</div>';
                                 }
                                  echo $memberslist;
                    ?> 
                 </div>
            </div>
        </div>
        <div id="groupHeadCol2">
            <div id="groupHeadName"><?php echo $group_name; ?></div>
            <div id="groupHeadDiscription"><?php echo $group_discription; ?></div>
            <div id="interactionResults" style="font-size:15px; padding:10px;"></div>
            <div class="Containers" id="groupHeadInvitationsBox">
                        <div id="groupHeadInvitationsHead"><p>Покани</p></div>
                        <?php 
                        $sql = "SELECT * FROM group_requests WHERE `group`='$sid' ORDER BY id ASC";
                        $query = mysql_query($sql) or die (mysql_error());
                        $num_rows = mysql_num_rows($query); 
                        if ($num_rows < 1) {
                            echo '<p><b>Няма покани за членство</b></p>';
                        } else {
                        while ($row = mysql_fetch_array($query)) { 
                            $requestID = $row["id"];
                            $user = $row["user"];
                            $sqlName = mysql_query("SELECT `username`, `first_name`, `last_name`, `profile` FROM `users` WHERE `user_id` ='$user' LIMIT 1") or die (mysql_error());
                                while ($row = mysql_fetch_array($sqlName)) { $requesterFirstName = $row["first_name"]; $requesterLastName = $row["last_name"]; $userlink = $row["username"]; $userpic = $row["profile"]; }
                                echo'<table width="100%" cellpadding="5">
                                    <tr><td width="17%" align="left"><div style="overflow:hidden; height:50px;"><a href="../'. $userlink. '"><img src="../' . $userpic . '" width="50px" border="0"/></a></div></td>
                                    <td width="83%"><a href="../'. $userlink. '">' . $requesterFirstName .' '. $requesterLastName. '</a> иска да бъде член!<br /><br />
                                    <span id="req' . $requestID . '">
                                    <a href="#" onclick="return false" onmousedown="javascript: acceptGroup(' . $requestID . ');" >Приеми</a>
                                    &nbsp; &nbsp; ИЛИ &nbsp; &nbsp;
                                    <a href="#" onclick="return false" onmousedown="javascript: denyGroup(' . $requestID . ');" >Откажи</a>
                                    </span></td>
                                    </tr>
                                   </table>';
                    }	 
                    }
                ?>
            </div>
            <div id="groupHeadPostsBox">
                <div id="groupHeadPostsHead"><p>Постове</p></div>
                <?php
                $sqlArray = mysql_query("SELECT `users_array` FROM `groups` WHERE `id`= $sid LIMIT 1");
                while($row =  mysql_fetch_array($sqlArray)) {$user_array = $row['users_array'];}
                $user_array = explode(",", $user_array);
                if (in_array($session_user_id, $user_array)) {
                $msg = "";
                if (isset($_POST['post_field'])) {
                    $post_field = $_POST['post_field'];
                    $post_field = stripslashes($post_field);
                    $post_field = strip_tags($post_field);
                    $post_field = mysql_real_escape_string($post_field);
                    $post_field = eregi_replace("`", "&#39;", $post_field);
                    $sql = mysql_query("INSERT INTO group_posts (author_id, group_id, post, date) VALUES ('$session_user_id', '$sid', '$post_field', now())") or die(mysql_errno());
                    $msg = "Успешно Пост-нахте!";
                }
                $post_form = '';
                if (isset($_SESSION['user_id'])) {
                    if ($_SESSION['user_id'] == $session_user_id) {
                    $post_form = 
                    '
                    '. $msg . '
                    <form action="#" method="post" enctype="multipart/form-data" name="post_form">
                    <textarea name="post_field" rows="1" style="width: 530px;"></textarea>
                    <input type="submit" name="submit" value="Пост" />
                    </form>
                    ';
                    }
                }
                echo $post_form;
                }
                ?>
                <div style="width: 100%; overflow: auto; overflow-x: hidden;">
                <?php
                $sql_posts = mysql_query("SELECT * FROM group_posts WHERE group_id = '$sid' ORDER BY date DESC LIMIT 10");
                while($row = mysql_fetch_array($sql_posts)) {
                    $plocid        = $row['id'];
                    $uid           = $row['author_id'];
                    $the_ploc      = $row['post'];
                    $ploc_date     = $row['date'];
                    $ploc_date     = strftime("%b %d, %y", strtotime($ploc_date));
                    $sql_user_data = mysql_query("SELECT user_id, username, first_name, last_name, profile FROM users WHERE user_id='$uid' LIMIT 1");
                    while($row = mysql_fetch_array($sql_user_data)){
                        $uid        = $row['user_id'];
                        $uusername  = $row['username'];
                        $ufirstname = $row['first_name'];
                        $ulastname  = $row['last_name'];
                        $ufirstname = substr($ufirstname, 0, 10);
                        $upic       = $row['profile'];
                        $plocDisplayList .= '
                        <table width="99%" align="center" cellpadding="4">
                        <tr>
                        <td width="7%"><a href="../' . $uusername . '"><img src="../' . $upic . '" width="50px"/></a></td>
                        <td width="93%" style="border-bottom: #1a4280 1px solid;"><a href="../' . $uusername . '"><strong>' . $ufirstname . ' ' . $ulastname . '</strong></a> &bull; ' . $ploc_date . '<br />' . stripslashes(wordwrap(nl2br($the_ploc), 99999999999999999, "\n", true)) . '</td>
                        </tr>
                        </table>
                        ';
                    }
                }
                echo $plocDisplayList;
                ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include '../include/overall/footer.php'; 
?>
