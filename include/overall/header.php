<!doctype html>
<html>
    <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <title><?php if(logged_in()) { echo $user_data['first_name'], ' ', $user_data['last_name'], ' - YourDraft';} else {?>YourDraft<?php } ?></title>
    <meta name="keywords" content="YourBest" />
    <meta name="description" content="Мястото къде Ти можеш да станеш велик!" />
    <meta name="author" content="DANGAM" />
    <link href="<?php echo $url; ?>images/favicon.ico" rel="shortcut icon" />
    <link href="<?php echo $url; ?>css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>css/wallstyle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>css/profile.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>css/projects.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>css/groups.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>css/adverts.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>css/helpcol.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $url; ?>css/colorbox.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo $url; ?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/jquery.colorbox.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/jquery.watermark.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/jquery.oembed.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/jquery.masonry.min.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/dropmenus.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/wall.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/chat.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/adverts.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/profile.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/search.js"></script>
    <script type="text/javascript" src="<?php echo $url; ?>js/script.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            document.body.style.backgroundImage = 'url(<?php echo $url; ?>images/bg/Original/Background_1.jpg)';
        });
    </script>
</head>
<body class="bg">
    <?php if(logged_in()) { ?>
<div id="header">
             <div id="panel">
                <div id="panel_logo">
                    <a href="<?php echo $url; ?>home"><img src="<?php echo $url; ?>images/logo_big.png" alt="yourDraft"></a>
                </div>
                <div id="panel_links">
                    <div id="panel_link_adverts">
                        <img src="<?php echo $url; ?>images/panel_adverts.png" alt=""/>
                        <a href="<?php echo $url; ?>adverts/">Обяви</a>
                    </div>
                    <div id="panel_link_questions">
                        <img src="<?php echo $url; ?>images/panel_questions.png" alt=""/>
                        <a href="<?php echo $url; ?>qastages/">Въпроси</a>
                    </div>
                    <div id="panel_link_projects">
                        <img src="<?php echo $url; ?>images/panel_projects.png" alt=""/>
                        <a href="<?php echo $url; ?>projects/">Проекти</a>
                    </div>
                    <div id="panel_link_groups">
                        <img src="<?php echo $url; ?>images/panel_groups.png" alt=""/>
                        <a href="<?php echo $url; ?>groups/">Групи</a>
                    </div>
                    <div id="panel_link_search">
                        <input type="text" class="input search" id="searchbox" />
                        <div id="display"><a href="<?php echo $url; ?>search.php">Разширено търсене</a></div>
                    </div>
                </div>
                <?php
                if (has_access($session_user_id, 1) === true) { ?>
                    <div id="admmod">
                        <img src="<?php echo $url; ?>images/admmod.png" alt="Admin"/>
                        <a href="<?php echo $url; ?>admin/index.php">Админ Панел</a>
                    </div>
         <?php } else if (has_access($session_user_id, 2) === true) { ?>
                    <div id="admmod">
                        <img src="<?php echo $url; ?>images/admmod.png" alt="Admin" />
                        <a>Мод Панел</a>
                    </div>
         <?php } ?>
          </div>
    <div id="right_panel">
            <div id="rightpanel_menu">
                    <a id="head_menu_root" href="#"><img src="<?php echo $url; ?>images/rightpanel_menu.png" alt="Menu"></a>
                    <div id="head_menu">
                        <!-- Head Menu Links -->
                        <a href="<?php echo $url; ?>user/open_gallery.php?id=<?php echo $session_user_id; ?>">Галерия</a>
                        <a href="<?php echo $url; ?>settings/index.php">Настройки</a>
                        <a href="<?php echo $url; ?>user/all_friends.php" class="link">Приятели</a>
                        <a href="<?php echo $url; ?>core/logout.php">Изход</a>
                    </div>
            </div>
            <div id="header_profile"><img src="<?php echo $url . $user_data['profile']; ?>"/>
                <a href="<?php echo $url . 'user/' .$user_data['username']; ?>"><?php echo $user_data['first_name']; echo " ", $user_data['last_name']; ?></a>
            </div>
            <div id="header_stats">
                <a id="pokani-root" href="##">
                    <?php
                        $sql = "SELECT * FROM friend_requests WHERE mem2='$session_user_id' ORDER BY id ASC";
                        $query = mysql_query($sql) or die (mysql_error());
                        $num_rows = mysql_num_rows($query); 
                        if ($num_rows < 1) { echo '<img src="'. $url .'images/noinv.png" alt="No invitations!" />';
                        } else { echo '<img src="'. $url .'images/gotinv.png" alt="Got invitations!" />'; }
                    ?>
                </a>
                <div id="pokani">
                    <script type="text/javascript">
                        function acceptFriendRequest(x) {
                        var url = "<?php echo $url; ?>core/request_as_friend.php";
                        var thisRandNum = "<?php echo $thisRandNum; ?>";
                        $.post(url,{ request: "acceptFriend", reqID: x, thisWipit: thisRandNum}, function(data){
                             $("#req"+x).html(data).show();
                        })
                        }
                        function denyFriendRequest(x) {
                        var url = "<?php echo $url; ?>core/request_as_friend.php";
                        var thisRandNum = "<?php echo $thisRandNum; ?>";
                        $.post(url,{ request: "denyFriend", reqID: x, thisWipit: thisRandNum}, function(data){
                             $("#req"+x).html(data).show();
                        })
                        }
                    </script>
                    <?php 
                        $sql = "SELECT * FROM friend_requests WHERE mem2='$session_user_id' ORDER BY id ASC";
                        $query = mysql_query($sql) or die (mysql_error());
                        $num_rows = mysql_num_rows($query); 
                        if ($num_rows < 1) {
                            echo '<p><strong>Нямаш покани за приятелство</strong></p>';
                        } else {
                            while ($row = mysql_fetch_array($query)) { 
                                $requestID = $row["id"];
                                $mem1 = $row["mem1"];
                                $sqlName = mysql_query("SELECT `username`, `first_name`, `last_name`, `profile` FROM `users` WHERE `user_id` ='$mem1' LIMIT 1") or die (mysql_error());
                                     while ($row = mysql_fetch_array($sqlName)) { $requesterFirstName = $row["first_name"]; $requesterLastName = $row["last_name"]; $userlink = $row["username"]; $userpic = $row["profile"]; }
                                     echo'<table width="100%" cellpadding="5">
                                          <tr><td width="17%" align="left"><div style="overflow:hidden; height:50px;"><a href="'. $url . 'user/' . $userlink. '"><img src="'. $url . $userpic . '" width="50px" border="0"/></a></div></td>
                                          <td width="83%"><a href="'. $url . 'user/' . $userlink. '">' . $requesterFirstName .' '. $requesterLastName. '</a> Ви изпрати покана!<br />
                                          <span id="req' . $requestID . '">
                                          <a href="#" onclick="return false" onmousedown="javascript: acceptFriendRequest(' . $requestID . ');" >Приеми</a> ИЛИ 
                                          <a href="#" onclick="return false" onmousedown="javascript: denyFriendRequest(' . $requestID . ');" >Откажи</a>
                                          </span></td>
                                          </tr>
                                          </table>';
                             }	 
                         }
                     ?>
                </div>
                <a id="messages-root" href="<?php echo $url; ?>user/pm_inbox.php">
                     <?php
                        $sql = "SELECT * FROM private_messages WHERE to_id='$session_user_id' AND opened = '0' ";
                        $query = mysql_query($sql) or die (mysql_error());
                        $num_rows = mysql_num_rows($query); 
                        if ($num_rows < 1) { echo '<img src="'. $url . 'images/nomessages.png" alt="No Messages">';
                        }else { echo '<img src="'. $url . 'images/gotmessages.png" alt="Got Messages">'; } 
                     ?>
                </a>
                    <?php 
                        $Updates = new Updates();
                        $gotUpdates = $Updates->gotUpdates($_SESSION['user_id']);
                        $updatesArray = $Updates->getUpdates($_SESSION['user_id']);
                    ?>
                <a  id="updates-root" href="#">
                    <?php
                        if($gotUpdates < 1) { ?>
                            <img src="<?php echo $url; ?>images/news.png" alt="Updates">
                    <?php } else { ?>
                            <img src="<?php echo $url; ?>images/gotnews.png" alt="Updates">
                    <?php } ?>
                </a>
                <div id="updates">
                    <?php 
                        include 'user/load_homeupdates.php';
                    ?>
                </div>
            </div>
    </div>
</div>
<?php } else { ?>
<div id="header">
      <div id="panel_logo">
           <a href="home"><img src="images/logo_big.png" alt="yourDraft"></a>
      </div>
</div>
<?php } ?>
        <div id="content">