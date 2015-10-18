<?php
include '../init.php';
if (isset($_POST['ploc_id'], $_SESSION['user_id']) && ploc_exists($_POST['ploc_id'])) {
    echo like_count($_POST['ploc_id']);
}
if (isset($_POST['advert_id'], $_SESSION['user_id']) && advert_exists($_POST['advert_id'])) {
    echo advert_like_count($_POST['advert_id']);
}
?>
