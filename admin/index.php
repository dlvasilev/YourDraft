<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Админ Панел//
include '../core/init.php';
protect_page();
admin_protect();
include '../include/overall/header.php';
?>
    <div id="infoBox" style="width: 700px; margin: 30px auto;">
        <div id="infoBoxHead">Админ Панел</div>
        <div id="infoBoxBody"><br />
           <a href="users.php">Управление на потребители</a>
        </div>
    </div>
    <div id="infoBox" style="width: 700px; margin: 30px auto;">
            <div id="infoBoxHead">Потребители</div>
            <div id="infoBoxBody"><br />
               <?php
                    $user_count = user_count();
                    $suffix = ($user_count != 1) ? 'и' : '';
               ?>
               <p>Ние имаме <?php echo $user_count; ?> регистриран<?php echo $suffix; ?> потребител<?php echo $suffix; ?>.</p>
            </div>
    </div>
<?php include '../include/overall/footer.php'; ?>