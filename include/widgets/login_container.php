<div id="login_container">
    <div id="login_box">
        <div id="img_box"><img src='images/profile/none.png' /></div>
        <?php
            include 'core/login.php';
            if (empty($errors) === false) {
                echo output_errors($errors);
            }
        ?>
        <form action="" method="post">
          <input type="text" name="username" class="input user" id="loginname"/>
          <input type="password" name="password" class="input passcode" id="loginpass"/>
          <input type="submit" value="Вход" class="login_button"/><br />
        </form>
        или <a href="register" class="register_link">Регистрация</a>
    </div>
</div>