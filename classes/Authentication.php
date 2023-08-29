<?php
class Auth {
    protected $dbs;
    protected $valid;
    private $errors = ['email_error'=>'' , 'username_error'=>'' , 'password_error'=>''];
    public function __construct(){
        $this->dbs = new Database();
        $this->valid = new Validation();
    }
    //Method for register user in system
    public function register($formData){
        $user = new User();
        $user->create($formData);
        $this->errors = $user->get_errors();

        if(!array_filter($this->errors)){

            $token = $this->dbs->select_once("users" , "username = '$formData[username]'" ,"id");
            Tokenize::generate($token['id']);
            header("Location: ../dashboard/");

        }
    }
    // Method for login existing user in system
    public function login($formData){
        // check form data validation
        $this->errors['username_error'] = $this->valid->validation_username($formData['username'] , "login");
        $this->errors['password_error'] = $this->valid->validation_password($formData['user_password'] , "login");
        if(!array_filter($this->errors)){
             
            $token = $this->valid->get_id();
            Tokenize::generate($token);
            header("Location: ../dashboard/");
                
            }
    }
    public function get_errors(){
        return $this->errors;
    }
    public static function logout() {
        Tokenize::remove_token();
        header("Location:  ../index.php");
    }
}