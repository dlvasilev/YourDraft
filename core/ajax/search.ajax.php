<?php
include('../init.php');
if($_POST){
    $q=$_POST['searchword'];
    $sql_res=mysql_query("SELECT * FROM users WHERE first_name LIKE '%$q%' OR last_name LIKE '%$q%' ORDER BY user_id");
    while($row=mysql_fetch_array($sql_res)){
        $fname=$row['first_name'];
        $lname=$row['last_name'];
        $img=$row['profile'];
        $username=$row['username'];
        $re_fname='<b>'.$q.'</b>';
        $re_lname='<b>'.$q.'</b>';
        $final_fname = str_ireplace($q, $re_fname, $fname);
        $final_lname = str_ireplace($q, $re_lname, $lname);
        ?>
        <div class="display_box" align="left">
            <a href="<?php echo $url . "user/" . $username; ?>"><img src="<?php echo $url . $img; ?>" style="width:25px; float:left; margin-right:6px" /><?php echo $final_fname; ?>&nbsp;<?php echo $final_lname; ?><br/>
            <span style="font-size:9px; color:#999999"><?php echo $username; ?></span></a>
        </div>
        <?php
    }
}
?>
