<?php

use App\Lib\Auth,
    App\Lib\Response,
    App\Validation\TestValidation,
    App\Middleware\AuthMiddleware;

$app->group('/conductor/', function () {
    $this->get('obtener/{id}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                        ->write(json_encode($this->model->conductor->getConductor($args['id'])));
    });

    $this->get('listar/{id}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
                        ->write(json_encode($this->model->conductor->list_orden_mudanzas($args['id'])));
    });

    //guardar chequeos
    $this->post('guardar-chequeo', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->insertChequeoPreoperativo($req->getParsedBody())));
    });

    //Info Mudanza
    /***
     * info-mudanza/{id}
     * metodo: get
     * parametros por url que envia:
     *
     * id -> INT
     *
     * responde
     * La informacion de la mudanza
     */
    $this->get('info-mudanza/{id}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->getInfoMudanza($args['id'])));
    });

    //Info Seguimiento Mudanza
    /***
     * info-seguimiento-mudanza/{id}
     * metodo: get
     * parametros por url que envia:
     *
     * id -> INT
     *
     * Responde
     * La informacion del seguimiento de una mudanza
     *
     */
    $this->get('info-seguimiento-mudanza/{id}', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->getInfoSeguimientoMudanza($args['id'])));
    });


    //inicio Mudanza
    /***
     * inicio-mudanza
     * metodo: post
     * parametros que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('inicio-mudanza', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_inicio_mudanza($req->getParsedBody())));
    });

    //cercania 1
    /***
     * cercania-1
     * metodo: post
     * parametros que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('cercania-1', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_cercania_1($req->getParsedBody())));
    });

    //llegada a
    /***
     * llegada-a
     * metodo: post
     * parametros que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('llegada-a', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_llegada_a($req->getParsedBody())));
    });

    //inicio cargue
    /***
     * inicio-cargue
     * metodo: post
     * parametros que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('inicio-cargue', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_inicio_cargue($req->getParsedBody())));
    });

    //fin cargue
    /***
     * fin-cargue
     * metodo: post
     * parametros que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('fin-cargue', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_fin_cargue($req->getParsedBody())));
    });

    //cargue Gral
    /***
     * cargue-general
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     * userfile -> FILE
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('cargue-general', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_cargue_gral($req->getParsedBody())));
    });

    //Inicio de Traslado
    /***
     * inicio-traslado
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('inicio-traslado', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_inicio_traslado($req->getParsedBody())));
    });

    //Cercania 2
    /***
     * cercania-2
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('cercania-2', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_cercania_2($req->getParsedBody())));
    });

    //Llegada b
    /***
     * llegada-b
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('llegada-b', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_llegada_b($req->getParsedBody())));
    });

    //inicio descargue
    /***
     * inicio-descargue
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     * userfile -> FILE
     * nombre_recibe -> String
     * cedula_recibe -> String
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('inicio-descargue', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_descargue($req->getParsedBody())));
    });

    //fin descargue
    /***
     * fin-descargue
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     * userfile -> FILE
     *
     * Responde:
     * true si se guardo
     * false si no se guardo
     *
     */
    $this->post('fin-descargue', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->set_fin_descargue($req->getParsedBody())));
    });

    //Guardar Imagen
    /***
     * guardar-imagen
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     * userfile -> FILE
     * descripcion -> text
     *
     */
    $this->post('guardar-imagen', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->upload_imagen($req->getParsedBody())));
    });

    //Boton de panico
    /***
     * boton-panico
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * user_id -> INT
     *
     */
    $this->post('boton-panico', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->boton_panico($req->getParsedBody())));
    });

    //Chequeo Preoperativo Gral
    /***
     * guardar-chequeo-general
     * metodo: post
     *
     * placa -> String
     * user_id -> INT
     */
    $this->post('guardar-chequeo-general', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->add_chequeo_preoperativo_gral($req->getParsedBody())));
    });

    //Reporte Incidente
    /***
     * reportar-incidente
     * metodo: post
     * parametos que recibe:
     *
     * lat -> String
     * lng -> String
     * fecha -> datetime formato; YYYY-MM-DD HH:MM:SS
     * mudanza_id -> INT
     * incidente -> check values ['trafico_denso','averia_mecanica','preligro_en_la_via']
     * message -> text
     *
     */
    $this->post('reportar-incidente', function ($req, $res, $args) {
        return $res->withHeader('Content-type', 'application/json')
            ->write(json_encode($this->model->conductor->reporar_incidente($req->getParsedBody())));
    });

});
