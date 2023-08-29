<?php

$post = new Post();

$condition =["confirmation = '1'"];
$all_posts =$post->getAll('' , $condition);
$popular_posts =$post->getAll("popular" , $condition);
$most_visited_posts =$post->getAll("view" , $condition);
$newest_posts  =$post->getAll("newest" , $condition);

$user = new User();
$authors = $user->getAll(" id , avatar , show_name");

$cat = new Category();
$categories = $cat->getAll("id ,title , banner");

?>

<script>
    // change filter after choose option
    function changeFilter(value){
        setCookie("filter" , value);
        location.reload();
    }
</script>
<main>
        <div class="container">
            <div class="head-of-box">
                <h2 class="link">پست های محبوب</h2>
            </div>
            <section class="posts top-posts">
                <?php
                $i = 0;
                foreach($popular_posts as $post){
                    if($i<4){?>
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
                            <div>
                                <h4>دسته بندی : <a href="<?php echo $base."pages/category.php?id=".$post["category_id"]?>"><?php echo find_with_id($categories , $post["category_id"] , "title");?></a></h4>
                            </div>
                            <div class="info">
                                <img src="<?php echo $base."media/avatar/".find_with_id($authors , $post["author_id"] , "avatar");?>" alt="">
                                <div>
                                    <a href="<?php echo $base."pages/user-posts.php?id=".$post["author_id"]?>"><?php echo find_with_id($authors , $post["author_id"] , "show_name");?></a>
                                    <div class="date"><?php echo change_date($post['create_at']);?></div>
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
                <?php $i++;}}?>
            </section>
            <a href="pages/blog.php" class="link" onclick="changeFilter('popular')">بیشتر...</a>
            <div class="head-of-box">
                <h2 class="link">پست های پربازدید</h2>
            </div>
            <section class="posts top-posts">
                <?php
                $i = 0;
                foreach($most_visited_posts as $post){
                    if($i<4){?>
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
                            <div>
                                <h4>دسته بندی : <a href="<?php echo $base."pages/category.php?id=".$post["category_id"]?>"><?php echo find_with_id($categories , $post["category_id"] , "title");?></a></h4>
                            </div>
                            <div class="info">
                                <img src="<?php echo $base."media/avatar/".find_with_id($authors , $post["author_id"] , "avatar");?>" alt="">
                                <div>
                                    <a href="<?php echo $base."pages/user-posts.php?id=".$post["author_id"]?>"><?php echo find_with_id($authors , $post["author_id"] , "show_name");?></a>
                                    <div class="date"><?php echo change_date($post['create_at']);?></div>
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
                <?php $i++;}}?>

            </section>
            <a href="pages/blog.php" class="link" onclick="changeFilter('view')">بیشتر...</a>

            <div class="head-of-box">
                <h2 class="link">پست های جدید</h2>
            </div>
            <section class="posts top-posts">
                <?php
                $i = 0;
                foreach($newest_posts as $post){
                    if($i<4){?>
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
                            <div>
                                <h4>دسته بندی : <a href="<?php echo $base."pages/category.php?id=".$post["category_id"]?>"><?php echo find_with_id($categories , $post["category_id"] , "title");?></a></h4>
                            </div>
                            <div class="info">
                                <img src="<?php echo $base."media/avatar/".find_with_id($authors , $post["author_id"] , "avatar");?>" alt="">
                                <div>
                                    <a href="<?php echo $base."pages/user-posts.php?id=".$post["author_id"]?>"><?php echo find_with_id($authors , $post["author_id"] , "show_name");?></a>
                                    <div class="date"><?php echo change_date($post['create_at']);?></div>
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
                <?php $i++;}}?>

            </section>
            <a href="pages/blog.php" class="link" onclick="changeFilter('newest')">بیشتر...</a>
            
            <div class="head-of-box">
                <h2 class="link">دسته بندی</h2>
            </div>
            <section class="all-categories">
                
                <?php foreach($categories as $category){?>
                    <a href="<?php echo $base."pages/category.php?id=".$category["id"]?>" class="category">
                        <img src="<?php echo $base."media/category/".$category["banner"];?>" alt="<?php echo $category["title"];?>">
                        <span><?php echo $category["title"];?></span>
                    </a>
                <?php }?>
                
            </section>


        </div>
    </main>