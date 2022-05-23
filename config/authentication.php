<?php

require $_SERVER['DOCUMENT_ROOT'].'/php_rest/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Authentication {

    public function validate_token (){
        try {
            $token = str_replace('Bearer ', '', apache_request_headers()['Authorization']??null);
            JWT::decode($token, new key  ('dykwim', 'HS256'));
            return true;
        }
        catch(\Exception $e){
            return false;
        }
    }
}

?>