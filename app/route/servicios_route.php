<?php
use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;

$app->group('/servicios/', function () {
    $this->get('obtener/{id}/{u}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->servicios->getServicio($args['id'],$args['u'])));
    });
    
    $this->get('listar/{u}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->servicios->getMyServicesActives( $args['u'])));
    });
    
    $this->put('actualizar/{id}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->servicios->setActualizarServicio($req->getParsedBody(),$args['id'])));
    });
    $this->post('agregar', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->servicios->setCrearServicio($req->getParsedBody())));
    });
    $this->get('listar_categorias', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                   ->write(json_encode($this->model->servicios->getListarCategoriasServicio()));
    });
});