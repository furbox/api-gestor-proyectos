<?php

namespace App\Model;

use App\Lib\Response,
    App\Lib\Auth;

class AuthModel {

    private $db;
    private $table = 'users';
    private $response;

    public function __CONSTRUCT($db) {
        $this->db = $db;
        $this->response = new Response();
    }

    public function autenticar($correo, $password) {
        $empleado = $this->db->from($this->table)
                ->where('user_email', $correo)
                ->fetch();
        if (is_object($empleado)) {
            $check_passwd = $this->check_passwd($empleado->user_pass, $empleado->user_salt, $password);
            if (!$check_passwd) {
                return $this->response->SetResponse(false, 'Datos invalidos');
            }
            $user_status = json_decode($empleado->user_status);
            $this->valida_login($user_status);
            $user_info = json_decode($empleado->user_info);

            $token = Auth::SignIn([
                        'user_id' => $empleado->id,
                        'user_name' => $user_info->user_name
            ]);
            $this->response->result = $token;
            return $this->response->SetResponse(true);
        } else {
            return $this->response->SetResponse(false, 'Datos invalidos');
        }
    }

    public function check_passwd($hash, $random_salt, $password) {
        if (password_verify($password . 'f16ecba5a2d660c0a728d9cae2b4666e8cb8459c', $hash)) {
            return TRUE;
        } else if ($hash === $this->hash_passwd($password, $random_salt)) {
            return TRUE;
        }

        return FALSE;
    }
    
    public function hash_passwd($password, $random_salt) {
        return crypt($password . 'f16ecba5a2d660c0a728d9cae2b4666e8cb8459c', '$2a$09$' . $random_salt . '$');
    }

    public function valida_login($data) {
        if (!$data) {
            return $this->response->SetResponse(false, 'Informacion no valida');
        }

        if ($data->is_delete == 1) {
            return $this->response->SetResponse(false, 'Usuario Eliminado');
        }

        if ($data->is_banned == 1) {
            return $this->response->SetResponse(false, 'Usuario Baneado');
        }

        if ($data->is_activate == 0) {
            return $this->response->SetResponse(false, 'Usuario Inactivo');
        }
    }

}
