<?php
//////////////////////////
//      YOURDRAFT       //
//   CREATED BY DANGAM  //
//     Project 2012     //
//////////////////////////
// Файл: Отворен Проект //
include '../core/init.php';
protect_page();
if (isset($_GET['id']) && $_GET['id'] != "") {
    $sid = preg_replace('#[^0-9]#i', '', $_GET['id']);
} else {
   echo "ERROR: URL :(((";
   exit();
}
$sql = mysql_query("SELECT * FROM projects WHERE id='$sid' LIMIT 1");
$numRows = mysql_num_rows($sql);
if ($numRows < 1) {
    echo "ERROR: Ne su6testvuva tozi proekt :(((";
    exit();
}
while($row = mysql_fetch_array($sql)) {
    $project_name = $row["project_name"];
    $project_discription = $row['discription'];
    $project_discription = nl2br(htmlspecialchars($project_discription));
    $project_img = $row['image'];
}
if (!isset($_SESSION['wipit'])) {
    session_register('wipit');
}
$thisRandNum = rand(9999999999999, 999999999999999999);
$_SESSION['wipit'] = base64_encode($thisRandNum);
include '../include/overall/header.php';
?>
<script type="text/javascript">
function addAsMember(a,b) {
            var url = "../core/project_requests.php";
            var thisRandNum = "<?php echo $thisRandNum; ?>";
            $("#projectHeadAMembBox").text("Моля изчакайте...").show();
            $.post(url,{ request: "requestProjectmember", user: a, project: b, thisWipit: thisRandNum}, function(data) {
              $("#projectHeadAMembBox").html(data).show().fadeOut(12000);  
            });
}
function acceptProject(x) {
            var url = "../core/project_requests.php";
            var thisRandNum = "<?php echo $thisRandNum; ?>";
            $.post(url,{ request: "acceptProject", reqID: x, thisWipit: thisRandNum}, function(data){
                $("#req"+x).html(data).show();
            })
}
function denyProject(x) {
            var url = "../core/project_requests.php";
            var thisRandNum = "<?php echo $thisRandNum; ?>";
            $.post(url,{ request: "denyProject", reqID: x, thisWipit: thisRandNum}, function(data){
                $("#req"+x).html(data).show();
            })
}
function removeProjectship(a,b) {
            var url = "../core/project_requests.php";
            var thisRandNum = "<?php echo $thisRandNum; ?>";
            $("#projectHeadRMembBox").text("Моля изчакайте...").show();
            $.post(url,{ request: "removeProjectship", user: a, project: b, thisWipit: thisRandNum}, function(data) {
              $("#projectHeadRMembBox").html(data).show().fadeOut(12000);  
            });
}
</script>
<div id="projectContent">
    <div id="projectHead">
        <div id="projectHeadCol1">
            <div id="projectHeadImage"><img src="../<?php echo $project_img; ?>"></div>
            <div id="projectHeadMenu">
                <div id="projectHeadMenuMembers"><img src="../images/friends.png" alt="Members"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont('projectHeadMembersBox');">Членове</a></div>
                <?php
                $sqlArray = mysql_query("SELECT `users_array` FROM `projects` WHERE `id`= $sid LIMIT 1");
                while($row =  mysql_fetch_array($sqlArray)) {$user_array = $row['users_array'];}
                $user_array = explode(",", $user_array);
                if (in_array($session_user_id, $user_array)) {
                        $userLink = '<div id="projectHeadMenuRMemb"><img src="../images/remove_fr.png" alt="Remove Memebership"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont(\'projectHeadRMembBox\');">Премахни членство</a></div>
                                     <div id="projectHeadMenuDirectory"><img src="../images/folder.png" alt="File Directory"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont(\'projectHeadDirectoryBox\');">Файлова Директория</a></div>';
                } else {
                        $userLink = '<div id="projectHeadMenuAMemb"><img src="../images/add_fr.png" alt="Add Memebership"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont(\'projectHeadAMembBox\');">Стани член</a></div>';
                }
                echo $userLink;
                $sql = mysql_query("SELECT admin_user FROM projects WHERE id = $sid LIMIT 1");
                $rowadmin = mysql_fetch_array($sql);
                $admin = $rowadmin['admin_user'];
                if ($_SESSION['username'] == $admin) { ?>
                <div id="projectHeadMenuInvitations"><img src="../images/cv.png" alt="Invitations"/><a href="#" onclick="return false" onmousedown="javascript: toggleCont('projectHeadInvitationsBox');">Покани</a></div>
                <?php } ?>
                <div class="Containers" id="projectHeadAMembBox">
                    <div id="projectHeadAMembHead"><p>Стани член</p></div>
                    <p>Наистина ли искаш да стсанеш участник в този проект?</p>
                    <a class="like" href="#" onclick="return false" onmousedown="javascript: addAsMember(<?php echo $_SESSION['user_id'];?> , <?php echo $sid; ?>)">Да!</a>
                    <a class="like" href="#" onclick="return false" onmousedown="javascript: toggletCont('projectHeadAMembBox');">Не</a>
                </div>
                <div class="Containers" id="projectHeadRMembBox">
                     <div id="projectHeadRMembHead"><p>Отказ от членство</p></div>
                     <p>Наистина ли искаш да изтриеш своето членство в този проект?</p>
                     <a class="like" href="#" onclick="return false" onmousedown="javascript: removeProjectship(<?php echo $_SESSION['user_id']; ?> , <?php echo $sid; ?>)">Да!</a>
                     <a class="like" href="#" onclick="return false" onmousedown="javascript: toggleCont('projectHeadRMembBox');">Не</a>
                </div>
                <div class="Containers" id="projectHeadMembersBox">
                    <div id="projectHeadMembersHead"><p>Членове</p></div>
                    <?php
                                 $data = mysql_query("SELECT * FROM projects WHERE `id`='$sid' LIMIT 1");
                                 $get = mysql_fetch_array($data);
                                 $project_array = $get["users_array"];
                                 $memberslist .= "";
                                 if ($project_array != "") {
                                     $membersArray = explode(",", $project_array);
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
        <div id="projectHeadCol2">
            <div id="projectHeadName"><?php echo $project_name; ?></div>
            <div id="projectHeadDiscription"><?php echo $project_discription; ?></div>
            <div id="interactionResults" style="font-size:15px; padding:10px;"></div>
            <div id="projectHeadInvitationsBox" class="Containers">
                <div id="projectHeadInvitationsHead"><p>Покани</p></div>
                        <?php 
                        $sql = "SELECT * FROM project_requests WHERE `project`='$sid' ORDER BY id ASC";
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
                                    <a href="#" class="like" onclick="return false" onmousedown="javascript: acceptProject(' . $requestID . ');" >Приеми</a>
                                    &nbsp; &nbsp; ИЛИ &nbsp; &nbsp;
                                    <a href="#" class="like" onclick="return false" onmousedown="javascript: denyProject(' . $requestID . ');" >Откажи</a>
                                    </span></td>
                                    </tr>
                                   </table>';
                    }	 
                    }
                ?>
            </div>
            <div id="projectHeadDirectoryBox" class="Containers">
                <div id="projectHeadDirectoryHead"><p>Файлове</p></div>
                <div id="projectDirectoryHead">
                    <div id="projectDirectoryHeadIcon">Икона</div>
                    <div id="projectDirectoryHeadName">Име</div>
                    <div id="projectDirectoryHeadSize">Големина</div>
                    <div id="projectDirectoryHeadTime">Дата на качване</div>
                </div>
                
                <?php
                $files = get_files($sid);
                if (empty($files)) {
                   echo '<p>Директорията на проекта е празна..</p>';
                } else {
                  foreach ($files as $file) { 
                      $time = $file['timestamp'];
                      ?>
                <div class="projectDirectoryItem">
                    <div id="projectDirectoryItemIcon">Икона</div>
                    <div id="projectDirectoryItemName"><a href="../project_directory/<?php echo $sid ?>/home/<?php echo $file['name'] ?>" target="_blank"><?php echo $file['name'] ?></a></div>
                    <div id="projectDirectoryItemSize"><?php echo $file['size'] ?> Bytes</div>
                    <div id="projectDirectoryItemTime"><?php time_stamp($time);?></div>
                </div>
                  <?php }
                }
                ?>
                <br /><br />
                <?php
                $output = "";
                if (isset($_FILES['file']) && $sid) {
                    $file_name = $_FILES['file']['name'];
                    $file_size = $_FILES['file']['size'];
                    $file_temp = $_FILES['file']['tmp_name'];
                    $file_ext = strtolower(end(explode('.', $file_name)));
                    $errors = array();
                    if (empty($file_name) || empty($sid)) {
                        $errors[] = 'Нещо липсва';
                    } else {
                        if ($file_size > 20000000) {
                            $errors[] = 'Най-много е позволен 20MB файл';
                        }
                    }
                     if (!empty($errors)) {
                         foreach ($errors as $error) {
                         echo $error, '<br />';
                        }
                    } else {
                        upload_file($file_temp, $file_name, $file_ext, $file_size, $sid);
                        $output = "Файла се качи успешно";
                    }
                }
                ?>
                <?php echo $output; ?>
                <div id="projectHeadUploadHead"><p>Качване на файл</p></div>
                <form action="" method="post" enctype="multipart/form-data">
                    <p>Изберете Файл: <input type="file" name="file"/><input type="submit" value="Качи" /></p>
                </form>
            </div>
            <div id="projectHeadPostsBox">
                <div id="projectHeadPostsHead"><p>Постове</p></div>
                <?php
                $sqlArray = mysql_query("SELECT `users_array` FROM `projects` WHERE `id`= $sid LIMIT 1");
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
                    $sql = mysql_query("INSERT INTO project_posts (author_id, project_id, post, date) VALUES ('$session_user_id', '$sid', '$post_field', now())") or die(mysql_error());
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
                $sql_posts = mysql_query("SELECT * FROM project_posts WHERE project_id = '$sid' ORDER BY date DESC LIMIT 10");
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
