<?php

$base= "../";
$page_title = "ثبت نام";
include($base."template/header.php");

require_once("../classes/Tokenize.php");
if(!Tokenize::validate_token()){

    
    $errors = ['email_error'=>'' , 'username_error'=>'' , 'password_error'=>'', 'password_confirmation_error'=>''];
    $form_data = [
        "email" => "",
        "username" => "",
        "user_password" => ""
    ];
    if(isset($_POST['reister'])){
        
        if(isset($_POST['remember']) and $_POST['remember'] == 'on'){
            setcookie('username' , $_POST['username']);
            setcookie('password' , $_POST['password']);
        }

        $form_data = [
            "email" => $_POST['email'],
            "username" => $_POST['username'],
            "user_password" => $_POST['password'],
            "password_confirm" => $_POST['password-confirm']
        ];
        $form_data = Sanitizer::sanitize($form_data);
        $auth = new Auth();
        $auth->register($form_data);
        $errors = $auth->get_errors();
    }
}else{
    header("Location: ../dashboard/");
}

?>

<main>
    <div class="form-box create-form">

            <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="POST">
                <div class="form">
                <i class="fi fi-rr-arrow-small-left" id="return-btn" onclick="goback()"></i>
                <h2>ثبت نام</h2>
                <div class="input-box">
                    <input type="email" name="email" id="email" required value="<?php echo $form_data['email']?>">
                    <label for="email">ایمیل</label>
                    <span><?php echo $errors["email_error"]?></span>
                </div>
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
                <div class="input-box">
                    <input type="password" name="password-confirm" id="password-confirm" required>
                    <label for="password-confirm">تکرار گذرواژه</label>
                    <span><?php echo $errors["password_confirmation_error"]?></span>
                </div>
                <div class="send-option">
                    <div class="remember-sec">
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">به خاطر بسپار</label>
                    </div>
                    <input class="btn" type="submit" value="ثبت نام" name="reister">
                </div>
                <div>
                    قبلا ثبت نام کردید؟ <a href="<?php echo $base;?>pages/login.php" style="color: var(--main-color);">ورود به حساب</a>
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

