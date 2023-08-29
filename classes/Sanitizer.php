<?php
class Sanitizer{
    public static function sanitize($input){
        // get type for check
        $inputType = getType($input);

        switch($inputType){
            case "string":
                $sanitizedData = trim($input);
                $sanitizedData = strip_tags($sanitizedData);
                $sanitizedData = htmlspecialchars($sanitizedData);
                $sanitizedData = filter_var($sanitizedData);
                return $sanitizedData;

            case "integer":
                $sanitizedData = filter_var($input , FILTER_SANITIZE_NUMBER_INT);
                return $sanitizedData;

            case "array":
                // check array type for check keys in assoc array
                $indexed = (array_values($input) === $input);
                $sanitizedData = [];

                foreach($input as $key => $value){
                    if($indexed){
                        $sanitizedData[] = self::sanitize($value);
                    }else{
                        $sanitizedData[self::sanitize($key)] = self::sanitize($value);
                    }
                }
                return $sanitizedData;
        }
    }
}
