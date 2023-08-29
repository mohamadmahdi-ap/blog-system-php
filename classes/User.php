<?php
class User {
    protected $dbs;
    protected $valid;
    protected $like;
    protected $upload;
    private  $errors = ['show_name_error'=>'' ,'email_error'=>'' , 'username_error'=>'' , 'password_error'=>'' , 'password_confirmation_error'=>'' , 'avatar_error'=>''];
    public function __construct() {
        $this->dbs = new Database();
        $this->valid = new Validation();
        $this->upload = new Upload();
        $this->like = new Like();
    }//OK

    public function getAll($columns="*") {
        $users = $this->dbs->all('users', $columns);
        return $users;
    }//OK

    public function create($formData) {
        $formData = Sanitizer::sanitize($formData);

        $email = $formData['email'];
        $this->errors['email_error'] = $this->valid->validation_email($email , "register");

        $username = $formData['username'];
        $this->errors['username_error'] = $this->valid->validation_username($username , "register");

        $password = $formData['user_password'];
        $this->errors['password_error'] = $this->valid->validation_password($password , "");
        
        if(isset($formData['password_confirm'])){
            $password_confirmation = $formData['password_confirm'];
            $this->errors['password_confirmation_error'] = $this->valid->confirm_password($password , $password_confirmation);
        }

        if(!isset($formData['file']) or $formData['file']['name'] == ''){
            $avatar = 'user.png';
        }else{
            $this->errors['avatar_error']=$this->upload->check_file($formData['file']);
            $avatar = $this->upload->get_name();
        }
        if(!isset($formData['show_name']) or $formData['show_name'] == ''){
            $show_name = 'کاربر سایت';
        }else{
            $show_name = $formData['show_name'];
            $this->errors['show_name_error'] = $this->valid->validation_text($show_name);
        }

        if(!array_filter($this->errors)){
            
            if($avatar != 'user.png'){
                $avatar = $this->upload->upload($formData['file'] , "avatar");
            }

            $data = [
                "show_name" => $show_name,
                "email" => $email,
                "username" => $username,
                "user_password" => $password,
                "avatar" => $avatar
            ];

            $this->dbs->insert('users', $data);
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

     public function update($id, $formData) {

        $formData = Sanitizer::sanitize($formData);

        if($id ==1 and Tokenize::get_token() != 1){
            return false;
        }
        $email = $formData['email'];
        $this->errors['email_error'] = $this->valid->validation_email($email , "edit" , $id);

        $username = $formData['username'];
        $this->errors['username_error'] = $this->valid->validation_username($username , "edit" , $id);

        $password = $formData['user_password'];
        $this->errors['password_error'] = $this->valid->validation_password($password , "");
        
        if(isset($formData['password_confirm'])){
            $password_confirmation = $formData['password_confirm'];
            $this->errors['password_confirmation_error'] = $this->valid->confirm_password($password , $password_confirmation);
        }

        if(!isset($formData['file']) or $formData['file']['name'] == ''){
            $avatar = 'user.png';
        }else{
            $this->errors['avatar_error']=$this->upload->check_file($formData['file']);
            $avatar = $this->upload->get_name();
        }
        if(!isset($formData['show_name']) or $formData['show_name'] == ''){
            $show_name = 'کاربر سایت';
        }else{
            $show_name = $formData['show_name'];
            $this->errors['show_name_error'] = $this->valid->validation_text($show_name);
        }
        
        if(!array_filter($this->errors)){
            
            $old_avatar = $this->dbs->select_once("users" , "id = '$id' " , "avatar")['avatar'];
            if($old_avatar != 'user.png'){
                $this->upload->delete("../media/avatar/".$old_avatar);
            }
            if($avatar != 'user.png'){
                $this->upload->upload($formData['file'] , "avatar");
            }

            $data = [
                "show_name" => $show_name,
                "email" => $email,
                "username" => $username,
                "user_password" => $password,
                "avatar" => $avatar
            ];

            $this->dbs->update('users', $data, "id = '$id'");
        }

    }

    public function delete($id) {
        $id = Sanitizer::sanitize($id);
        if($id==1 or $id==''){
            return false;
        }

        if($this->get_role(Tokenize::get_token()) !=1){
            return false;
        }
        
        $user_information = $this->dbs->select_once("users" , "id = '$id'");
        if(empty($user_information)){
            return false;
        }
        // delete avatar
        if($user_information['avatar'] != 'user.png'){
            $this->upload->delete("../media/avatar/".$user_information['avatar']);
        }
        // delete posts
        $user_posts = new Post();
        $user_posts->delete_author_posts($id);
        // dislike posts 
        $liked_posts_list = $this->dbs->get_list("likes" , "user_id='$id'" , "post_id");
        if($liked_posts_list){
            $this->like->dislike_posts($liked_posts_list , $id);
        }
  
        $this->dbs->delete('users', "id = '$id'");


    }

    public function change_role($user_id){
        $user_id = Sanitizer::sanitize($user_id);
        if($user_id==1){
            return false;
        }
        $role = $this->get_role($user_id);
        $data = ["user_role" => ($role==0)?1:0 ];
        $this->dbs->update('users', $data , "id = '$user_id'" );
    }

    public function getUser($id , $columns = "*") {
        $user = $this->dbs->select_once('users', "id = '$id'" , $columns);
        return $user;

    }

    public function get_role($id){
        $id = Sanitizer::sanitize($id);
        $user_info = $this->dbs->select_once("users","id ='$id'" , "user_role");
        return $user_info['user_role'];
    }

}