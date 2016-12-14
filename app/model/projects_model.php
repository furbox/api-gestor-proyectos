<?php

namespace App\Model;

use App\Lib\Response,
    App\Lib\Auth;

class ProjectsModel {

    private $db;
    private $table = 'projects';
    private $response;

    public function __CONSTRUCT($db) {
        $this->db = $db;
        $this->response = new Response();
    }

    public function getProject($id){
          return $this->db->from($this->table.' p')
                          ->innerJoin('users uo on uo.id = p.project_user_owner_id')
                          ->select('p.*,uo.*')
                          ->where(['p.project_id' => $id])
                          ->fetch();
    }
    public function getAllProjects(){
        return $this->db->from($this->table.' p')
                        ->innerJoin('users uo on uo.id = p.project_user_owner_id')
                        ->select('p.*,uo.*')
                        ->fetchAll();
    }
}
