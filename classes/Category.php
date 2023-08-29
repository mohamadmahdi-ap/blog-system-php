<?php
class Category{
    private $dbs;
    private $valid;
    private $file;
    private $errors = ['title_error'=>'' , 'description_error'=>'' , 'banner_error'=>''];
    public function __construct(){
        $this->dbs = new Database();
        $this->valid = new Validation();
        $this->file = new Upload();
    }
    public function getAll($columns = "*"){
        $all_categories = $this->dbs->all("categories" , $columns);
        return $all_categories;
    }
    public function all_id(){
        $all_id = $this->dbs->get_list("categories","id");
        return $all_id;
    }
    public function create($formData){
        $formData = Sanitizer::sanitize($formData);

        $title = $formData['title'];
        $this->errors['title_error'] = $this->valid->validation_text($title);
        if(empty($this->errors['title_error']) and $this->check_duplicate($title)){
            $this->errors['title_error'] ="عنوان تکراری است!";
        }

        $description = $formData['description'];
        $this->errors['description_error'] = $this->valid->validation_text($description);

        $this->errors['banner_error']=$this->file->check_file($formData['file']);
        $banner = $this->file->get_name();

        if(!array_filter($this->errors)){
            $this->file->upload($formData['file'] , "category");

            $data = [
                "title" => $title,
                "description" => $description,
                "banner" => $banner 
            ];

            $this->dbs->insert("categories" , $data);
        }
        

    }
    public function get_category($id , $columns = "*"){
        $category = $this->dbs->select_once("categories" , "id = '$id'" , $columns);
        return $category;
    }
    public function update($id , $formData){
        $id = Sanitizer::sanitize($id);
        $formData = Sanitizer::sanitize($formData);

        $category_info = $this->get_category($id);
        if(empty($category_info)){
            return false;
        }

        $title = $formData['title'];
        $this->errors['title_error'] = $this->valid->validation_text($title);
        if(empty($this->errors['title_error']) and $this->check_duplicate($title , $id)){
            $this->errors['title_error'] ="عنوان تکراری است!";
        }

        $description = $formData['description'];
        $this->errors['description_error'] = $this->valid->validation_text($description);

        if(!isset($formData['file']) or $formData['file']['name'] == ''){
            $banner = $category_info['banner'];
        }else{
            $this->errors['banner_error']=$this->file->check_file($formData['file']);
            $banner = $this->file->get_name();
        }

        if(!array_filter($this->errors)){
            if($banner != $category_info['banner']){
                $this->file->delete("../media/category/".$category_info['banner']);
                $this->file->upload($formData['file'] , "category");
            }

            $data = [
                "title" => $title,
                "description" => $description,
                "banner" => $banner 
            ];

            $this->dbs->update("categories" , $data , "id= '$id'");
        }

    }
    public function delete($id){
        $id = Sanitizer::sanitize($id);
        if($id == '' or $id == 1){
            return false;
        }
        $category_info = $this->get_category($id);
        if(empty($category_info)){
            return false;
        }
        $post = new Post();
        $post->change_posts_category($id);
        // delete banner
        $this->file->delete("../media/category/".$category_info['banner']);
        $this->dbs->delete("categories" ,"id='$id'");
    }
    public function get_errors(){
        return $this->errors;
    }
    public function check_duplicate($title , $id = 0){
        $category = $this->dbs->select_once("categories" , "title = '$title' AND id!='$id'");
        return !empty($category);
    }
    
}