<?php
class Upload {

    protected $valid_ext = ['jpg', 'png' , 'JPG' , 'PNG'];
    protected $new_name;
    private $file_error ;
    private const FILE_SIZE = 1024000;// ~ 1 MB

    public function upload($file , $type) {
        
        // create new name image.png
        $path = '../media/'.$type."/".$this->new_name;

        if(move_uploaded_file($file['tmp_name'], $path)) {
            return $this->new_name;
        }else {
            $this->file_error = 'فایل ذخیره نشد!' ;
            return $this->file_error ;
        }

    }

    public function check_file($file){
        // check ext
        $name = Sanitizer::sanitize($file['name']);

        if(empty($name)){
            $this->file_error = 'انتخاب عکس الزامی است!' ;
            return $this->file_error ;
        }
        if($file['error'] != 0){
            $this->file_error = 'فایل نامعتبر است!' ;
            return $this->file_error ;
        }
        
        $name_array = explode('.', $name);
        $ext = end($name_array);
        
        if(!in_array($ext, $this->valid_ext)) {
            $this->file_error = 'فایل باید با فرمت .jpg یا .png باشد!' ;
            return $this->file_error ;
        }
        if($file['size']> self::FILE_SIZE){
            $this->file_error = 'حجم فایل باید کمتر از یک مگابایت باشد!' ;
            return $this->file_error ;
        }

        $this-> new_name = bin2hex(random_bytes(6)).'.'.$ext;
    }

    public function get_name(){
        return $this->new_name;
    }

    public function delete($path) {
        if(file_exists($path)) {
            unlink($path);
        }
        return true;
    }
    public function get_errors(){
        return $this->file_error;
    }
}