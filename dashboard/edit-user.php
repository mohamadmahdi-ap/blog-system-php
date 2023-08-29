<?php

$base= "../";
require_once($base."configs/config.php");

if(Tokenize::validate_token() and Tokenize::get_token() == 1){

    $db = new Database;
    
    $data = ["show_name" => "کاربر سایت" ,"avatar" => "" ,"username" => "","email" => "","user_password" => ""];
    $errors = ['show_name_error'=>'' ,'email_error'=>'' , 'username_error'=>'' , 'password_error'=>'' , 'avatar_error'=>''];

    
    
    if(isset($_GET["user_id"])){
        $user_id = htmlspecialchars($_GET["user_id"]);
        if($user_id!=1){
            $data= $db->select_once("users" , "id = $user_id");
            $page_title = "ویرایش کاربر « $data[username] »";
        }else{
            go_back();
        }
        $page_link = htmlspecialchars($_SERVER['PHP_SELF'])."?user_id=$user_id";
    }else{
        $page_title = "ایجاد کاربر جدید";
        $page_link = htmlspecialchars($_SERVER['PHP_SELF']);
        
    }

    if(isset($_POST['create_user'])or isset($_POST['edit_user'])){
        $data = [
            "show_name" => $_POST['show_name'] ,
            "file" => $_FILES['user_avatar'] ,
            "username" => $_POST['username'],
            "email" => $_POST['email'],
            "user_password" =>  $_POST['user_password']
        ];
        $user = new User();
        if(isset($_POST['edit_user'])){
            $user_id = htmlspecialchars($_GET["user_id"]);
            $user->update($user_id , $data);
        }
        if(isset($_POST['create_user'])){
            $user->create($data);
        }
        $errors = $user->get_errors();
        if(!array_filter($errors)){
            header("Location: ../dashboard/manage-users.php");
        }
    }

    include_once("../template/header.php");

}else{
    header("Location: ../index.php");
}

?>

    <main>
        <div class="form-box create-form">
            <form action="<?php echo $page_link;?>" method="POST" enctype="multipart/form-data">
                <div class="form">
                    <i class="fi fi-rr-arrow-small-left" id="return-btn" onclick="goback()"></i>
                    <h2><?php echo $page_title ; ?></h2>
                    <div class="user-avatar">
                        <div class="image-input">
                            <input type="file" name="user_avatar" id="file-input" accept=".jpg , .png">
                            <label for="file-input"><img src="<?php echo $base.'media/avatar/'.((isset($_GET['user_id']))?$data['avatar']:'user.png');?>" id="image-prev" alt=""></label>
                        </div>
                        <span class="span-alert"><?php echo $errors['avatar_error']?></span>
                    </div>
                    <div class="input-box">
                        <input type="text" name="show_name" id="show_name" required value="<?php echo $data['show_name'];?>">
                        <label for="show_name">نام نمایشی</label>
                        <span class="span-alert"><?php echo $errors['show_name_error']?></span>
                    </div>
                    <div class="input-box">
                        <input type="email" name="email" id="email" required value="<?php echo $data['email'];?>">
                        <label for="email">ایمیل</label>
                        <span class="span-alert"><?php echo $errors['email_error']?></span>
                    </div>
                    <div class="input-box">
                        <input type="text" name="username" id="username" required value="<?php echo $data['username'];?>">
                        <label for="username">نام کاربری</label>
                        <span class="span-alert"><?php echo $errors['username_error']?></span>
                    </div>
                    <div class="input-box">
                        <input type="password" name="user_password" id="password" required value="<?php echo $data['user_password'];?>">
                        <label for="password">گذرواژه</label>
                        <i class="fi fi-rr-eye" id="hide-password"></i>
                        <span class="span-alert"><?php echo $errors['password_error']?></span>
                    </div>
                    <input class="btn" type="submit" value="ثبت" name="<?php echo (isset($_GET['user_id'])?'edit_user':'create_user');?>">
                    
                </div>
            </form>
        </div>
    </main>
    <script>
        //go back
        function goback(i = -1){
            window.history.go(i);
        }

        let hidePassword = document.getElementById("hide-password");
        let passwordInput = document.getElementById("password")
        hidePassword.addEventListener("click" , ()=>{
            passwordInput.type = (passwordInput.type == "password")?"text" :"password";
            hidePassword.classList.toggle("fi-rr-eye")
            hidePassword.classList.toggle("fi-rr-eye-crossed")
        })

        //change image preview
        let imagePrev = document.getElementById("image-prev");
        let defaultSrc =imagePrev.src;
        let imageInp = document.getElementById("file-input");
        const fileReader = new FileReader;
        fileReader.onload = (e)=>{
            imagePrev.src = e.target.result;
        }
        imageInp.addEventListener("change" , (e)=>{
            let fileList= e.target.files;
            if(fileList.length === 1){
                let file =fileList[0];
                fileReader.readAsDataURL(file);
            }else{
                imagePrev.src = defaultSrc;
            }
        })
    </script>

    <?php
    ?>