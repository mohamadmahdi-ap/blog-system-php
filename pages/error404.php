<?php 
$base = "../";
$page_title= "صفحه یافت نشد!";
include($base."template/header.php");

?>

<main>

    <div class="post-content-box">
        <div class="post-container">
            <div class="post-content">
                <div style="text-align: center;">
                    <h3>صفحه یافت نشد!</h3>
                </div>
                
                <img src="<?php echo $base."media/error404.png"?>" alt="about-us" class="content-banner">

                <div style="text-align: center;">
                    <button class="btn" onclick="window.history.go(-1);">بازگشت</button>
                </div>
            </div>
        </div>
    </div>

</main>

<?php
include($base."template/footer.php");
?>

