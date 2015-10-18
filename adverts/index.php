<?php
include '../core/init.php';
include '../include/overall/header.php';
$Adverts = new Adverts();
$myadvertsarray = $Adverts->GetMyAdverts($session_user_id);
$advertsarray = $Adverts->GetAdverts();
?>
<div class="button"><a href="make_advert.php">Нова Обява</a></div>
<div id="advert_cont">
    <?php include 'load_advert.php'; ?>
</div>
<div id="cont">
<h3>Мои Обяви</h3>
<div id="adverts_cont">
<?php
foreach($myadvertsarray as $data) {
    $advert_id      = $data['id'];
    $name           = $data['name'];
    $content        = htmlspecialchars($data['content']);
    $image          = $data['image'];
    $likes          = $Adverts->AdvertsCount($advert_id);
    $date           = $data['date'];
    $username       = $data['username'];
    $first_name     = $data['first_name'];
    $last_name      = $data['last_name'];
    $profile        = $data['profile'];
?>
<div class="my_advert_container" id="my_adverts_container">
    <div class="my_advbody" id="advbody<?php echo $advert_id;?>">
        <div class="advimg">
            <img src="../<?php echo $profile; ?>" class='face'/>
        </div> 
        <div class="my_advtext">
            <a href="../<?php echo $username; ?>"><b><?php echo $name; ?></b></a><br /><?php echo $content;?>
            <div class="advlikes"><a href="javascript: void(0)" onclick="advert_like_add('<?php echo $advert_id; ?>');" class="like">Харесвам</a> | <span id="advert_<?php echo $advert_id; ?>_likes"><?php echo $likes; ?> </span> харесват това</div><br />        
        </div> 
    </div>
</div>
<?php
}
?>
</div>
</div>
<?php include '../include/overall/footer.php'; ?>