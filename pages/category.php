<?php 
$base = "../";



if(isset($_GET['id'])){
    $category_id = htmlspecialchars($_GET["id"]);
    
    require_once("../configs/config.php"); 
    $cat = new Category();
    $category_details = $cat->get_category($category_id);
    if(!empty($category_details)){
   
        $post = new Post();
        $filter =(isset($_COOKIE['filter']))?$_COOKIE['filter']:'';
        $condition = ["category_id = '$category_id'" , "confirmation = '1'"];
        $all_posts= $post->getAll($filter , $condition);
        
        $user = new User();
        $authors = $user->getAll(" id , avatar , show_name");
    }else{
        header("Location: ../pages/error404.php");
    }
    
}else{
    header("Location: ../pages/error404.php");
}


$page_title = "پست های دسته  $category_details[title]";
include($base."template/header.php");
?>

<main>

    <div class="category-banner-sec">
        <img src="<?php echo $base."media/category/".$category_details["banner"];?>" alt="<?php echo $category_details["title"];?>">
        <div class="category-details">
            <h2><?php echo $category_details["title"];?></h2>
            <p><?php echo $category_details["description"];?></p>
        </div>
    </div>

    <div class="container">
            <div class="head-of-box">
                <h2 class="link">همه پست ها</h2>
                <div class="input-box filter">
                    <select name="category" id="category" onchange="changeFilter(value)">
                        <option value="defualt" <?php if (!isset($_COOKIE['filter']) or $_COOKIE['filter'] == "defualt") {echo "selected";} else; ?>>پیشفرض</option>
                        <option value="newest" <?php if (isset($_COOKIE['filter']) and $_COOKIE['filter'] == "newest") {echo "selected";} else; ?>>جدیدترین</option>
                        <option value="view" <?php if (isset($_COOKIE['filter']) and $_COOKIE['filter'] == "view") {echo "selected";} else; ?>>پربازدیدترین</option>
                        <option value="popular" <?php if (isset($_COOKIE['filter']) and $_COOKIE['filter'] == "popular") {echo "selected";}; ?>>محبوب ترین</option>
                    </select>
                </div>
            </div>
            <script>

                let options = document.querySelectorAll("option");
                options.forEach((e)=>{})

            </script>
            <section class="posts">
                <?php foreach($all_posts as $post){?>
                <div class="post">
                    <img src="<?php echo $base."media/posts/".$post['banner'];?>" alt="<?php echo $post['title'];?>">
                    <div class="details-sec">
                        <div class="details">
                            <div class="post-title">
                                <h3><?php echo $post['title'];?></h3>
                            </div>
                            <div class="post-content-text">
                                <p class="text"><?php echo $post['content'];?></p>
                            </div>
                            <div class="info">
                                <img src="<?php echo $base."media/avatar/".find_with_id($authors , $post["author_id"] , "avatar");?>" alt="">
                                <div>
                                    <a href="<?php echo $base."pages/user-posts.php?id=".$post["author_id"]?>"><?php echo find_with_id($authors , $post["author_id"] , "show_name");?></a>
                                    <div class="date"><?php echo change_date($post['create_at']) ;?></div>
                                </div>
                                <div class="likes">
                                    <span><?php echo $post['likes'];?></span>
                                    <i class="fi fi-sr-heart"></i>
                                </div>
                                <div class="view">
                                    <span><?php echo $post['view'];?></span>
                                    <i class="fi fi-sr-eye"></i>
                                </div>

                            </div>
                        </div>
                        <div class="see-post">
                            <a href="<?php echo $base."pages/post.php?id=".$post['id'];?>">مشاهده</a>
                        </div>
                    </div>

                </div>
                <?php }?>

            </section>
    </div>
</main>
<script>
    function changeFilter(value){
        setCookie("filter" , value);
        location.reload();
    }
</script>

<?php
include($base."template/footer.php");
?>

