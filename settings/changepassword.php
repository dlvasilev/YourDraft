<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Смяна на парола //
include '../core/init.php';
protect_page();
if (empty($_POST) === false) {
    $required_fields = array('current_password', 'password', 'password_again');
    foreach ($_POST as $key=>$value) {
       if (empty($value) && in_array($key, $required_fields) === true) {
           $errors[] = 'Местата означени със * за садължителни. Моля попълнете ги';
           break 1;
       }
    }
    
    if (md5($_POST['current_password']) === $user_data['password']) {
        if (trim($_POST['password']) !== trim($_POST['password_again'])) {
            $errors[] = 'Новите пароли не съвпадат';
        } else if (strlen($_POST['password']) < 6) {
            $errors[] = 'Вашата парола, трябва да бъде най-малко  от 6 знака';
        }
    } else {
        $errors[] = 'Въвели сте грешна парола';
    }
    
}
include '../include/overall/header.php';
?>
    <div id="infoBox" style="width: 300px; margin: 30px auto;">
        <div id="infoBoxHead">Смяна на парола</div>
        <div id="infoBoxBody"><br />
<?php
if (isset($_GET['success']) && empty($_GET['success'])) {
    echo 'Вашата парола беше променена успешно';
} else {
    if (empty($_POST) === false && empty($errors) === true) {
        change_password($session_user_id, $_POST['password']);
        header ('Location: changepassword.php?success');
    } else if (empty($errors) === false){
        echo output_errors($errors);
    }
    ?>
    <form action="" method="post">
        <table>
            <tr>
                <td>Сегашна парола*:</td>
                <td><input type="password" name="current_password"></td>
            </tr>
            <tr>
                <td>Нова паролa*:</td>
                <td><input type="password" name="password"></td>
            </tr>
            <tr>
                <td>Нова парола отново*:</td>
                <td><input type="password" name="password_again"></td>
            </tr>
            <tr>
                <td><input type="submit" value="Смяна на парола"></td>
            </tr>
        </table>
    </form>
<p>Местата означени със * са ЗАДЪЛЖИТЕЛНИ</p>

<?php 
}
?>
        </div>
    </div>
<?php
include '../include/overall/footer.php'; 
?>