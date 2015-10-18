<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Настройки //
include 'core/init.php';
protect_page();
include 'include/overall/homeheader.php';

if (empty($_POST) === false) {
    $required_fields = array('first_name', 'email');
    foreach ($_POST as $key=>$value) {
       if (empty($value) && in_array($key, $required_fields) === true) {
           $errors[] = 'Местата означени със * за садължителни. Моля попълнете ги';
           break 1;
       }
    }
    
    if (empty($errors) === true) {
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Невалиден Имейл адрес';
        } else if (email_exists($_POST['email']) === true && $user_data['email'] !== $_POST['email']) {
            $errors[] = 'Имейла \'' . $_POST['email'] . '\' е зает.';
        }
    }
}

?>
<div id="profilecont">
    <a href="changepassword.php">Смяна на парола</a>
</div><br />
<div id="cont">
<?php 
if (isset($_GET['success']) === true && empty ($_GET['success']) === true) {
    echo 'Вашата информация беше променена';
} else {
    if (empty($_POST) === false && empty($errors) === true)  {
        $update_data = array (
            'first_name'    => $_POST['first_name'],
            'last_name'     => $_POST['last_name'],
            'email'         => $_POST['email'],
            'phone'         => $_POST['phone'],
            'skype'         => $_POST['skype'],
            'facebook'      => $_POST['facebook'],
            'discription'   => $_POST['discription'],
            'portfolio'     => $_POST['portfolio'],
            'works'         => $_POST['works']
        );
        update_user($update_data);
        header ('Location: settings.php?success');
        exit();
    } else if (empty($errors) === false) {
        echo output_errors($errors);
    }
    ?>
    <h3>Лични настройки</h3>
    <form action="" method="post">
        <table width="700px">
                 <tr><td width="200px">Име:</td><td><input type="text" name="first_name" value="<?php echo $user_data['first_name']; ?>"></td></tr>
                 <tr><td>Фамилия:</td><td><input type="text" name="last_name" value="<?php echo $user_data['last_name']; ?>"></td></tr>
                 <tr><td>Имейл:</td><td><input type="text" name="email" value="<?php echo $user_data['email']; ?>"></td></tr>
                 <tr><td>Tелефон:</td><td><input type="text" name="phone" value="<?php echo $user_data['phone']; ?>"></td></tr>
                 <tr><td>Скайп:</td><td><input type="text" name="skype" value="<?php echo $user_data['skype']; ?>"></td></tr>
                 <tr><td>Фейсбук:</td><td><input type="text" name="facebook" value="<?php echo $user_data['facebook']; ?>">
                 <tr><td>Кратко описание:</td><td><textarea type="text" name="discription"><?php echo $user_data['discription']; ?></textarea></td></tr>
                 <tr><td>Инстереси / Занимания:</td><td><textarea type="text" name="works"><?php echo $user_data['works']; ?></textarea></td></tr>
                 <tr><td>Портфолио:</td><td><textarea rows="5" name="portfolio" style="width: 40%"><?php echo $user_data['portfolio']; ?></textarea></td></tr>
                 <tr><td><input type="submit" value="Готово"></td></tr>
        </table>
   </form>
</div><br />
<div id="cont">
    <h3>Смяна на аватар</h3>
        <div class="profilesettings">
        <?php 
        if (isset($_FILES['profile']) === true) {
            if (empty($_FILES['profile']['name']) === true) {
                echo 'Моля изберете файл';
            } else {
                $allowed = array('jpg', 'jpeg', 'gif', 'png');
                $file_name = $_FILES['profile']['name'];
                $file_extn = strtolower(end(explode('.', $file_name)));
                $file_temp = $_FILES['profile']['tmp_name'];
                
                if (in_array($file_extn, $allowed) === true) {
                    change_profile_image($session_user_id, $file_temp, $file_extn);
                    header('Location: settings.php');
                    exit();
                } else {
                    echo 'Невалиден файл. Позволени: ';
                    echo implode(', ', $allowed);
                }
            }
        }
        
        if (empty($user_data['profile']) === false) {
            echo '&nbsp;&nbsp;&nbsp; <img src="', $user_data['profile'], '" alt="Снимка на: ', $user_data['first_name'], '">';
        }
        ?>
        <form action="" method="post" enctype="multipart/form-data">
        &nbsp;&nbsp;&nbsp; <input type="file" name="profile">
        &nbsp;&nbsp;&nbsp; <input type="submit">
        </form>
    </div>
<?php
}
?>
<?php
include 'include/overall/homefooter.php'; 
?>