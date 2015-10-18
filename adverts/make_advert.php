<?php
include '../core/init.php';
include '../include/overall/header.php';
    if (isset($_POST['submit'])) {
        $name       = $_POST['name'];
        $post_field = $_POST['post_field'];
        $post_field = stripslashes($post_field);
        $post_field = strip_tags($post_field);
        $post_field = mysql_real_escape_string($post_field);
        $post_field = eregi_replace("`", "&#39;", $post_field);
        $sql = mysql_query("INSERT INTO advertise (from_id, name, content, date) VALUES ('$session_user_id', '$name',  '$post_field', now())") or die(mysql_error());
        $msg = "Успешно направихе обява!";
    }
?>
<div id="infoBox">
   <div id="infoBoxHead">Нова Обява</div>
   <div id="infoBoxBody">
       <p>Тук е мястото, от което вие можете да пуснете в мрежата вашата обява</p>
       <p>Всички полета са ЗАДЪЛЖИТЕЛНИ</p>
   </div>
</div>
<div id="cont">
<?php 
echo $msg; 
?>
<form method="post" action="" name="post_form">
    <p>Име: <input type="text" name="name" width="75px"/></p>
    <p>Текст: <textarea cols="75" rows="1" name="post_field" id="pоst_field"></textarea></p>
    <input type="submit"  value=" Сподели "  id="ploc" name="submit"/>
</form>
</div>
<?php include '../include/overall/footer.php'; ?>