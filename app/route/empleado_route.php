<?php

use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;

$app->group('/empleado/', function () {
    $this->get('obtener/{id}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                        ->write(json_encode($this->model->empleado->getEmpleado($args['id'])));
    });

    $this->get('listar', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                        ->write(json_encode($this->model->empleado->getAll()));
    });

    $this->post('guardarCambios', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                        ->write(json_encode($this->model->empleado->update($req->getParsedBody())));
    });
});
