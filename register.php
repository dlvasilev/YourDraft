<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Регистрация //
include 'core/init.php';
logged_in_redirect();
include 'include/overall/homehead.php'; 
if (empty($_POST) === false) {
    $required_fields = array('username', 'password', 'password_again', 'first_name', 'last_name', 'email');
    foreach ($_POST as $key=>$value) {
       if (empty($value) && in_array($key, $required_fields) === true) {
           $errors[] = 'Моля попълнете всички полета';
           break 1;
       }
    }
    if (empty($errors) === true) {
        if (user_exists($_POST['username']) === true) {
            $errors[] = 'Името \'' . $_POST['username'] . '\' е заето.';
        }
        if (preg_match("/\\s/", $_POST['username']) == true) {
            $errors[] = 'Вашото име не може да съдържа празни пространства';
        }
        if (strlen($_POST['password']) < 6) {
            $errors[] = 'Вашата парола, трябва да бъде най-малко  от 6 знака';
        }
        if ($_POST['password'] !== $_POST['password_again']) {
            $errors[] = 'Паролите не съвпадат';
        }
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
            $errors[] = 'Невалиден Имейл адрес';
        }
        if (email_exists($_POST['email']) === true) {
            $errors[] = 'Имейла \'' . $_POST['email'] . '\' е зает.';
        }
    }
}
?>
<div id="register_box">
<h3>Регистрация</h3>
<?php
if (isset($_GET['success']) && empty($_GET['success'])) {
    echo '<p>Регистрацията - УСПЕШНА!</p>';
} else {
    if (empty($_POST) === false && empty($errors) === true) {
        $register_data = array(
            'username'      => $_POST['username'],
            'password'      => $_POST['password'],
            'first_name'    => $_POST['first_name'],
            'last_name'     => $_POST['last_name'],
            'email'         => $_POST['email'],
        );
        register_user($register_data);
        header('Location: register.php?success');
        exit();
    } else if (empty($errors) === false){
        echo output_errors($errors);
    }
?>
    <form action="" method="post">
                <input type="text" name="username" class="input" id="loginname">
                <input type="password" name="password" class="input" id="loginpass">
                <input type="password" name="password_again" class="input" id="loginpassagain">
                <input type="text" name="first_name" class="input" id="firstname">
                <input type="text" name="last_name" class="input" id="lastname">
                <input type="text" name="email" class="input" id="regemail">
                <input type="submit" value="Регистрирай се" class="register_link"> или <a href="home" class="login_button">Обратно</a>
    </form>
<?php 
}
?>
</div>
<?php
include 'include/overall/homefoot.php'; 
?> 