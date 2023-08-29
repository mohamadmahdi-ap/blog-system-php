<?php
$base = "../";
$page_title = "پست های مورد علاقه";  

include ("dashboard-template.php");
 
$like = new Like();
$db = new Database();
$liked_posts = $db->get_list("likes" , "user_id='$user_id'" , "post_id");

if($liked_posts){
    
    $liked_posts_list = "(".implode(",",$liked_posts).")";

    $favorite_posts = $db->select("posts","id IN $liked_posts_list AND confirmation = '1'");

    $user = new User();
    $authors = $user->getAll("id , avatar , show_name");

    $cat = new Category();
    $categories = $cat->getAll("id , title");

    if(isset($_GET['dislike'])){
        $dislike_id = htmlspecialchars($_GET['dislike']);
        if(in_array($dislike_id , $liked_posts)){
            $like->like($dislike_id , $user_id);
        }
        go_back();
    }
}

?>
<div class="dashboard-content-box">
    <?php if(empty($liked_posts)){?>
        <div class="dashboard-info">
            <h4>هنوز پستی را نپسندیده اید!</h4>
        </div>
    <?php }else{?>
    <section class="posts">
            <?php foreach($favorite_posts as $post){?>
            <div class="post">
                <img src="<?php echo $base."media/posts/".$post['banner'];?>" alt="<?php echo $post['title'];?>">
                <div class="details-sec">
                    <div class="details">
                        <div class="post-title">
                            <h3><?php echo $post['title'];?></h3>
                                <div class="fave">
                                    <a href="<?php echo $_SERVER['PHP_SELF']."?dislike=".$post['id'];?>"><i class="fi fi-sr-heart liked-btn" style=" font-size:25px;"></i></a>
                                </div>
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
            <?php }?>
            
        </section>
        <?php }?>
            </div>
    </div>
</main>
<script>
    activeMenuLink("favorite-posts-link");
</script>