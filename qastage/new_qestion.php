<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
include '../core/init.php';
include '../include/overall/header.php';
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == "") {
	echo "Моля влезте си";
	exit();
} else {
	$u_id = mysql_real_escape_string($_SESSION['user_id']);
	$u_name = mysql_real_escape_string($_SESSION['username']);
	$u_email = mysql_real_escape_string($_SESSION['useremail']);
	$u_pass = mysql_real_escape_string($_SESSION['userpass']);
	$sql = mysql_query("SELECT * FROM users WHERE user_id='$u_id' AND username='$u_name' AND email='$u_email' AND password='$u_pass'");
        $numRows = mysql_num_rows($sql);
    if ($numRows < 1) {
	    echo "ERROR: Nqma vi vyv sistemata.";
	    exit();
    }
}
?>
<div id="infoBox">
        <div id="infoBoxHead">Нов въпрос</div>
        <div id="infoBoxBody">
            <p>Имате въпрос или проблем и не знаете как да го решите?</p>
            <p>Тук е мястото за вас. От тук вие можете да пуснете своя въпрос в мрежата и после единственото, което ще ви остава е да изчвакате малко време, докато някои друг потребител ви отговори</p>
        </div>
</div>
<script type="text/javascript" language="javascript"> 
function validateMyForm ( ) { 
    var isValid = true;
    if ( document.form1.post_title.value == "" ) { 
	    alert ( "Ноля напишете името въпроса" ); 
	    isValid = false;
    } else if ( document.form1.post_title.value.length < 10 ) { 
            alert ( "Името на въпроса, трябва да бъде поне 10 символа" ); 
            isValid = false;
    } else if ( document.form1.post_body.value == "" ) { 
            alert ( "Моля напишете въпроса." ); 
            isValid = false;
    }
    return isValid;
}
</script><br />
<form action="../core/parse_question.php" method="post" name="form1">
    <input name="post_type" type="hidden" value="a" />
    Автор на Въпроса:<br /><input name="topic_author" type="text" disabled="disabled" maxlength="64" style="width:96%;" value="<?php echo $u_name; ?>" />
    <br /><br />
    Име на Въпроса:<br /><input name="post_title" type="text" maxlength="64" style="width:96%;" /><br /><br />
    Въпрос:<br /><textarea name="post_body" rows="15" style="width:96%;"></textarea>
    <br /><br /><input name="" type="submit" value="Готово!" onclick="javascript:return validateMyForm();"/>
    <input name="uid" type="hidden" value="<?php echo $_SESSION['user_id']; ?>" />
    <input name="upass" type="hidden" value="<?php echo $_SESSION['userpass']; ?>" />
</form>
<?php include '../include/overall/footer.php'; ?>