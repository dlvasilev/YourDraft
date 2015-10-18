<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Админ Панел//
include '../core/init.php';
include '../core/functions/admin.func.php';
protect_page();
admin_protect();
include '../include/overall/header.php';
if(isset($_POST["submit"])) {
    $user_id = $_POST['user_id'];
    $active = $_POST["active"];
    mysql_query("UPDATE `users` SET `active` = '$active' WHERE `user_id` = $user_id");
    header('index.php');
    $output = "Успешно!";
}
?>
    <div id="infoBox" style="width: 700px; margin: 30px auto;">
        <div id="infoBoxHead">Управление на потребители</div>
        <div id="infoBoxBody"><br />
            <?php
                $user_id = $_POST['user_id'];
                $query = mysql_query("SELECT * FROM users WHERE user_id = $user_id");
                $row = mysql_fetch_array($query);
                $username = $row['username'];
                $firstName = $row['first_name'];
                $lastName = $row['last_name'];
                $email = $row['email'];
                $active = $row['active'];
            ?>
            <form action="" method="post">
                <table width="700px">
                     <tr><td width="200px">Име:</td><td><?php echo $firstName; ?></td></tr>
                     <tr><td>Фамилия:</td><td><?php echo $lastName; ?></td></tr>
                     <tr><td>Имейл:</td><td><?php echo $email; ?></td></tr>
                     <tr><td>Състияние:</td><td>
                      <select name="active">
                               <option value="1">АКТИВЕН</option>
                               <option value="0">БЛОКИРАН</option>
                      </select>
                     </td></tr>
                     <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                     <tr><td><input type="submit" name="submit" value="Готово"></td></tr>
                </table>
            </form>
            <?php echo $output; ?>
        </div>
    </div>
<?php 

include '../include/overall/footer.php'; 
?>