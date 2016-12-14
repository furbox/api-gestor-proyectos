<?php

use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\AuthValidation,
    App\Middleware\AuthMiddleware;

$app->group('/auth/', function () {
    $this->post('autenticar', function ($req, $res, $args) {

        //validacion de datos
        $r = AuthValidation::validate($req->getParsedBody());
        if (!$r->response) {
            return $res->withHeader('Content-type', 'application/json')
                            ->withStatus(422)
                            ->write(json_encode($r->errors));
        }
        $parametros = $req->getParsedBody();
        return $res->withHeader('Content-type', 'application/json')
                        ->write(
                                json_encode($this->model->auth->autenticar($parametros['user_email'], $parametros['user_pass']))
        );
    });
});
