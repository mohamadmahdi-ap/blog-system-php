<?php
class Post {
    protected $dbs;
    protected $valid;
    protected $file;
    protected $user;
    const DEFAULT_BANNER = "post-default.png";
    private $errors = ['title_error'=>'' ,'category_error'=>'' , 'content_error'=>'' , 'banner_error'=>'' , 'terms_error'=>''];
    public function __construct() {
        $this->dbs = new Database();
        $this->valid = new Validation();
        $this->file = new Upload();
        $this->user = new User();
    }
    public function getAll($filter = '' , $condition= []){
        $filter = Sanitizer::sanitize($filter);
        if(!empty($condition)){
            $cond = implode(" AND " , $condition);
        }
        if(empty($condition)){
            $posts = $this->dbs->all("posts");
        }else if($filter == "newest"){
            $posts = $this->dbs->select("posts" , $cond , "*" ,"create_at" , "DESC");
        }else if($filter == "popular"){
            $posts = $this->dbs->select("posts" , $cond  , "*" ,"likes" , "DESC");
        }else if($filter == "view"){
            $posts = $this->dbs->select("posts" , $cond , "*" ,"view" , "DESC");
        }else if($filter== "confirmation"){
            $posts = $this->dbs->select("posts" , $cond , "*" ,"confirmation AND create_at" , "ASC");
        }else{
            $posts = $this->dbs->select("posts" , $cond);
        }

        return $posts;
        
    }
    public function create($formData) {
        // sanitize form data
        $formData = Sanitizer::sanitize($formData);
        // check form data validation
        $post_title = $formData['title'];
        $this->errors['title_error'] = $this->valid->validation_text($post_title);

        $post_content = $formData['content'];
        $this->errors['content_error'] = $this->valid->validation_text($post_content);

        $category_id = $formData['category'];
        $this->errors['category_error'] = $this->valid->validation_category($category_id);
        
        if(!isset($formData['file']) or $formData['file']['name'] == ''){
            $banner = self::DEFAULT_BANNER;
        }else{
            $this->errors['banner_error']=$this->file->check_file($formData['file']);
            $banner = $this->file->get_name();
        }
        
        if(!array_filter($this->errors)){
            
            if($banner != self::DEFAULT_BANNER){
                $this->file->upload($formData['file'] , "posts");
            }


            $data = [
                "title" => $post_title,
                "category_id" => ($category_id == 0)? 1 : $category_id,
                "content" => $post_content,
                "author_id" => $formData['author_id'],
                "banner" => $banner,
                "confirmation" => ($this->user->get_role($formData['author_id']) == 1)? 1 : 0
            ];

            $this->dbs->insert('posts', $data);
            /* if($result != 1) {
                Semej::set('danger', 'Error', 'Create user failed');
                header('Location: dashboard.php?page=user-create');die;
            }
    
            Semej::set('success', 'OK', 'User created successfully.');
            header('Location: dashboard.php?page=users');die; */
        }
    }
    public function get_errors(){
        return $this->errors;
    }
    public function delete($id){
        $id = Sanitizer::sanitize($id);
        if(!Tokenize::validate_token()){
            return false;
        }
        $post_info = $this->get_post($id , "author_id , banner");
        if(empty($post_info)){
            return false;
        }
        // check user validation
        if($post_info['author_id'] != Tokenize::get_token() and $this->user->get_role(Tokenize::get_token()) !=1){
            return false;
        }

        // delete banner
        if($post_info['banner'] != self::DEFAULT_BANNER){
            $this->file->delete("../media/posts/".$post_info['banner']);
        }
        // delete likes
        $like = new Like();
        $like->delete_post_likes($id);

        $this->dbs->delete("posts" , "id = '$id'");
        
        
    }
    public function get_post($id , $columns="*"){
        $post = $this->dbs->select_once("posts" , "id = '$id'" , $columns);
        return $post;
    }
    public function delete_author_posts($author_id){
        if($this->user->get_role(Tokenize::get_token()) !=1){
            return false;
        }

        $author_posts = $this->dbs->get_list("posts" , "author_id = $author_id");
        if(!empty($author_posts)){
            foreach($author_posts as $post_id){
                $this->delete($post_id);
            }
        }
        
    }
    public function change_posts_category($category_id){
        if($this->user->get_role(Tokenize::get_token()) !=1){
            return false;
        }
        $category_id = Sanitizer::sanitize($category_id);
        $this->dbs->update("posts" ,["category_id" => 1] , "category_id='$category_id'");

    }
    public function change_post_confirmation($id , $confirmation){
        $id = Sanitizer::sanitize($id);
        if(!Tokenize::validate_token() or $this->user->get_role(Tokenize::get_token()) != 1){
            return false;
        }
        $post_info = $this->get_post($id , "confirmation");
        if(empty($post_info)){
            return false;
        }
        if(in_array($confirmation , [0 , 1 , 2])){
            $this->dbs->update("posts" , ['confirmation'=>$confirmation] , "id = '$id'");
        }

    }
    public function update($id , $formData){
        // sanitize form data
        $id= Sanitizer::sanitize($id);
        $formData = Sanitizer::sanitize($formData);
        $post_info = $this->get_post($id);
        if(empty($post_info)){
            return false;
        }
        if(!Tokenize::validate_token() or ($this->user->get_role(Tokenize::get_token())!=1 and $post_info['author_id']!= Tokenize::get_token())){
            return false;
        }
        // check form data validation
        $post_title = $formData['title'];
        $this->errors['title_error'] = $this->valid->validation_text($post_title);

        $post_content = $formData['content'];
        $this->errors['content_error'] = $this->valid->validation_text($post_content);

        $category_id = $formData['category'];
        $this->errors['category_error'] = $this->valid->validation_category($category_id);
        
        if(!isset($formData['file']) or $formData['file']['name'] == ''){
            $banner = $post_info['banner'];
        }else{
            $this->errors['banner_error']=$this->file->check_file($formData['file']);
            $banner = $this->file->get_name();
        }
        
        if(!array_filter($this->errors)){
            
            if($banner != $post_info['banner'] and $banner!= self::DEFAULT_BANNER){
                $this->file->delete("../media/posts/".$post_info['banner']);
                $this->file->upload($formData['file'] , "posts");
            }

            $data = [
                "title" => $post_title,
                "category_id" => ($category_id == 0)? 1 : $category_id,
                "content" => $post_content,
                "author_id" => $formData['author_id'],
                "banner" => $banner,
                "confirmation" => ($this->user->get_role(Tokenize::get_token()) == 1)? 1 : 0
            ];

            $this->dbs->update('posts', $data ,"id ='$id'");
        }
    }
    public function increase_view($id){
        $id = Sanitizer::sanitize($id);
        $post_info = $this->get_post($id , "view");
        if(empty($post_info)){
            return false;
        }
        $view = $post_info['view']+1;
        $this->dbs->update("posts" , ["view" => $view] , "id='$id'");
    }

}