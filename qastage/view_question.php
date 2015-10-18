<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
include '../core/init.php';
protect_page();
$thread_id = preg_replace('#[^0-9]#i', '', $_GET['id']); 
$sql = mysql_query("SELECT * FROM qastage WHERE id='$thread_id' AND type='a' LIMIT 1");
$numRows = mysql_num_rows($sql);
if ($numRows < 1) {
	echo "ERROR: Ne su6testvuva takav vupros.";
	exit();
}
while($row = mysql_fetch_array($sql)){
	$post_author = $row["post_author"];
	$post_author_id = $row["post_author_id"];
	$date_time = $row["date_time"];
	$thread_title = $row["question_title"];
	$post_body = $row["post_body"];
}
$all_responses = "";
$sql = mysql_query("SELECT * FROM qastage WHERE otid='$thread_id' AND type='b'");
$numRows = mysql_num_rows($sql);
if ($numRows < 1) {
	$all_responses = '<div id="none_yet_div">Никой не е отговарил до сега. Може ти да си първия</div>';
} else {
    while($row = mysql_fetch_array($sql)){
	$reply_author = $row["post_author"];
	$reply_author_id = $row["post_author_id"];
	$date_n_time = $row["date_time"];
	$reply_body = $row["post_body"];
	$all_responses .= '<div class="response_top_div"><a href="../' . $reply_author . '">' . $reply_author . '</a> отговори на въпроса:<strong> ' . $thread_title . '</strong></div>
	<div class="response_div">' . $reply_body . '</div>';
   }
}
$replyButton = 'Trqbva da vleze6 !';
if (isset($_SESSION['user_id']) && isset($_SESSION['username']) && isset($_SESSION['useremail']) && isset($_SESSION['userpass'])) {
	$replyButton = '<input name="myBtn1" type="submit" value="Отговори" style="font-size:12px;" onmousedown="javascript:toggleForm(\'reponse_form\');" />';
}
$u_id = mysql_real_escape_string($_SESSION['user_id']);
$u_name = mysql_real_escape_string($_SESSION['username']);
$u_email = mysql_real_escape_string($_SESSION['useremail']);
$u_pass = mysql_real_escape_string($_SESSION['userpass']);
$sql = mysql_query("SELECT * FROM users WHERE user_id='$u_id' AND username='$u_name' AND email='$u_email' AND password='$u_pass'");
$numRows = mysql_num_rows($sql);
if ($numRows < 1) {
	   $replyButton = 'Trqbva da vleze6';
}
include '../include/overall/header.php';
?>
<script language="javascript" type="text/javascript">
function toggleForm(x) {
		if ($('#'+x).is(":hidden")) {
			$('#'+x).slideDown(200);
		} else {
			$('#'+x).slideUp(200);
		}
}
$('#responseForm').submit(function(){$('input[type=submit]', this).attr('disabled', 'disabled');});
function parseResponse ( ) {
	  var thread_id = $("#thread_id");
	  var post_body = $("#post_body");
	  var u_id = $("#member_id");
	  var u_pass = $("#member_password");
	  var url = "../core/parse_question.php";
      if (post_body.val() == "") {
           $("#formError").html('<font size="+2">Напиши нещо</font>').show().fadeOut(3000);
      } else if (post_body.val().length < 2 ) { 
	         $("#formError").html('<font size="+2">Трябва да бъде по-дълго').show().fadeOut(3000);
      } else {
		$("#myBtn1").hide();
        $.post(url,{ post_type: "b", tid: thread_id.val(), post_body: post_body.val(), uid: u_id.val(), upass: u_pass.val() } , function(data) {
			   $("#none_yet_div").hide();
			   var myDiv = document.getElementById('responses');
			   var magicdiv1 = document.createElement('div');
			   magicdiv1.setAttribute("class", "response_top_div");
			   magicdiv1.htmlContent = '<a href="../<?php echo $reply_author; ?>"><?php echo $reply_author; ?></a> отговори на въпроса: <strong><?php echo $thread_title ?></strong>';
			   magicdiv1.innerHTML = '<a href="../<?php echo $reply_author; ?>"><?php echo $reply_author; ?></a> отговори на въпроса: <strong><?php echo $thread_title ?></strong>';
			   myDiv.appendChild(magicdiv1);
			   var magicdiv = document.createElement('div');
			   magicdiv.setAttribute("class", "response_div");
			   magicdiv.htmlContent = data;
			   magicdiv.innerHTML = data;
			   myDiv.appendChild(magicdiv);
			   $('#reponse_form').slideUp("fast");
			   document.responseForm.post_body.value='';
			   $("#myBtn1").show();
         }); 
	  }
}
</script>
<h3><?php echo $thread_title; ?></h3>
    Въпроса е зададен от: <a href="../<?php echo $post_author; ?>"><?php echo $post_author; ?></a>
    &nbsp; &nbsp; &nbsp; Дата: <?php echo time_stamp($date_time); ?>
    <div class="topic_div"><?php echo $post_body; ?></div>
    <div id="responses"><?php echo $all_responses; ?></div>
<div id="reponse_form" style="display:none; border:#06C 1px solid; padding:16px;">
<form action="javascript:parseResponse();" name="responseForm" id="responseForm" method="post">
    Моля <?php echo $u_name; ?>, напишете вашия отговор тук:<br /><textarea name="post_body" id="post_body" cols="64" rows="12" style="width:98%;"></textarea>
    <div id="formError" style="display:none; padding:16px; color:#F00;"></div>
    <br /><br /><input name="myBtn1" id="myBtn1" type="submit" value="Отговори" style="padding:6px;" />
    или <a href="#" onclick="return false" onmousedown="javascript:toggleForm('reponse_form');">Отказ</a>
    <input name="thread_id" id="thread_id" type="hidden" value="<?php echo $thread_id; ?>" />
    <input name="member_id" id="member_id" type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
    <input name="member_password" id="member_password" type="hidden" value="<?php echo $_SESSION['userpass']; ?>" />
</form>
</div>
<?php echo $replyButton; ?>
<?php include '../include/overall/footer.php'; ?>