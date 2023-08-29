<?php 
class Validation{
    private $dbs;
    protected $id;
    public function __construct(){
        $this->dbs = new Database;
    }
    public function validation_email($email , $mode="register" , $user_id=""){
        $email = Sanitizer::sanitize($email);
        if(empty($email)){
            return 'لطفا ایمیل را وارد نمایید!';
        }else if(!filter_var($email , FILTER_VALIDATE_EMAIL)){
            return 'ایمیل نامعتبر است!';
        }else{
            if($mode == "register"){
                $exist_account = $this->dbs->select_once("users" , "email = '$email'" , "id");
            }else if($mode == "edit"){
                $exist_account = $this->dbs->select_once("users" , "email = '$email' AND id != '$user_id'" , "id");
            }

            if(!empty($exist_account)){
                return 'این ایمیل قبلا ثبت نام کرده است!';
            }

        }
    }
    public function validation_username($username , $mode="register" , $user_id=""){
        $username = Sanitizer::sanitize($username);
        if(empty($username)){
            return 'لطفا نام کاربری را وارد نمایید!';
        }else if(!preg_match('/^[a-z A-Z][a-z A-Z 0-9 _ -]{3,11}$/',$username)){
            return 'شروع با حرف و تنها شامل حروف انگلیسی و اعداد و _ و - و بین 4 تا 12 کاراکتر!';
        }else{
            if($mode == "login"){
                $exist_account = $this->dbs->select_once("users" , "username = '$username'" , "id");
                if(empty($exist_account)){
                    return 'این حساب وجود ندارد! ثبت نام کنید.';
                }
                $this->id = $exist_account['id'];

            }else{
                if($mode == "register"){
                    $exist_account = $this->dbs->select_once("users" , "username = '$username'" , "id");
                }else if($mode == "edit"){
                    $exist_account = $this->dbs->select_once("users" , "username = '$username' AND id != '$user_id'" , "id");
                }
                if(!empty($exist_account)){
                    return 'این ایمیل قبلا ثبت نام کرده است!';
                }
            }
        }
    }
    public function validation_password($password , $mode = ""){
        $password = Sanitizer::sanitize($password);
        if(empty($password)){
            return 'لطفا گذرواژه خود را وارد نمایید!';
        }else if(!preg_match('/^[a-z A-Z 0-9]{4,16}$/',$password)){
            return 'تنها شامل حروف انگلیسی و اعداد و بین 4 تا 16 کاراکتر!';
        }else if($mode == "login"){
            if($this->id != ''){

                $corrent_password = $this->dbs->select_once("users" , "id = '{$this->id}'" , "user_password");
                if(empty($corrent_password) or $password != $corrent_password['user_password']){
                    return 'گذرواژه اشتباه است!';
                }

            }
        }
    }
    public function confirm_password($password , $confirm_password){
        $password =Sanitizer::sanitize($password);
        $confirm_password =Sanitizer::sanitize($confirm_password);
        if($password != $confirm_password){
            return "تکرار گذرواژه صحیح نیست!";
        }
    }
    public function validation_text($text){
        $text =Sanitizer::sanitize($text);
        if(empty($text)){
            return "چیزی وارد کنید!";
        }
    }
    public function validation_category($category_id){
        $text =Sanitizer::sanitize($category_id);
        if(empty($category_id)){
            return "لطفا دسته بندی را انتخاب کنید!";
        }else{
            $cat = new Category() ;
            $all_categories = $cat->all_id();
            if(empty($all_categories) or !in_array($category_id , $all_categories)){
                return "دسته بندی نامعتبر است!";
            }
        }
    }
    public function get_id(){
        return $this->id;
    }

}