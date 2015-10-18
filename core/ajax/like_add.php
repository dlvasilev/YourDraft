<?php
include '../init.php';
if(isset($_POST['ploc_id'], $_SESSION['user_id']) && ploc_exists($_POST['ploc_id'])) {
    $plocid = $_POST['ploc_id'];
    if (previously_liked($plocid) === true) {
        echo 'Вече сте го харесали';
    } else {
        add_like($plocid);
        echo 'success';
    }
}
if(isset($_POST['advert_id'], $_SESSION['user_id']) && advert_exists($_POST['advert_id'])) {
    $advert_id = $_POST['advert_id'];
    if (advert_previously_liked($advert_id)) {
        echo 'Вече сте го харесали';
    } else {
        advert_add_like($advert_id);
        echo 'success';
    }
}
?>
