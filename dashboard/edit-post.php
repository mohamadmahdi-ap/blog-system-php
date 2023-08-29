<?php

$base= "../";
require_once($base."configs/config.php");

$post = new Post();
$post_id = htmlspecialchars($_GET["post_id"]);
$data = $post->get_post($post_id);
$banner = $data['banner'];
$page_title = "ویرایش پست « $data[title] »";
$page_link = $_SERVER['PHP_SELF']."?post_id=".$post_id;
if(Tokenize::validate_token() and Tokenize::get_token() == $data['author_id']){

    $errors = ['title_error'=>'' ,'category_error'=>'' , 'content_error'=>'' , 'banner_error'=>'', 'terms_error'=>''];

    $cat = new Category();
    $all_categories = $cat->getAll("id , title");

    if(isset($_POST['edit_post'])){
        $data = [
            "author_id" => Tokenize::get_token(),
            "title" => $_POST['post_title'],
            "category" =>  $_POST['category_id'],
            "content" =>  $_POST['post_content'],
            "file" => $_FILES['post_banner'],
            "terms" => ''
        ];
        if(empty($_POST['terms'])){
            $errors['terms_error']='پذیرش قوانین اجباریست!';
        }else{
            $data['terms'] = $_POST['terms'];

            $post = new Post();
            $post->update($post_id , $data);
            $errors = $post->get_errors();
            if(!array_filter($errors)){
                header("Location: {$base}dashboard/myposts.php");
            }
        } 
    }
    
}else{
    require_once("../functions/functons.php");
    go_back();
}


include("../template/header.php");
?>

    <main>
        <div class="form-box create-form">
        <form action="<?php echo $page_link;?>" method="POST" enctype="multipart/form-data">
                <div class="form">
                    <i class="fi fi-rr-arrow-small-left" id="return-btn" onclick="goback()"></i>
                    <h2><?php echo $page_title;?></h2>
                    <div class="post-banner">
                        <div class="image-input">
                            <input type="file" name="post_banner" id="file-input" accept=".jpg , .png">
                            <label for="file-input"><img src="<?php echo $base;?>media/posts/<?php echo $banner;?>" id="image-prev" alt=""></label>
                        </div>
                        <span class="alert-span"><?php echo $errors['banner_error'];?></span>
                    </div>
                    <div class="input-box">
                        <input type="text" name="post_title" id="title" required value="<?php echo $data['title']?>">
                        <label for="title">عنوان</label>
                        <span class="alert-span"><?php echo $errors['title_error'];?></span>
                    </div>
                    <div class="input-box">
                        <select name="category_id" id="category">
                            <option value="0" select>دسته بندی</option>
                            <?php foreach($all_categories as $category){?>
                                <option value="<?php echo $category['id']?>"><?php echo $category['title'];?></option>
                            <?php }?>
                        </select>
                        <span class="alert-span"><?php echo $errors['category_error'];?></span>
                    </div>
                    <div class="input-box">
                        <textarea name="post_content" id="post-content"rows="5" required><?php echo $data['content'];?></textarea>
                        <label for="post-content">متن پست</label>
                        <span class="alert-span"><?php echo $errors['content_error'];?></span>
                    </div>
                    <div class="send-option">
                    <div class="remember-sec">
                        <input type="checkbox" name="terms" id="terms">
                        <label for="terms"><a onclick="showTerms()">شرایط و قوانین</a> را میپذیرم.</label>
                        <div>
                            <span class="alert-span"><?php echo $errors['terms_error'];?></span>
                        </div>
                    </div>
                    <input class="btn" type="submit" value="ویرایش" name="edit_post">
                </div>
                </div>
            </form>
        </div>
    </main>
    <div class="terms-section">
        <div class="terms-box">
            <div class="terms-div">
                <h3>شرایط و قوانین</h3>
                <i class="fi fi-rr-times-hexagon" onclick="showTerms()"></i>
            </div>
            <div>
                <ul>
                    <li>پست هایتان پس از ویرایش ابتدا توسط ادمین تایید و سپس منتشر خواهد شد.</li>
                    <li>عکس و محتوای پست هایتان نباید شامل محتوای غیر اخلاقی باشد وگرنه تایید نمیشود.</li>
                </ul>
            </div>
            <div class="terms-div">
                <div></div>
                <a class="btn" onclick="showTerms()">پذیرش</a>
            </div>
        </div>
    </div>
    <script>
        //go back
        function goback(i = -1){
            window.history.go(i);
        }
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

        // show terms box
        function showTerms(){
            document.querySelector(".terms-section").classList.toggle("active-terms-box")
        }
    </script>

    <?php
    ?>