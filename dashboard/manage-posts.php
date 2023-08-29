<?php
$base = "../";
$page_title = "مدیریت پست ها";

require_once "../configs/config.php";
require_once "../functions/functons.php";

$user= new User();
if($user->get_role(Tokenize::get_token()) ==1){
    $post = new Post();
    $all_posts = $post->getAll('confirmation' , ["id != 0"]);
    
    $cat = new Category();
    $categories = $cat->getAll("id , title");
    $users = $user->getAll("id , show_name");

    if(isset($_GET['delete_post'])){
        $delete_post_id = htmlspecialchars($_GET['delete_post']);
        $post->delete($delete_post_id);
        go_back();
    }
    if(isset($_GET['confirm_post'])){
        $confirmed_post_id = htmlspecialchars($_GET['confirm_post']);
        $post->change_post_confirmation($confirmed_post_id , 1);
        go_back();
    }
    if(isset($_GET['reject_post'])){
        $rejected_post_id = htmlspecialchars($_GET['reject_post']);
        $post->change_post_confirmation($rejected_post_id , 2);
        go_back();
    }

}else{
    header("Location: ../pages/error404.php");
}
include ("dashboard-template.php");


?>
        <div class="dashboard-content table-content">
            <div class="manage-title">
                <h3>مدیریت پست ها</h3>
            </div>
            <table class="info-table">
                <thead>
                    <tr>
                        <th>شماره</th>
                        <th>شناسه</th>
                        <th>عنوان</th>
                        <th>بنر</th>
                        <th>متن</th>
                        <th>دسته بندی</th>
                        <th>نویسنده</th>
                        <th>تاریخ</th>
                        <th>مشاهده</th>
                        <th>وضعیت</th>
                        <th>حذف</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach($all_posts as $post){?>
                    <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo $post['id']?></td>
                        <td><?php echo $post['title']?></td>
                        <td><img src="<?php echo $base.'media/posts/'.$post['banner']?>" alt="post" class="post-banner"></td>
                        <td class="table-ellipsis"><span><?php echo $post['content']?></span></td>

                        <td><a href="../pages/category.php?id=<?php echo $post['category_id']?>"><?php echo find_with_id($categories , $post['category_id'] , 'title') ;?></a></td>

                        <td><a href="<?php echo '../pages/user-posts.php?id='.$post['author_id'];?>"><?php echo find_with_id($users , $post['author_id'] , 'show_name') ;?></a></td>
                        
                        <td><?php echo change_date($post['create_at']);?></td>
                        
                        <td><a href="../pages/post.php?id=<?php echo $post['id']?>"><i class="fi fi-sr-eye"></i></a></td>
                        
                        <td><?php echo ($post['confirmation'] == 1) ? "<i class='fi fi-sr-check-circle' style='color: #0db60d;'>" : (($post['confirmation'] == 2) ? "<i class='fi fi-sr-vote-nay' style='color: #da0d0d;'></i>" : "<a href='{$_SERVER['PHP_SELF']}?confirm_post={$post['id']}'><i class='fi fi-sr-check-circle'></i></a> / <a href='{$_SERVER['PHP_SELF']}?reject_post={$post['id']}'><i class='fi fi-sr-vote-nay'></i></a>") ?></td>
                        
                        <td><a href="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])."?delete_post=".$post['id']?>"><i class="fi fi-rr-trash"></i></a></td>
                    </tr>
                    <?php }?>

                </tbody>
            </table>
            
        </div>
    </div>
</main>
<script>
    activeMenuLink("manage-posts-link");
</script>