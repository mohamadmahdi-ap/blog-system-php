<?php

$base= "../";
require_once($base."configs/config.php");

if(Tokenize::validate_token() and Tokenize::get_token() == 1){
    
    $db = new Database;
    
    $category = ["title" => "" ,"banner" => "" ,"description" => ""];
    $errors = ['title_error'=>'' ,'description_error'=>'' , 'banner_error'=>''];

    if(isset($_GET["category_id"])){
        $category_id = htmlspecialchars($_GET["category_id"]);
        $category= $db->select_once("categories" , "id = $category_id");
        $page_title = "ویرایش دسته « $category[title] »";
        $page_link = htmlspecialchars($_SERVER['PHP_SELF'])."?category_id=$category_id";
    }else{
        $page_title = "ایجاد دسته بندی جدید";
        $page_link = htmlspecialchars($_SERVER['PHP_SELF']);
    }

    if(isset($_POST['create_category'])or isset($_POST['edit_category'])){
        $category = [
            "title" => $_POST['title'] ,
            "description" =>  $_POST['description'] ,
            "file" => $_FILES['category_banner']
        ];
        $cat = new Category();
        if(isset($_POST['create_category'])){
            $cat->create($category);
        }
        if(isset($_POST['edit_category'])){
            $category_id = htmlspecialchars($_GET["category_id"]);
            $cat->update($category_id , $category);
        }
        $errors = $cat->get_errors();
        if(!array_filter($errors)){
            header("Location: ../dashboard/manage-categories.php");
        }
    }



}else{
    header("Location: ../index.php");
}




include("../template/header.php");
?>

    <main>
        <div class="form-box create-form">
            <form action="<?php echo $page_link;?>" method="POST" enctype="multipart/form-data">
                <div class="form">
                    <i class="fi fi-rr-arrow-small-left" id="return-btn" onclick="goback()"></i>
                    <h2><?php echo $page_title ; ?></h2>
                    <div class="post-banner">
                        <div class="image-input">
                            <input type="file" name="category_banner" id="file-input" accept=".jpg, .png">
                            <label for="file-input"><img src="<?php echo $base.'media/'.((isset($_GET['category_id']))?'category/'.$category['banner']:'add-photo.jpg');?>" id="image-prev" alt=""></label>
                        </div>
                        <span class="span-alert"><?php echo $errors['banner_error']?></span>
                    </div>
                    <div class="input-box">
                        <input type="text" name="title" id="title" required value="<?php echo $category['title'];?>">
                        <label for="title">عنوان</label>
                        <span class="span-alert"><?php echo $errors['title_error']?></span>
                    </div>
                    <div class="input-box">
                        <textarea name="description" id="category-content"rows="5" required><?php echo $category['description'];?></textarea>
                        <label for="category-content">توضیحات</label>
                        <span class="span-alert"><?php echo $errors['description_error']?></span>
                    </div>
                    <input class="btn" type="submit" value="ثبت" name="<?php echo (isset($_GET['category_id'])?'edit_category':'create_category');?>">
                    
                </div>
            </form>
        </div>
    </main>
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
    </script>

    <?php
    ?>