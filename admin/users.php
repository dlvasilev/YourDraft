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
$admin = new Admin();
$usersarray = $admin->getUsers();
?>
    <div id="infoBox" style="width: 700px; margin: 30px auto;">
        <div id="infoBoxHead">Управление на потребители</div>
        <div id="infoBoxBody"><br />
            <table>
                <tr>
                    <td>Потребителско име</td>
                    <td>Име</td>
                    <td>Фамилия</td>
                    <td>Имейл</td>
                    <td>Състояние</td>
                    <td>Сега е</td>
                    <td>Действия</td>
                </tr>
           <?php
                foreach($usersarray as $data){
                    $id = $data['user_id'];
                    $username = $data['username'];
                    $firstName = $data['first_name'];
                    $lastName = $data['last_name'];
                    $email = $data['email'];
                    $active = $data['active'];
                    $here = $data['here'];
                    ?>
                <tr>
                    <td><a href="../<?php echo $username; ?>"><?php echo $username; ?></a></td>
                    <td><?php echo $firstName; ?></td>
                    <td><?php echo $lastName; ?></td>
                    <td><?php echo $email; ?></td>
                    <td><?php if($active == 1) echo "АКТИВЕН"; else  echo "БЛОКИРАН"; ?></td>
                    <td><?php if($here == 1) echo "ОНЛАЙН"; else  echo "ОФЛАЙН"; ?></td>
                    <td>
                        <form action="changeacc.php" method="post">
                            <input type="submit" value="ПРОМЕНИ">
                            <input type="hidden" name="user_id" value="<?php echo $id; ?>">
                        </form>
                    </td>
                </tr>
                    <?php
                }
           ?>
            </table>
        </div>
    </div>
<?php include '../include/overall/footer.php'; ?>