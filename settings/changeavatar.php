<?php
include '../core/init.php';
include '../include/overall/header.php';
?>
<div id="infoBox" style="width: 700px; margin: 30px auto;">
    <div id="infoBoxHead">Смана на аватар</div>
    <div id="infoBoxBody"><br />
<link rel="stylesheet" type="text/css" href="../css/imgareaselect.css" />
<script type="text/javascript" src="../js/jquery.imgareaselect.pack.js"></script>
<script type="text/javascript">
function getSizes(im,obj) {
    var x_axis = obj.x1;
    var x2_axis = obj.x2;
    var y_axis = obj.y1;
    var y2_axis = obj.y2;
    var thumb_width = obj.width;
    var thumb_height = obj.height;
    if(thumb_width > 0) {
        if(confirm("Искате ли да запазите снимката..?")){
            $.ajax({
                type:"GET",
                url:"../core/ajax/ajax_image.php?t=ajax&img="+$("#image_name").val()+"&w="+
                thumb_width+"&h="+thumb_height+"&x1="+x_axis+"&y1="+y_axis,
                cache:false,
                success:function(rsponse){
                $("#cropimage").hide();
                $("#thumbs").html("");
                $("#thumbs").html("<img src='../images/profile/"+rsponse+"' />");
                }
            });
        }
    }
    else
    alert("Изберете част..!");
}
$(document).ready(function () {
    $('img#photo').imgAreaSelect({
        aspectRatio: '1:1',
        onSelectEnd: getSizes
    });
});
</script>
<?php
$path = "../images/profile/";
$valid_formats = array("jpg", "png", "gif", "bmp");
if(isset($_POST['submit'])){
    $name = $_FILES['photoimg']['name'];
    $size = $_FILES['photoimg']['size'];
    if(strlen($name)){
        list($txt, $ext) = explode(".", $name);
        if(in_array($ext,$valid_formats) && $size<(1024*1024)){
            $actual_image_name = time().substr($txt, 5).".".$ext;
            $tmp = $_FILES['photoimg']['tmp_name'];
            if(move_uploaded_file($tmp, $path.$actual_image_name)){
                mysql_query("UPDATE users SET profile_big='images/profile/$actual_image_name' WHERE user_id='$session_user_id'");
                $image="<h1>Моля изберете коя част от снимката искате да запазите...</h1><img src='../images/profile/".$actual_image_name."' id=\"photo\" >";
            }
            else echo "Грешка";
        }
        else echo "Невалиден файл..!";
    }
    else echo "Невалиден файл. Моля изберете снимка..!";
}
?>
<?php echo $image; ?>
    <div id="thumbs"></div>
    <form id="cropimage" method="post" enctype="multipart/form-data">
        Качете снимка <input type="file" name="photoimg" id="photoimg" />
        <input type="hidden" name="image_name" id="image_name" value="<?php echo($actual_image_name)?>" />
        <input type="submit" name="submit" value="Submit" /> 
    </form>
    </div>
</div>
<?php include '../include/overall/footer.php'; ?>
