<?php
include '../core/init.php';
include '../include/overall/header.php';
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
    <div id="infoBox" style="width: 700px; margin: 30px auto;">
        <div id="infoBoxHead">Лични настройки</div>
        <div id="infoBoxBody"><br />
            <?php 
            if (isset($_GET['success']) === true && empty ($_GET['success']) === true) {
                echo 'Вашата информация беше променена';
            } else {
                if (empty($_POST) === false && empty($errors) === true)  {
                    $update_data = array (
                        'first_name'    => $_POST['first_name'],
                        'last_name'     => $_POST['last_name'],
                        'email'         => $_POST['email'],
                        'city'          => $_POST['city'],
                        'country'       => $_POST['country'],
                        'phone'         => $_POST['phone'],
                        'skype'         => $_POST['skype'],
                        'facebook'      => $_POST['facebook'],
                        'website'       => $_POST['website'],
                        'interests'     => $_POST['interests'],
                        'hobbies'       => $_POST['hobbies'],
                        'discription'   => $_POST['discription'],
                        'portfolio'     => $_POST['portfolio'],
                        'works'         => $_POST['works']
                    );
                    update_user($update_data);
                    header ('Location: changeinfo.php?success');
                    exit();
                } else if (empty($errors) === false) {
                    echo output_errors($errors);
                }
                ?>
                <form action="" method="post">
                    <table width="700px">
                             <tr><td width="200px">Име:</td><td><input type="text" name="first_name" value="<?php echo $user_data['first_name']; ?>"></td></tr>
                             <tr><td>Фамилия:</td><td><input type="text" name="last_name" value="<?php echo $user_data['last_name']; ?>"></td></tr>
                             <tr><td>Имейл:</td><td><input type="text" name="email" value="<?php echo $user_data['email']; ?>"></td></tr>
                             <tr><td>Град:</td><td><input type="text" name="city" value="<?php echo $user_data['city']; ?>"></td></tr>
                             <tr><td>Държава:</td><td><input type="text" name="country" value="<?php echo $user_data['country']; ?>"></td></tr>
                             <tr><td>Tелефон:</td><td><input type="text" name="phone" value="<?php echo $user_data['phone']; ?>"></td></tr>
                             <tr><td>Скайп:</td><td><input type="text" name="skype" value="<?php echo $user_data['skype']; ?>"></td></tr>
                             <tr><td>Фейсбук:</td><td><input type="text" name="facebook" value="<?php echo $user_data['facebook']; ?>">
                             <tr><td>Уеб-сайт:</td><td><input type="text" name="website" value="<?php echo $user_data['website']; ?>"></td></tr>
                             <tr><td>Кратко описание:</td><td><textarea type="text" name="discription" rows="5" cols="60"><?php echo $user_data['discription']; ?></textarea></td></tr>
                             <tr><td>Професия:</td><td><textarea type="text" name="works" cols="60"><?php echo $user_data['works']; ?></textarea></td></tr>
                             <tr><td>Инстереси / Занимания:</td><td><textarea type="text" name="interests" cols="60"><?php echo $user_data['interests']; ?></textarea></td></tr>
                             <tr><td>Хоби:</td><td><textarea type="text" name="hobbies" cols="60"><?php echo $user_data['hobbies']; ?></textarea></td></tr>
                             <tr><td>Портфолио:</td><td><textarea rows="5" name="portfolio" rows="10" cols="60"><?php echo $user_data['portfolio']; ?></textarea></td></tr>
                             <tr><td><input type="submit" value="Готово"></td></tr>
                    </table>
               </form>
      <?php } ?>    
        </div>
    </div>
<?php include '../include/overall/footer.php'; ?>