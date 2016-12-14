<?php

namespace App\Model;

use App\Lib\Response;

class ServiciosModel {

    private $db;
    private $table = 'servicios';
    private $response;

    public function __construct($db) {
        $this->db = $db;
        $this->response = new Response();
    }

    public function getListarCategoriasServicio() {
        return $this->db->from('servicios_tipos')
                        ->fetchAll();
    }
    
    public function getMyServicesActives($id_user) {
        $fecha = date('Y-m-d');
        return $this->db->from($this->table)
                        ->leftJoin('servicios_tipos on servicios_tipos.servicios_tipos_id = servicios.servicio_cat_id')->select('servicios_tipos.servicios_tipos_title')
                        ->orderBy('servicio_id DESC')
                        ->where(['servicio_status_id' => 1, 'servicio_empleado_id' => $id_user])
                        ->fetchAll();
    }

    public function setActualizarServicio($data,$id) {
        $this->db->update($this->table, $data)
                ->where('servicio_id', $id)
                ->execute();
        return $this->response->SetResponse(true);
    }
    
    public function setCrearServicio($data) {
        
        $this->db->insert($this->table, $data)
                ->execute();
        return $this->response->SetResponse(true);
    }

    public function getServicio($id, $id_user) {
        return $this->db->from($this->table)
                        ->leftJoin('servicios_tipos on servicios_tipos.servicios_tipos_id = servicios.servicio_cat_id')->select('servicios_tipos.servicios_tipos_title')
                        ->where(['servicio_id' => $id, 'servicio_empleado_id' => $id_user])
                        ->fetch();
    }

}
