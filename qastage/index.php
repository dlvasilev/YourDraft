<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
include '../core/init.php';
include '../include/overall/header.php';
?>
<?php 
$sql = mysql_query("SELECT * FROM qastage WHERE type='a' ORDER BY date_time DESC");
$dynamicList = "";
$numRows = mysql_num_rows($sql);
if($numRows < 1) {
    $dynamicList = "Не са задавани въпроси все още...";
} else {
    while($row = mysql_fetch_array($sql)){
        $questionId = $row['id'];
        $questionTitle = $row['question_title'];
        $authorID = $row['post_author_id'];
        $query = mysql_query("SELECT username, profile, first_name, last_name FROM users WHERE user_id = $authorID LIMIT 1");
        $queryrow = mysql_fetch_array($query);
        $username = $queryrow['username'];
        $firstName = $queryrow['first_name'];
        $lastName = $queryrow['last_name'];
        $avatar = $queryrow['profile'];
        $dynamicList .= '<div id="QuestionBox">
                            <div id="QuestionImg"><img src="../'.$avatar.'" class="big_face"></div>
                            <div id="QuestionSender"><a href="../'.$username.'">'.$firstName.' '.$lastName.'</a> попита: </div> 
                            <div id="QuestionBody"><a href="view_question.php?id='.$questionId.'">'.$questionTitle.'</a></div>
                        </div>';
    }
}
?>
<div id="infoBox">
     <div id="infoBoxHead">Въпроси & Отговори</div>
     <div id="infoBoxBody">
            <p>Тук ти можеш да видиш вече зададените въпроси, да зададеш въпрос и да отговориш на някои въпрос</p>
     </div>
</div>
<?php echo $dynamicList; ?>
<br /><div class="button"><a href="new_qestion.php">Нов въпрос</a></div>
<?php include '../include/overall/footer.php'; ?>