<?php
class Like{
    private $dbs;
    public function __construct(){
        $this->dbs = new Database;
    }
    public function like($post_id , $user_id){
        
        $post_id = Sanitizer::sanitize($post_id);
        $user_id = Sanitizer::sanitize($user_id);

        if($this->wasLiked($post_id ,$user_id)){
            $this->dbs->insert("likes" , [ "user_id" => "$user_id", "post_id" => "$post_id"]);
            $this->changeLikesCount($post_id , 1);
        }else{
            $this->dbs->delete("likes" , "user_id = '$user_id' AND post_id='$post_id'");
            $this->changeLikesCount($post_id , -1);
        }
        
    }
    public function wasLiked($post_id , $user_id){
        $like = $this->dbs->select_once("likes" , "user_id = '$user_id' AND post_id='$post_id'");
        return empty($like);
    }
    public function changeLikesCount($post_id , $i){
        $post_likes = $this->dbs->select_once("posts" , "id = '$post_id'" ,"likes");
        $likes = $post_likes['likes'] + $i;
        $this->dbs->update("posts", ["likes" => $likes] , "id = '$post_id'");
        
    }
    public function dislike_posts($list , $user_id){
        $list = Sanitizer::sanitize($list);
        $user_id = Sanitizer::sanitize($user_id);
        $liked_list = "(".implode("," , $list).")";
        $this->dbs->delete("likes" , "user_id = '$user_id' AND post_id IN $liked_list");
        foreach($list as $l){
            $this->changeLikesCount($l , -1);
        }
    }
    // Method for delete al likes for a post
    public function delete_post_likes($post_id){
        $this->dbs->delete("likes" , "post_id = '$post_id'");
    }
}