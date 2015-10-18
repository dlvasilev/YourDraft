<?php
/*
 * Project: yourdraft
 * Author : Daniel Vasilev (DANGAM)
 * All Rights Reserved
 */
include 'core/init.php';
if(logged_in()) {
    header("location: draftboard");
}
include 'include/overall/homehead.php';
include 'include/widgets/home_not_logged.php';
include 'include/overall/homefoot.php';
?>
