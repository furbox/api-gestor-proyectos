<?php
namespace App\Validation;

use App\Lib\Response;

class AuthValidation {
    public static function validate($data) {
        $response = new Response();

        $key = 'user_email';
        if(empty($data[$key])) {
            $response->errors[$key][] = 'Este campo es obligatorio';
        } else {
            $email_a = $data[$key];

            if(!filter_var($email_a, FILTER_VALIDATE_EMAIL)) {
                $response->errors[$key][] = 'El valor ingresado no es un correo valido';
            }
        }

        $key = 'user_pass';
        if(empty($data[$key])){
            $response->errors[$key][] = 'Este campo es obligatorio';
        }else{
            $value = $data[$key];

            if(strlen($value) < 8) {
                $response->errors[$key][] = 'Debe contener como mínimo 8 caracteres';
            }
        }

        $response->setResponse(count($response->errors) === 0);

        return $response;
    }
}
