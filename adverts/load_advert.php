<?php
foreach($advertsarray as $data) {
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
<div class="advert_container">
    <div class="advbody" id="advbody<?php echo $advert_id;?>">
        <div class="advimg">
            <img src="../<?php echo $profile; ?>" class='face'/>
        </div> 
        <div class="advtext">
            <a href="../<?php echo $username; ?>"><b><?php echo $name; ?></b></a><br /><?php echo $content;?>
            <div class="advlikes"><a href="javascript: void(0)" onclick="advert_like_add('<?php echo $advert_id; ?>');" class="like">Харесвам</a> | <span id="advert_<?php echo $advert_id; ?>_likes"><?php echo $likes; ?> </span> харесват това</div><br />        
        </div> 
    </div>
</div>
<?php
}
?>
