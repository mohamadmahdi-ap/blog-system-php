<?php
$base = "../";
$page_title = "پست های من";

include ("dashboard-template.php");
$user_id = Tokenize::get_token();
$post = new Post();
$all_posts = $post->getAll('' ,["author_id = '$user_id'"]);

if(!empty($all_posts)){
    $cat = new Category();
    $categories = $cat->getAll();
}
if(isset($_GET['delete_post'])){
    $post_id = htmlspecialchars($_GET['delete_post']);
    $post->delete($post_id);
    go_back();
}
?>
<div class="dashboard-content-box">
<?php if(empty($all_posts)){?>
        <div class="dashboard-info">
            <h4>هنوز پستی ثبت نکرده اید!</h4>
        </div>
    <?php }else{?>
    <section class="posts">
            <?php foreach($all_posts as $post){?>
            <div class="post">
                <img src="<?php echo $base."media/posts/".$post['banner'];?>" alt="<?php echo $post['title'];?>">
                <div class="details-sec">
                    <div class="details">
                        <div class="post-title">
                            <h3><?php echo $post['title'];?></h3>
                                <div class="edit">
                                    <a href="edit-post.php?post_id=<?php echo $post['id'];?>"><i class="fi fi-sr-edit"></i></a>
                                </div>
                                <div class="delete">
                                    <a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?delete_post=".$post['id'];?>"><i class="fi fi-sr-trash"></i></a>
                                </div>
                        </div>
                        <div class="post-content-text">
                            <p class="text"><?php echo $post['content'];?></p>
                        </div>
                        <div>
                            <h4>دسته بندی : <a href="<?php echo $base."pages/category.php?id=".$post["category_id"]?>"><?php echo find_with_id($categories , $post["category_id"] , "title");?></a></h4>
                        </div>
                        <div class="info">
                            <div>
                                <h4>وضعیت : <?php echo (($post['confirmation']==0)?"در حال بررسی":(($post['confirmation']==1)?"تایید شده":"رد شده"));?></h4>
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
    activeMenuLink("myposts-link");
</script>