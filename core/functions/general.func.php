<?php
/////////////////////
//   YOURDRAFT     //
//CREATED BY DANGAM//
//  Project 2012   //
/////////////////////
// Файл: Генералните Функции //
function logged_in_redirect() {
    if (logged_in() === true) {
        header ('Location: index.php');
        exit();
    }
}
function protect_page() {
    if (logged_in() === false) {
        header ('Location: ../core/protected.php');
        exit();
    }
}
function admin_protect() {
    global $user_data;
    if (has_access($user_data['user_id'], 1) === false) {
        header('Location: index.php');
        exit();
    }
}
function array_sanitize(&$item) {
    $item = htmlentities(strip_tags(mysql_real_escape_string($item)));  
}
function sanitize($data) {
    return strip_tags(mysql_real_escape_string($data));
}

function output_errors($errors) {
    return '<ul><li>' . implode('</li><li>', $errors) .'</li></ul>';
}
?>
