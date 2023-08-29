<?php 
$base = "../";
$wasLiked = 0;
require_once($base."functions/functons.php");
require_once($base."configs/config.php");

if(isset($_GET["id"])){
    $post_id = htmlspecialchars($_GET["id"]);
    
    $post = new Post();
    $post_details = $post->get_post( $post_id);
    $like = new Like;
    //check post existing
    if(empty($post_details)){
            header("Location: ../pages/error404.php");
    }else{
        
        $page_title= $post_details["title"];
        $user = new User();
        $author = $user->getUser($post_details['author_id'] ,"avatar , show_name , user_role");
        $cat = new Category();
        $category = $cat->get_category($post_details['category_id'],"title");
        
        if(Tokenize::validate_token()){
            $user_role = $user->get_role(Tokenize::get_token());
            $wasLiked = !$like->wasLiked($post_id , Tokenize::get_token());
        }else{
            $user_role = 0;
        }
        // if post not confirmation , just show for author or admin
        if($post_details['confirmation'] == 1 or $user_role == 1 or Tokenize::validate_token($post_details['author_id'])){
            
            if(isset($_GET['like'])){
                // like confirmed post by registered users
                if($post_details['confirmation'] == 1 and Tokenize::validate_token()){
                    $like->like($post_id , Tokenize::get_token());
                    go_back();
                }else if($post_details['confirmation'] != 1){
                    go_back();
                }else{
                    header("Location: ../pages/login.php");
                }
            }
        
        }else{
            header("Location: ../pages/error404.php");
        }
    }
}else{
    header("Location: ../pages/error404.php");
}
include($base."template/header.php");
$link = "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]?id=$post_id";

?>


<main>


        <div class="post-content-box">
            <div class="post-container">
                <img src="<?php echo $base."media/posts/".$post_details["banner"];?>" alt="<?php echo $post_details["title"]?>">
                <div class="post-content">
                    <div class="post-title">
                        <h2><?php echo $post_details["title"]?></h2>
                        <div class="likes">
                            <span><?php echo $post_details["likes"]?></span>
                            <i class="fi fi-sr-heart"></i>
                        </div>
                        <div class="view">
                            <span><?php echo $post_details["view"]?></span>
                            <i class="fi fi-sr-eye"></i>
                        </div>
                    </div>
                    <p><?php echo $post_details["content"]?></p>
                    <div>
                        <h4>دسته بندی : <a href="<?php echo $base."pages/category.php?id=".$post_details["category_id"];?>"><?php echo $category["title"]?></a></h4>
                    </div>
                    <div class="info">
                        <img src="<?php echo $base."media/avatar/".$author["avatar"];?>" alt="">
                        <div>
                            <a href="<?php echo $base."pages/user-posts.php?id=".$post_details["author_id"];?>"><?php echo $author["show_name"];?></a>
                            <div class="date"><?php echo change_date($post_details['create_at']);?></div>
                        </div>
                        <div class="post-options">
                            <div class="like">
                                <a href="<?php echo "$_SERVER[PHP_SELF]?id=$post_id&like"?>"><i class="fi fi-sr-heart <?php echo ($wasLiked==1)?"liked-btn":"";?>"></i></a>
                            </div>
                            <div class="share">
                                <i class="fi fi-sr-share"></i>
                                <div class="post-options share-to">
                                <a href="https://telegram.me/share/url?url=<?php echo $link;?>" target="_blank">
                                    <i class="fi fi-brands-telegram"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text=<?php echo $page_title;?>&url=<?php echo $link;?>" target="_blank">
                                    <i class="fi fi-brands-twitter"></i>
                                </a>
                                <a href="https://web.whatsapp.com/send?text=<?php echo $page_title; echo $link;?>" target="_blank">
                                    <i class="fi fi-brands-whatsapp"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $link;?>" target="_blank">
                                    <i class="fi fi-brands-facebook"></i>
                                </a>
                                <a href="mailto:?subject=<?php echo $page_title;?>&body=<?php echo $link;?>" target="_blank">
                                    <i class="fi fi-sr-envelope"></i>
                                </a>
                                <a href="sms:?body=<?php echo $page_title;?> <?php echo $link;?>" target="_blank">
                                    <i class="fi fi-sr-message-sms"></i>
                                </a>
                                <div id="<?php echo $link;?>" onclick="navigator.clipboard.writeText(this.id)">
                                    <i class="fi fi-sr-copy"></i>
                                </div>
                            </div>
                        </div>
                            </div>
                            
                    </div>

                </div>

            </div>
        </div>
    </main>

<?php  
// increase view
if(!isset($_SESSION["post-".$post_id])){
    $_SESSION["post-".$post_id] = "0";
    $post->increase_view($post_id);
}

include($base."template/footer.php");

?>

