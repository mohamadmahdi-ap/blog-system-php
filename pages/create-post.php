<?php

$base= "../";
$page_title = "ایجاد پست";
include($base."template/header.php");

if(Tokenize::validate_token()){
    $errors = ['title_error'=>'' ,'category_error'=>'' , 'content_error'=>'' , 'banner_error'=>'', 'terms_error'=>''];
    $cat = new Category();

    $all_categories = $cat->getAll("id , title");
    $data = [
            "author_id" => Tokenize::get_token(),
            "title" => "",
            "category" => 0,
            "content" => "",
            "file" => "add-photo.jpg"
        ];
        
        if(isset($_POST['create_post'])){
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
                $post->create($data);
                $errors = $post->get_errors();
                if(!array_filter($errors)){
                    header("Location: {$base}dashboard/myposts.php");
                }
            }   
    }
    
}else{
    header("Location: {$base}pages/login.php");
}


?>

    <main>
        <div class="form-box create-form">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
                <div class="form">
                    <i class="fi fi-rr-arrow-small-left" id="return-btn" onclick="goback()"></i>
                    <h2>ایجاد پست</h2>
                    <div class="post-banner">
                        <div class="image-input">
                            <input type="file" name="post_banner" id="file-input" accept=".jpg , .png">
                            <label for="file-input"><img src="<?php echo $base;?>media/add-photo.jpg" alt="" id="image-prev"></label>
                        </div>
                        <span class="alert-span"><?php echo $errors['banner_error'];?></span>
                    </div>
                    <div class="input-box">
                        <input type="text" name="post_title" id="title" value="<?php echo $data['title']?>" required>
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
                        <textarea name="post_content" id="post-content"rows="5"required><?php echo $data['content']?></textarea>
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
                        <input class="btn" type="submit" value="ثبت پست" name="create_post">
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
                    <li>برای ثبت پست ابتدا باید وارد شوید.</li>
                    <li>پست هایتان پس از تایید توسط ادمین منتشر خواهد شد.</li>
                    <li>عکس و محتوای پست هایتان نباید شامل محتوای غیر اخلاقی باشد وگرنه تایید نمیشود.</li>
                </ul>
            </div>
            <div class="terms-div">
                <div></div>
                <a class="btn" onclick="showTerms()">می پذیرم</a>
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