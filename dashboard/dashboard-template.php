<?php 
require_once($base."configs/config.php");
 
if(isset($_GET['logout'])){
    Auth::logout();
}else{

    if(Tokenize::validate_token()){

        // $db = new Database;
        $user_id = Tokenize::get_token();
        $user = new User();
        $user_info = $user->getUser($user_id);

        include ($base."template/header.php");

    }else{
        header("Location: ../pages/login.php");
    }
}
?>

<main>
    <div class="dashboard-container">
        <div class="dashboard-menu">
            <div class="d-menu">

                <a id="dashboard-link" href="index.php"> <i class="fi fi-sr-apps"></i> <span>داشبورد</span></a>
                <a href="../pages/create-post.php"><i class="fi fi-sr-add"></i> <span>ایجاد پست</span></a>
                <!-- admin menu -->
                <?php if($user_info["user_role"] == 1){?>
                    <a id="manage-users-link" href="manage-users.php"><i class="fi fi-sr-users"></i> <span>مدیریت کاربران</span></a>
                    <a id="manage-posts-link" href="manage-posts.php"><i class="fi fi-sr-blog-text"></i> <span>مدیریت پست ها</span></a>
                    <a id="manage-categories-link" href="manage-categories.php"><i class="fi fi-sr-duplicate"></i> <span>مدیریت دسته بندی ها</span></a>
                <?php }?>
                <a id="myposts-link" href="myposts.php"><i class="fi fi-sr-poll-h"></i> <span>پست های من</span></a>
                <a id="favorite-posts-link" href="favorite-posts.php"><i class="fi fi-sr-heart"></i> <span>پست های مورد علاقه</span></a>
                <a id="setting-link" href="setting.php"><i class="fi fi fi-sr-settings"></i> <span>تنظیمات حساب کاربری</span></a>
                <a id="" href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?logout";?>"><i class="fi fi fi-rr-exit"></i> <span>خروج</span></a>
            </div>
            <script>
                function activeMenuLink(id){
                    document.getElementById(id).classList.add("active-dashboard-link");
                }
            </script>
        </div>
<?php
?>