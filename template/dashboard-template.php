<?php 
/*     require_once "../classes/Tokenize.php";
    if(isset($_GET['logout'])){
    require_once "../classes/Tokenize.php";
    Auth::logout();
}
if(Tokenize::validate_token()){
    require_once "../classes/Database.php";
    echo Tokenize::validate_token();
    $db = new Database;
    $user_id = Tokenize::get_token();
    $user_info =$db->select_once("users" , "id = '$user_id'");
}else{
    header("Location: ../index.php");
} */
?>

<main>
    <div class="dashboard-container">
        <div class="dashboard-menu">
            <div class="d-menu">

                <a href="index.php"> <i class="fi fi-sr-apps"></i> <span>داشبورد</span></a>
                <a href="../pages/create-post.php"><i class="fi fi-sr-add"></i> <span>ایجاد پست</span></a>
                <!-- admin menu -->
                <?php if($user_info["user_role"] == 1){?>
                    <a href="manage-users.php"><i class="fi fi-sr-users"></i> <span>مدیریت کاربران</span></a>
                    <a href="manage-posts.php"><i class="fi fi-sr-blog-text"></i> <span>مدیریت پست ها</span></a>
                    <a href="manage-categories.php"><i class="fi fi-sr-duplicate"></i> <span>مدیریت دسته بندی ها</span></a>
                <?php }?>

                <a href="myposts.php"><i class="fi fi-sr-poll-h"></i> <span>پست های من</span></a>
                <a href="favorite-posts.php"><i class="fi fi-sr-heart"></i> <span>پست های مورد علاقه</span></a>
                <a href="setting.php"><i class="fi fi fi-sr-settings"></i> <span>تنظیمات حساب کاربری</span></a>
                <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?logout";?>"><i class="fi fi fi-rr-exit"></i> <span>خروج</span></a>
            </div>
        </div>
<?php

?>