<?php
$base = "../";
$page_title = "داشبورد";
include_once ("dashboard-template.php");

$errors = ['show_name_error'=>'','avatar_error'=>'','email_error'=>'' , 'username_error'=>'' , 'password_error'=>'', 'password_confirmation_error'=>'']; 

$db = new Database();
$user_id = Tokenize::get_token();
$user_info =$db->select_once("users" , "id = '$user_id'");

$info = [
    "show_name" => $user_info['show_name'],
    "email" => $user_info['email'],
    "username" =>$user_info['username'],
    "user_password" => $user_info['user_password'],
    "password_confirm" => "",
    "file" => $user_info['avatar']
];
if(isset($_POST['change_info'])){
    $info =[
        "show_name" => $_POST['show_name'],
        "email" => $_POST['email'],
        "username" =>$_POST['username'],
        "user_password" => $_POST['password'],
        "password_confirm" => $_POST['password-confirm'],
        "file" => $_FILES['user_avatar']
    ];
    $user = new User();
    $user->update($user_id ,$info);
    $errors = $user->get_errors();
    if(!array_filter($errors)){
        header("Location: ../dashboard/index.php");
    }
}

?>
<div class="form-box setting-form">

    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method = "POST" enctype="multipart/form-data">
        <div class="form">
            <h2>تنظیمات حساب کاربری</h2>
            <div class="user-avatar">
                <div class="image-input">
                    <input type="file" name="user_avatar" id="file-input" accept=".jpg , .png">
                    <label for="file-input"><img src="../media/avatar/<?php echo $user_info['avatar'];?>" id="image-prev" alt=""></label>
                </div>
                <span><?php echo $errors['avatar_error'];?></span>
            </div>
            <div class="input-box">
                <input type="text" name="show_name" id="show_name" value="<?php echo $info['show_name']?>" required>
                <label for="show_name">نام نمایشی</label>
                <span><?php echo $errors['show_name_error'];?></span>
            </div>
            <div class="input-box">
                <input type="text" name="username" id="username" value="<?php echo $info['username'];?>" required>
                <label for="username">نام کاربری</label>
                <span><?php echo $errors['username_error'];?></span>
            </div>
            <div class="input-box">
                <input type="email" name="email" id="email" value="<?php echo $info['email'];?>" required>
                <label for="email">ایمیل</label>
                <span><?php echo $errors['email_error'];?></span>
            </div>
            <div class="input-box">
                <input type="password" name="password" id="password" required>
                <label for="password">گذرواژه</label>
                <i class="fi fi-rr-eye" id="hide-password"></i>
                <span><?php echo $errors['password_error'];?></span>
            </div>
            <div class="input-box">
                <input type="password" name="password-confirm" id="repeat_password" required>
                <label for="repeat_password">تکرار گذرواژه</label>
                <span><?php echo $errors['password_confirmation_error'];?></span>
            </div>

            <div class="send-option">
                <div></div>
                <input class="btn" type="submit" value="ذخیره تغییرات" name="change_info">
            </div>
        </div>
    </form>
    
</div>
<script>
    activeMenuLink("setting-link");

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