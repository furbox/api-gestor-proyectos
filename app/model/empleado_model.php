<?php

namespace App\Model;

use App\Lib\Response;

class EmpleadoModel {

    private $db;
    private $table = 'users';
    private $response;

    public function __CONSTRUCT($db) {
        $this->db = $db;
        $this->response = new Response();
    }

    public function getEmpleado($id) {
        return $this->db->from($this->table, $id)->fetch();
    }
    
    public function getAll() {
        $info = new \stdClass();
        $info->data = $this->db->from($this->table)->fetchAll();
        return $info;
    }

    public function update($data) {
        return print_r("Hola");
        
        
        //return $this->db->from($this->table)->fetchAll();
    }

}
