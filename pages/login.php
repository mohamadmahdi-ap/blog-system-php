<?php

$base= "../";
$page_title = "ورود به حساب";
include($base."template/header.php");
require_once("../classes/Tokenize.php");
if(!Tokenize::validate_token()){

    $errors = ['username_error'=>'' , 'password_error'=>''];
    $form_data = [
            "username" => "",
            "user_password" => ""
        ];
    if(isset($_COOKIE['username']) and isset($_COOKIE['password'])){
        $form_data = [
            "username" =>$_COOKIE['username'],
            "user_password" => $_COOKIE['password']
        ];
    }
    if(isset($_POST['login'])){

        if(isset($_POST['remember']) and $_POST['remember'] == 'on'){
            setcookie('username' , $_POST['username']);
            setcookie('password' , $_POST['password']);
        }
        $form_data = [
            "username" => $_POST['username'],
            "user_password" => $_POST['password']
        ];
        $form_data = Sanitizer::sanitize($form_data);
        $auth = new Auth();
        $auth->login($form_data);
        $errors = $auth->get_errors();
    }
}else{
    header("Location: ../dashboard/");
}
?>

<main>
        <div class="form-box">

            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                <div class="form">

                <i class="fi fi-rr-arrow-small-left" id="return-btn" onclick="goback()"></i>
                <h2>ورود به حساب</h2>
                <div class="input-box">
                    <input type="text" name="username" id="username" required value="<?php echo $form_data['username']?>">
                    <label for="username">نام کاربری</label>
                    <span><?php echo $errors["username_error"]?></span>
                </div>
                <div class="input-box">
                    <input type="password" name="password" id="password" required value="<?php echo $form_data['user_password']?>">
                    <label for="password">گذرواژه</label>
                    <i class="fi fi-rr-eye" id="hide-password"></i>
                    <span><?php echo $errors["password_error"]?></span>
                </div>
                <div class="send-option">
                    <div class="remember-sec">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">به خاطر بسپار</label>
                    </div>
                    <input class="btn" type="submit" value="ورود" name="login">
                </div>
                <div>
                    حساب ندارید؟ <a href="<?php echo $base;?>pages/register.php" style="color: var(--main-color);">ثبت نام</a>
                </div>
                </div>
            </form>
        </div>
    </main>
    <script>
        // show and hide password
        let hidePassword = document.getElementById("hide-password");
        let passwordInput = document.getElementById("password")
        hidePassword.addEventListener("click" , ()=>{
            passwordInput.type = (passwordInput.type == "password")?"text" :"password";
            hidePassword.classList.toggle("fi-rr-eye")
            hidePassword.classList.toggle("fi-rr-eye-crossed")
        })
        //go back
        function goback(i = -1){
            window.history.go(i);
        }
    </script>
