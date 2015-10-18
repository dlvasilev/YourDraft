    </div>
<div style="clear: both;">&nbsp;</div>
    <div id="bottom-bar">
		<div id="bottom-bar-frame">
			<div id="bottom-bar-content">
                            <div id="panel_chat">
                                    <img src="<?php echo $url; ?>images/chat.png" alt="Chat"/>
                                    <a id="chat-root" href="##">Чат</a>
                                    <div id="chat_list">
                                          <?php
                                              $chatfriend_array = $user_data["friend_array"];
                                              $chatfriendlist = "";
                                              if ($chatfriend_array != "") {
                                                   $chatfriendArray = explode(",", $chatfriend_array);
                                                   $allfriendCount = count($chatfriendArray);
                                                   $c = 0;
                                                   foreach($chatfriendArray as $key => $value) {
                                                       $c++;
                                                       $Chatsql = mysql_query("SELECT `user_id`, `username`, `first_name`, `last_name`, `profile`, `here` FROM `users` WHERE `user_id` ='$value' LIMIT 1") or die (mysql_error());
                                                       while ($row = mysql_fetch_array($Chatsql)) {$frid = $row['user_id']; $chatfriendFirstName = $row["first_name"]; $chatfriendLastName = $row["last_name"]; $chatfrpic= $row['profile']; $chatfrlink = $row['username']; $here = $row['here'];}
                                                           if ($here == 1) {$here = 'online';}
                                                           else {$here = 'offline';}
                                                           $chatfriendlist .= '<div class="chatppl">
                                                                                <div class="chatpplname"><a href="' . $url . 'chat/chatwith.php?id=' . $frid . '">' . $chatfriendFirstName . ' ' . $chatfriendLastName . '</a></div>
                                                                                <div class="chatpplimg"><a href="' . $url . 'user/' . $chatfrlink . '"><img src="'. $url . $chatfrpic . '"/></a></div>
                                                                                <div class="chatpplstatus">' . $here . '</div>
                                                                               </div>';
                                                   }
                                              }
                                              echo $chatfriendlist;
                                           ?>
                                     </div>
                                </div>
                                <p>Copyright© 2013 YourDraft. All rights Reserved.</p>
                                <p><a href="#">Условия за ползване</a> | <a href="#">Помощ</a> | <a href="#">Контакти</a></p>
			</div>	
		</div>
    </div> 
</body>
</html>