<?php
require_once($base."functions/functons.php");
require_once($base."configs/config.php");
?>
<!DOCTYPE html>
<html lang="fa-IR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?php echo $base;?>/media/favicon.png">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-solid-rounded/css/uicons-solid-rounded.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/uicons-brands/css/uicons-brands.css'>
    <link rel="stylesheet" href="<?php echo $base;?>styles/fonts/fonts.css">
    <link rel="stylesheet" href="<?php echo $base;?>styles/style.css">
    <link rel="stylesheet" href="<?php echo $base;?>styles/form-style.css">
    <link rel="stylesheet" href="<?php echo $base;?>styles/post-style.css">
    <link rel="stylesheet" href="<?php echo $base;?>styles/dashboard-style.css">
    <title>
        <?php echo $page_title;?>
    </title>
    <script>
        //send domain name for cookies
        let domain = '<?php echo $_SERVER["HTTP_HOST"]?>';
    </script>
    <script src="<?php echo $base;?>js/cookies.js"></script>
</head>

<body>
    <script>
        //check page mode
        if (getCookie("dark_mode") == "1") {
            document.body.classList.toggle("dark-theme")
        }
    </script>
    <header>
        <div class="header">
            <div class="header-btns">
                <div class="hmb-menu">
                    <span></span>
                    <span></span>
                </div>
                <a href="<?php echo $base;?>pages/create-post.php" class="create-post"><i
                        class="fi fi-rr-square-plus"></i></a>
            </div>
            <h2><a href="<?php echo $base;?>index.php" class="logo">لوگو</a></h2>
            <nav>
                <a href="<?php echo $base;?>pages/blog.php">وبلاگ</a>
                <a href="<?php echo $base;?>pages/create-post.php">ایجاد پست</a>
                <a href="<?php echo $base;?>pages/about-us.php">درباره ما</a>
                <a href="<?php echo $base;?>pages/contact-us.php">تماس با ما</a>
            </nav>
            <div class="header-btns">
                <a href="<?php echo (Tokenize::validate_token())?"{$base}dashboard/":"{$base}pages/login.php";?>" class="account"><i class="fi fi-rr-user"></i></a>
                <i class="fi fi-rr-bulb" id="mode-toggle"></i>
            </div>
        </div>
    </header>
    
    <div class="to-top">
        &UpArrow;
    </div>

    <script>
        //responsive menu
        let hmb = document.querySelector(".hmb-menu");
        hmb.addEventListener("click", () => {
            document.querySelector("nav").classList.toggle("open-menu");
            hmb.classList.toggle("hmb-menu-open")
        })
        //sticky header
        let topBtn = document.querySelector(".to-top");
        window.addEventListener("scroll", function () {
            var header = document.querySelector("header");
            header.classList.toggle("sticky", window.scrollY > 0);
            topBtn.classList.toggle("show-top-btn", window.scrollY > 0);
        })
        //scroll to top
        topBtn.addEventListener("click", () => { window.scrollTo(0, 0) });
        //change mode
        let modeToggle = document.getElementById("mode-toggle");
        modeToggle.addEventListener("click", () => {

            if (getCookie("dark_mode") == "0") {
                changeCookie("dark_mode", "1");
            } else {
                changeCookie("dark_mode", "0");
            }
            document.body.classList.toggle("dark-theme")
        })

    </script>