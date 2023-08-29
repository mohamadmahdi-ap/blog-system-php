<?php 
$base = "../";
$page_title= "تماس با ما";
include($base."template/header.php");
?>
<main>
    <div class="post-content-box">
        <div class="post-container">
            <div class="post-content">
                <div class="post-title head-of-box">
                    <h2>ارتباط ما</h2>
                </div>
                <p>
                لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ، و با استفاده از طراحان گرافیک است، چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است، و برای شرایط فعلی تکنولوژی مورد نیاز، و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد، کتابهای زیادی در شصت و سه درصد گذشته حال و آینده، شناخت فراوان جامعه و متخصصان را می طلبد، تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی، و فرهنگ پیشرو در زبان فارسی ایجاد کرد. 
                </p>
                <div class="contact-ways" style="display: flex; justify-content: space-around; flex-wrap: wrap;">
                    <div>
                        <i class="fi fi-rr-phone-call"></i>
                        <a href="tel:09111111111">09111111111</a>
                    </div>
                    <div>
                        <i class="fi fi-rr-envelope"></i>
                        <a href="mailto:example@gmail.com">example@gmail.com</a>
                    </div>
                    <div>
                        <i class="fi fi-rr-marker"></i>
                        <a href="#"> ایران ، تهران</a>
                    </div>
                </div>
                <img src="<?php echo $base."media/contact-us.svg"?>" alt="about-us" class="content-banner">
            </div>
        </div>
    </div>
</main>
<div class="map">
        <iframe width="100%" height="400" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?width=100%25&amp;height=400&amp;hl=en&amp;q=iran%20tehran%20azadi%20sq+(tehran)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"><a href="https://www.maps.ie/population/">Population calculator map</a></iframe>
</div>
<?php
include($base."template/footer.php");

?>

