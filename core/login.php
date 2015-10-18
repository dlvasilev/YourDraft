<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Логин код//
if (empty($_POST) === false) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if(empty($username) === true || empty($password) === true) {
        $errors[] = 'Трябва да въведеш име и парола';
    }  else if(user_exists($username) === false) {
        $errors[] = 'Не можем да намерим това име. Регистрирани ли сте?';
    } else if(user_active($username) === false) {
        $errors[] = 'Вашият акаунт е блокиран';
    } else {
        
        if (strlen($password) > 32) {
            $errors[] = "Твърде дълга парола";
        }
        
        $login = login($username, $password);
        if ($login === false) {
            $errors[] = 'Тази комбинация от име/парола е грешна';
        } else {
            $_SESSION['user_id'] = $login;
            mysql_query("UPDATE `users` SET `here`='1' WHERE `username` = '$username'") or die(mysql_error());
            header('Location: draftboard');
            exit();
        }
    }
}
?>
