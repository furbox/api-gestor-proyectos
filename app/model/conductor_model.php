<?php

namespace App\Model;

use App\Lib\Response;
if (!ini_get('date.timezone')) {
    date_default_timezone_set('UTC');
}
if (!ini_get('date.timezone')) {
    date_default_timezone_set('GMT');
}
date_default_timezone_set('America/Bogota');
ini_set('date.timezone', 'America/Bogota');
class ConductorModel {

    private $db;
    private $table = 'seguimiento_mudanza';
    private $response;

    public function __CONSTRUCT($db) {
        $this->db = $db;
        $this->response = new Response();
    }

    public function list_orden_mudanzas($user_id) {
        $list_1 = $this->getOrdenByConductor($user_id);
        $list_2 = $this->getOrdenByConductor2($user_id);
        $data = new \stdClass();
        $data->ordenes = array_merge($list_1, $list_2);
        return $data;
    }

    public function getOrdenByConductor($user_id) {
        $date = date('Y-m-d');
        return $this->db->from('mudanzas m')
                        ->innerJoin('tripulaciones tri on tri.tripulacion_id = m.mudanza_tripulacion_id')
                        ->innerJoin('users u on u.id = tri.tripulacion_conductor_id')
                        ->select('m.*,tri.*,u.*')
                        ->where(['m.mudanza_date_start' => $date, 'm.mudanza_conductor_id' => 0, 'tri.tripulacion_conductor_id' => $user_id])
                        ->fetchAll();
    }

    public function getOrdenByConductor2($user_id) {
        $date = date('Y-m-d');
        return $this->db->from('mudanzas m')
                        ->select('m.*')
                        ->where(['m.mudanza_date_start' => $date, 'm.mudanza_tripulacion_id' => 0, 'm.mudanza_conductor_id' => $user_id])
                        ->fetchAll();
    }

    public function getSeguimiento($mudanza_id) {
        return $this->db->from($this->table)
                        ->where(['seguimiento_mudanza_num_mudanza' => $mudanza_id])
                        ->fetch();
    }

    public function guardar_ubicacion($id_user, $id_mudanza, $lat, $lng) {
        $localizacion = [
            "lat" => $lat,
            "lng" => $lng
        ];
        $conductor = $this->getConductor($id_user);
        $conductor_info = json_decode($conductor->user_info);
        $nombre_conductor = $conductor_info->user_name;
        $mudanza = $this->getMudanza($id_mudanza);
        if ($mudanza->mudanza_tripulacion_id > 0) {
            $trip = $this->getTripulacion($mudanza->mudanza_tripulacion_id);
            $veh = $this->getFlota($trip->tripulacion_flota_id);
            $placa_flota = $veh->vehiculo_placa;
        } else {
            $trip = json_decode($mudanza->mudanza_tripulacion);
            $placa_flota = $this->flota_placa;
        }
        $fecha = date('Y-m-d H:i:s');
        $insert = [
            "ubicacion_vehiculo" => $placa_flota,
            "ubicacion_coordenadas" => json_encode($localizacion),
            "ubicacion_conductor" => $nombre_conductor,
            "ubicacion_fecha" => $fecha
        ];
        $this->db->insertInto('ubicaciones', $insert)
                ->execute();

        return $this->response->SetResponse(true);
    }

    public function getFlota($id_flota) {
        return $this->db->from('vehiculos')
                        ->where('vehiculo_id', $id_flota)
                        ->fetch();
    }

    public function getTripulacion($id_trip) {
        return $this->db->from('tripulaciones')
                        ->where('tripulacion_id', $id_trip)
                        ->fetch();
    }

    public function getConductor($id_user) {
        return $this->db->from('users')
                        ->where('id', $id_user)
                        ->fetch();
    }

    public function getMudanza($id_mudanza) {
        return $this->db->from('mudanzas')
                        ->where('mudanza_id', $id_mudanza)
                        ->fetch();
    }

    public function insertChequeoPreoperativo($data) {
        $fecha_date = $data['fecha'];
        $access_user = $data['fecha_unix'];
        $licecia_de_conducir = $data['lic_cond'];
        $cedula_de_ciudadania = $data['cc'];
        $carnet_empresa = $data['ce'];
        $carnet_arl = $data['carl'];
        $audifonos_manos_libres = $data['aml'];
        $uniforme_dotacion = $data['uyd'];
        $chaleco_monogafas_guantes = $data['cmg'];
        $licencia_trancito = $data['lt'];
        $soat = $data['soat'];
        $revision_tecno_mecanica = $data['rtm'];
        $seguro_contractual_y_rce = $data['ssyrce'];
        $frontales_y_de_servicio = $data['fys'];
        $traseras_de_trabajo = $data['tt'];
        $direccionales_traseras_y_de_parqueo = $data['ddp'];
        $direccionales_delanteras_y_de_parqueo = $data['dtp'];
        $stop_y_senal_trasera = $data['sys'];
        $espejos_laterales = $data['el'];
        $alarma_de_retroceso = $data['adr'];
        $pito = $data['pito'];
        $freno_de_servicio = $data['fds'];
        $freno_de_emergencia = $data['fde'];
        $direccion_suspencion = $data['ds'];
        $cinturon_seguridad = $data['cds'];
        $vidrio_frontal = $data['vf'];
        $limpia_brisas = $data['lb'];
        $extintor_de_incendios = $data['edi'];
        $silleteria_tapiceria = $data['syt'];
        $indicadores = $data['indicadores'];
        $protector_valvula_de_descarga = $data['pvd'];
        $botiquin_primeros_auxilios = $data['bpa'];
        $bateria_cables = $data['byc'];
        $en_buen_estado = $data['ebe'];
        $control_fugas_hidraulicas = $data['cdfh'];
        $pasadores_suspension = $data['ps'];
        $control_de_fugas_de_aire = $data['cdfda'];
        $grapas_y_anclajes_de_chasis = $data['gyadc'];
        $cadena_del_cardan = $data['cdc'];
        $mangueras = $data['mangueras'];
        $motor = $data['motor'];
        $estado_gral_del_tanque = $data['egdt'];
        $soporte_del_tanque = $data['sdt'];
        $instalacion_de_puesta_a_tierra = $data['idpat'];
        $tanque_de_combustible = $data['tdc'];
        $kit_carretera = $data['kitc'];
        $motor_de_bomba = $data['mdb'];
        $kit_ambiental = $data['kita'];
        $observaciones = $data['message'];
        $check_list = [
            [
                "nombre" => "Licencia de conducción",
                "status" => $licecia_de_conducir == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Cedula de ciudadanía",
                "status" => $cedula_de_ciudadania == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Carnet empresa",
                "status" => $carnet_empresa == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Carnet ARL",
                "status" => $carnet_arl == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Audífono manos libres",
                "status" => $audifonos_manos_libres == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Uniforme y dotación",
                "status" => $uniforme_dotacion == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Chaleco, monogafas, guantes",
                "status" => $chaleco_monogafas_guantes == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Licencia de transito",
                "status" => $licencia_trancito == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Soat",
                "status" => $soat == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Revisión tecno-mecánica",
                "status" => $revision_tecno_mecanica == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Seguro contractual y rce",
                "status" => $seguro_contractual_y_rce == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Frontales y de servicio (altas y bajas)",
                "status" => $frontales_y_de_servicio == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Traseras de trabajo (reflector)",
                "status" => $traseras_de_trabajo == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Direccionales delanteras de parqueo",
                "status" => $direccionales_delanteras_y_de_parqueo == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Direccionales traseras de parqueo",
                "status" => $direccionales_traseras_y_de_parqueo == 1 ? 1 : 0,
            ],
            [
                "nombre" => "De stop y señal trasera",
                "status" => $stop_y_senal_trasera == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Espejos laterales",
                "status" => $espejos_laterales == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Alarma de retroceso",
                "status" => $alarma_de_retroceso == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Pito",
                "status" => $pito == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Freno de servicio",
                "status" => $freno_de_servicio == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Freno de emergencia",
                "status" => $freno_de_emergencia == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Dirección-suspensión (Terminales)",
                "status" => $direccion_suspencion == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Cinturón de seguridad",
                "status" => $cinturon_seguridad == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Vidrio frontal (en buen estado)",
                "status" => $vidrio_frontal == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Limpia brisas",
                "status" => $limpia_brisas == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Extintor de incendios (10LBS) PQS",
                "status" => $extintor_de_incendios == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Silletería y tapicería",
                "status" => $silleteria_tapiceria == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Indicadores (hidráulico, voltímetro, refrigerante, horometro, aire)",
                "status" => $indicadores == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Protector válvula de descarga",
                "status" => $protector_valvula_de_descarga == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Botiquín primeros auxilios",
                "status" => $botiquin_primeros_auxilios == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Batería y cables",
                "status" => $bateria_cables == 1 ? 1 : 0,
            ],
            [
                "nombre" => "En buen estado (sin cortaduras profundas  y sin abultamientos)",
                "status" => $en_buen_estado == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Control de fugas hidráulicas",
                "status" => $control_fugas_hidraulicas == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Pasadores, suspensión",
                "status" => $pasadores_suspension == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Control de fugas de aire",
                "status" => $control_de_fugas_de_aire == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Grapas y anclajes de chasis",
                "status" => $grapas_y_anclajes_de_chasis == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Cadena del cardan",
                "status" => $cadena_del_cardan == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Mangueras",
                "status" => $mangueras == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Motor",
                "status" => $motor == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Estado general del tanque",
                "status" => $estado_gral_del_tanque == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Soporte del tanque",
                "status" => $soporte_del_tanque == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Instalación de puesta a tierra",
                "status" => $instalacion_de_puesta_a_tierra == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Tanque de combustible (abrazaderas, soporte)",
                "status" => $tanque_de_combustible == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Kit de carreteras",
                "status" => $kit_carretera == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Motor de bomba",
                "status" => $motor_de_bomba == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Kit ambiental",
                "status" => $kit_ambiental == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Observaciones",
                "status" => $observaciones
            ]
        ];

        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];

        $seguimiento_mudanza = $this->getSeguimiento($data['mudanza_id']);

        if (!is_object($seguimiento_mudanza)) {
            $insert = [
                "seguimiento_mudanza_num_mudanza" => $data['mudanza_id'],
                "seguimiento_mudanza_chequeo_preoperativo_check" => 1,
                "seguimiento_mudanza_chequeo_preoperativo" => json_encode($check_list),
                "seguimiento_mudanza_chequeo_preoperativo_time" => $fecha_date,
                "seguimiento_mudanza_chequeo_preoperativo_ubicacion" => json_encode($localizacion),
                "seguimiento_mudanza_acceso_cliente" => $access_user
            ];
            if($this->insertSeguimiento($insert)){
                return $this->response->SetResponse(true);
            }else{
                return $this->response->SetResponse(false);
            }

        } else {
            $id_mudanza = $data['mudanza_id'];
            $update = [
                "seguimiento_mudanza_chequeo_preoperativo_2_check" => 1,
                "seguimiento_mudanza_chequeo_preoperativo_2" => json_encode($check_list),
                "seguimiento_mudanza_chequeo_preoperativo_2_time" => $fecha_date,
                "seguimiento_mudanza_chequeo_preoperativo_2_ubicacion" => json_encode($localizacion)
            ];

            if($this->updateSeguimiento($id_mudanza, $update)){
                return $this->response->SetResponse(true);
            }else{
                return $this->response->SetResponse(false);
            }
        }
    }

    public function insertSeguimiento($insert) {
        $this->db->insertInto($this->table, $insert)
                ->execute();

        return $this->response->SetResponse(true);
    }

    public function updateSeguimiento($id, $data) {
        try {
            $this->db->update($this->table)->set($data)->where('seguimiento_mudanza_num_mudanza', $id)
                    ->execute();
            return $this->response->SetResponse(true);
        } catch (Exception $e) {
            return $this->response->SetResponse(false);
        }
    }

    public function getInfoMudanza($id_mudanza){
        $data = new \stdClass();
        $query = $this->db->from('mudanzas')->where('mudanza_id', $id_mudanza)->fetch();
        $data->mudanza = $query;
        return $data;
    }

    public function getInfoSeguimientoMudanza($id_mudanza){
        $data = new \stdClass();
        $query = $this->db->from('seguimiento_mudanza')->where('seguimiento_mudanza_num_mudanza', $id_mudanza)->fetch();
        $data->mudanza = $query;
        return $data;
    }

    public function getOrden($id_mudanza) {
        $query = $this->db->from('mudanzas m')
                ->innerJoin('tripulaciones tri on tri.tripulacion_id = m.mudanza_tripulacion_id')
                ->innerJoin('users u on u.id = tri.tripulacion_conductor_id')
                ->select('m.*,tri.*,u.*')
                ->where(['m.mudanza_id' => $id_mudanza])
                ->fetch();
        if (count($query) == 1) {
            return $query;
        } else {
            $query = $this->db->from('mudanzas m')
                    ->select('m.*')
                    ->where(['m.mudanza_id' => $id_mudanza])
                    ->fetch();
            return $query;
        }
    }

    //inicio de la mudanza
    public function set_inicio_mudanza($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $update = [
            "seguimiento_mudanza_inicio_mudanza" => 1,
            "seguimiento_mudanza_inicio_mudanza_time" => $fecha,
            "seguimiento_mudanza_inicio_mudanza_ubicacion" => json_encode($localizacion)
        ];
        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //guardar cercania 1
    public function set_cercania_1($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $update = [
            "seguimiento_mudanza_cercania_1" => 1,
            "seguimiento_mudanza_cercania_1_time" => $fecha,
            "seguimiento_mudanza_cercania_1_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //guardar llegada a
    public function set_llegada_a($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $update = [
            "seguimiento_mudanza_llegada_a" => 1,
            "seguimiento_mudanza_llegada_a_time" => $fecha,
            "seguimiento_mudanza_llegada_a_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //guardar inicio de cargue
    public function set_inicio_cargue($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $update = [
            "seguimiento_mudanza_inicio_cargue" => 1,
            "seguimiento_mudanza_inicio_cargue_time" => $fecha,
            "seguimiento_mudanza_inicio_cargue_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //guardar fin de cargue
    public function set_fin_cargue($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $update = [
            "seguimiento_mudanza_fin_cargue" => 1,
            "seguimiento_mudanza_fin_cargue_time" => $fecha,
            "seguimiento_mudanza_fin_cargue_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //guardar cargue General
    public function set_cargue_gral($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];

        $ram1 = $this->randomString(4);
        $ram2 = $this->randomString(8);
        $file_name = $_FILES['userfile']['name'];
        $tmp = explode('.', $file_name);
        $extension_img = end($tmp);

        //Si existe imagen y tiene un tamaño correcto
        if (($file_name == !NULL)) {
            $img_profile = $ram1 . '_' . $ram2 . '.' . $extension_img;
            //indicamos los formatos que permitimos subir a nuestro servidor
            if (($_FILES["userfile"]["type"] == "image/gif") || ($_FILES["userfile"]["type"] == "image/jpeg") || ($_FILES["userfile"]["type"] == "image/jpg") || ($_FILES["userfile"]["type"] == "image/png")) {
                // Ruta donde se guardarán las imágenes que subamos
                $directorio = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/mudanza/';
                // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio . $img_profile);
            } else {
                //si no cumple con el formato
                return $this->response->SetResponse(false, "No se puede subir una imagen con ese formato ");
            }
        } else {
            $img_profile = "";
        }

        $update = [
            "seguimiento_mudanza_cargue_gral" => 1,
            "seguimiento_mudanza_cargue_gral_time" => $fecha,
            "seguimiento_mudanza_cargue_gral_img" => $img_profile,
            "seguimiento_mudanza_cargue_gral_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //Guardar Inicio traslado
    public function set_inicio_traslado($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $update = [
            "seguimiento_mudanza_inicio_traslado" => 1,
            "seguimiento_mudanza_inicio_traslado_time" => $fecha,
            "seguimiento_mudanza_inicio_traslado_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //Guardar Cercania 2
    public function set_cercania_2($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $update = [
            "seguimiento_mudanza_cercania_2" => 1,
            "seguimiento_mudanza_cercania_2_time" => $fecha,
            "seguimiento_mudanza_cercania_2_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //Guardar Llegada B
    public function set_llegada_b($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $update = [
            "seguimiento_mudanza_llegada_b" => 1,
            "seguimiento_mudanza_llegada_b_time" => $fecha,
            "seguimiento_mudanza_llegada_b_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //Guardar Descargue
    public function set_descargue($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $nombre = $data['nombre_recibe'];
        $cedula = $data['cedula_recibe'];
        $ram1 = $this->randomString(4);
        $ram2 = $this->randomString(8);
        $file_name = $_FILES['userfile']['name'];
        $tmp = explode('.', $file_name);
        $extension_img = end($tmp);

        //Si existe imagen y tiene un tamaño correcto
        if (($file_name == !NULL)) {
            $img_profile = $ram1 . '_' . $ram2 . '.' . $extension_img;
            //indicamos los formatos que permitimos subir a nuestro servidor
            if (($_FILES["userfile"]["type"] == "image/gif") || ($_FILES["userfile"]["type"] == "image/jpeg") || ($_FILES["userfile"]["type"] == "image/jpg") || ($_FILES["userfile"]["type"] == "image/png")) {
                // Ruta donde se guardarán las imágenes que subamos
                $directorio = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/mudanza/';
                // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio . $img_profile);
            } else {
                //si no cumple con el formato
                return $this->response->SetResponse(false, "No se puede subir una imagen con ese formato ");
            }
        } else {
            $img_profile = "";
        }

        $update = [
            "seguimiento_mudanza_descargue" => 1,
            "seguimiento_mudanza_descargue_time" => $fecha,
            "seguimiento_mudanza_descargue_nombre" => $nombre,
            "seguimiento_mudanza_descargue_cedula" => $cedula,
            "seguimiento_mudanza_descargue_img" => $img_profile,
            "seguimiento_mudanza_descargue_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //fin de Descargue
    public function set_fin_descargue($data) {
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = $data['fecha'];
        $ram1 = $this->randomString(4);
        $ram2 = $this->randomString(8);
        $file_name = $_FILES['userfile']['name'];
        $tmp = explode('.', $file_name);
        $extension_img = end($tmp);

        //Si existe imagen y tiene un tamaño correcto
        if (($file_name == !NULL)) {
            $img_profile = $ram1 . '_' . $ram2 . '.' . $extension_img;
            //indicamos los formatos que permitimos subir a nuestro servidor
            if (($_FILES["userfile"]["type"] == "image/gif") || ($_FILES["userfile"]["type"] == "image/jpeg") || ($_FILES["userfile"]["type"] == "image/jpg") || ($_FILES["userfile"]["type"] == "image/png")) {
                // Ruta donde se guardarán las imágenes que subamos
                $directorio = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/mudanza/';
                // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio . $img_profile);
            } else {
                //si no cumple con el formato
                return $this->response->SetResponse(false, "No se puede subir una imagen con ese formato ");
            }
        } else {
            $img_profile = "";
        }

        $update = [
            "seguimiento_mudanza_fin_mudanza" => 1,
            "seguimiento_mudanza_fin_mudanza_time" => $fecha,
            "seguimiento_mudanza_fin_mudanza_img" => $img_profile,
            "seguimiento_mudanza_fin_mudanza_ubicacion" => json_encode($localizacion)
        ];

        if($this->updateSeguimiento($id_mudanza, $update)){
            return $this->response->SetResponse(true);
        }else{
            return $this->response->SetResponse(false);
        }
    }

    //Guardar Imagen
    public function upload_imagen($data) {
        $id_mudanza = $data['mudanza_id'];
        $info = $data['descripcion'];

        $ram1 = $this->randomString(4);
        $ram2 = $this->randomString(8);
        $file_name = $_FILES['userfile']['name'];
        $tmp = explode('.', $file_name);
        $extension_img = end($tmp);
        $fecha = $data['fecha'];
        //Si existe imagen y tiene un tamaño correcto
        if (($file_name == !NULL)) {
            $img_profile = $ram1 . '_' . $ram2 . '.' . $extension_img;
            //indicamos los formatos que permitimos subir a nuestro servidor
            if (($_FILES["userfile"]["type"] == "image/gif") || ($_FILES["userfile"]["type"] == "image/jpeg") || ($_FILES["userfile"]["type"] == "image/jpg") || ($_FILES["userfile"]["type"] == "image/png")) {
                // Ruta donde se guardarán las imágenes que subamos
                $directorio = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/mudanza/';
                // Muevo la imagen desde el directorio temporal a nuestra ruta indicada anteriormente
                move_uploaded_file($_FILES['userfile']['tmp_name'], $directorio . $img_profile);
            } else {
                //si no cumple con el formato
                return $this->response->SetResponse(false, "No se puede subir una imagen con ese formato ");
            }
        } else {
            $img_profile = "";
        }

        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];

        $insert = [
            "seguimiento_mudanza_img_seguimiento_id" => $id_mudanza,
            "seguimiento_mudanza_img_url" => $img_profile,
            "seguimiento_mudanza_img_descripcion" => $info,
            "seguimiento_mudanza_img_time" => $fecha,
            "seguimiento_mudanza_img_ubicacion" => json_encode($localizacion)
        ];

        try {
            $this->db->insertInto('seguimiento_mudanza_imgs', $insert)
                    ->execute();
            return $this->response->SetResponse(true);
        } catch (Exception $e) {
            return $this->response->SetResponse(false);
        }
    }

    //Guardar Encuesta
    public function set_encuesta($data) {

        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $id_mudanza = $data['mudanza_id'];
        $fecha = date('Y-m-d H:i:s');
        $preg_1 = $data['preg_1'];
        $preg_2 = $data['preg_2'];
        $preg_3 = $data['preg_3'];
        $preg_4 = $data['preg_4'];
        $preg_5 = $data['preg_5'];
        $preg_6 = $data['preg_6'];
        $preg_7 = $data['preg_7'];
        $preg_8 = $data['preg_8'];
        $preg_9 = $data['preg_9'];
        $preg_10 = $data['preg_10'];
        $preg_11 = $data['preg_11'];
        $servicio_adicional = $data['servicio_adicional'];
        $observacion = $data['message'];

        $respuestas = [
            "preg_1" => $preg_1,
            "preg_2" => $preg_2,
            "preg_3" => $preg_3,
            "preg_4" => $preg_4,
            "preg_5" => $preg_5,
            "preg_6" => $preg_6,
            "preg_7" => $preg_7,
            "preg_8" => $preg_8,
            "preg_9" => $preg_9,
            "preg_10" => $preg_10,
            "preg_11" => $preg_11,
            "servicio_adicional" => $$servicio_adicional,
            "message" => $observacion
        ];

        $update = [
            "seguimiento_mudanza_encuesta" => 1,
            "seguimiento_mudanza_encuesta_respuestas" => json_encode($respuestas),
            "seguimiento_mudanza_encuesta_time" => $fecha,
            "seguimiento_mudanza_encuesta_ubicacion" => json_encode($localizacion)
        ];

        $this->updateSeguimiento($id_mudanza, $update);
    }

    //guardar informacion de panico
    public function boton_panico($data) {
        if (!$data['user_id']) {
            $usuario_id = NULL;
        } else {
            $usuario_id = $data['user_id'];
        }
        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];
        $fecha = $data['fecha'];
        $insert = [
            "seguimiento_mudanza_panic_user_id" => $usuario_id,
            "seguimiento_mudanza_panic_time" => $fecha,
            "seguimiento_mudanza_panic_ubicacion" => json_encode($localizacion)
        ];


        try {
            $this->db->insertInto('seguimiento_mudanza_panic', $insert)
                ->execute();
            return $this->response->SetResponse(true);
        } catch (Exception $e) {
            return $this->response->SetResponse(false);
        }
    }

    public function randomString($length) {
        $str = "";
        $characters = array_merge(range('A', 'Z'), range('a', 'z'), range('0', '9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }

    //Guardar Chequeo Preoperativo Gral
    public function add_chequeo_preoperativo_gral($data) {
        $fecha_date = $data['fecha'];
        $licecia_de_conducir = $data['lic_cond'];
        $cedula_de_ciudadania = $data['cc'];
        $carnet_empresa = $data['ce'];
        $carnet_arl = $data['carl'];
        $audifonos_manos_libres = $data['aml'];
        $uniforme_dotacion = $data['uyd'];
        $chaleco_monogafas_guantes = $data['cmg'];
        $licencia_trancito = $data['lt'];
        $soat = $data['soat'];
        $revision_tecno_mecanica = $data['rtm'];
        $seguro_contractual_y_rce = $data['ssyrce'];
        $frontales_y_de_servicio = $data['fys'];
        $traseras_de_trabajo = $data['tt'];
        $direccionales_traseras_y_de_parqueo = $data['ddp'];
        $direccionales_delanteras_y_de_parqueo = $data['dtp'];
        $stop_y_senal_trasera = $data['sys'];
        $espejos_laterales = $data['el'];
        $alarma_de_retroceso = $data['adr'];
        $pito = $data['pito'];
        $freno_de_servicio = $data['fds'];
        $freno_de_emergencia = $data['fde'];
        $direccion_suspencion = $data['ds'];
        $cinturon_seguridad = $data['cds'];
        $vidrio_frontal = $data['vf'];
        $limpia_brisas = $data['lb'];
        $extintor_de_incendios = $data['edi'];
        $silleteria_tapiceria = $data['syt'];
        $indicadores = $data['indicadores'];
        $protector_valvula_de_descarga = $data['pvd'];
        $botiquin_primeros_auxilios = $data['bpa'];
        $bateria_cables = $data['byc'];
        $en_buen_estado = $data['ebe'];
        $control_fugas_hidraulicas = $data['cdfh'];
        $pasadores_suspension = $data['ps'];
        $control_de_fugas_de_aire = $data['cdfda'];
        $grapas_y_anclajes_de_chasis = $data['gyadc'];
        $cadena_del_cardan = $data['cdc'];
        $mangueras = $data['mangueras'];
        $motor = $data['motor'];
        $estado_gral_del_tanque = $data['egdt'];
        $soporte_del_tanque = $data['sdt'];
        $instalacion_de_puesta_a_tierra = $data['idpat'];
        $tanque_de_combustible = $data['tdc'];
        $kit_carretera = $data['kitc'];
        $motor_de_bomba = $data['mdb'];
        $kit_ambiental = $data['kita'];
        $observaciones = $data['message'];

        $check_list = [
            [
                "nombre" => "Licencia de conducción",
                "status" => $licecia_de_conducir == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Cedula de ciudadanía",
                "status" => $cedula_de_ciudadania == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Carnet empresa",
                "status" => $carnet_empresa == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Carnet ARL",
                "status" => $carnet_arl == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Audífono manos libres",
                "status" => $audifonos_manos_libres == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Uniforme y dotación",
                "status" => $uniforme_dotacion == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Chaleco, monogafas, guantes",
                "status" => $chaleco_monogafas_guantes == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Licencia de transito",
                "status" => $licencia_trancito == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Soat",
                "status" => $soat == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Revisión tecno-mecánica",
                "status" => $revision_tecno_mecanica == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Seguro contractual y rce",
                "status" => $seguro_contractual_y_rce == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Frontales y de servicio (altas y bajas)",
                "status" => $frontales_y_de_servicio == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Traseras de trabajo (reflector)",
                "status" => $traseras_de_trabajo == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Direccionales delanteras de parqueo",
                "status" => $direccionales_delanteras_y_de_parqueo == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Direccionales traseras de parqueo",
                "status" => $direccionales_traseras_y_de_parqueo == 1 ? 1 : 0,
            ],
            [
                "nombre" => "De stop y señal trasera",
                "status" => $stop_y_senal_trasera == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Espejos laterales",
                "status" => $espejos_laterales == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Alarma de retroceso",
                "status" => $alarma_de_retroceso == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Pito",
                "status" => $pito == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Freno de servicio",
                "status" => $freno_de_servicio == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Freno de emergencia",
                "status" => $freno_de_emergencia == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Dirección-suspensión (Terminales)",
                "status" => $direccion_suspencion == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Cinturón de seguridad",
                "status" => $cinturon_seguridad == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Vidrio frontal (en buen estado)",
                "status" => $vidrio_frontal == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Limpia brisas",
                "status" => $limpia_brisas == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Extintor de incendios (10LBS) PQS",
                "status" => $extintor_de_incendios == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Silletería y tapicería",
                "status" => $silleteria_tapiceria == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Indicadores (hidráulico, voltímetro, refrigerante, horometro, aire)",
                "status" => $indicadores == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Protector válvula de descarga",
                "status" => $protector_valvula_de_descarga == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Botiquín primeros auxilios",
                "status" => $botiquin_primeros_auxilios == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Batería y cables",
                "status" => $bateria_cables == 1 ? 1 : 0,
            ],
            [
                "nombre" => "En buen estado (sin cortaduras profundas  y sin abultamientos)",
                "status" => $en_buen_estado == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Control de fugas hidráulicas",
                "status" => $control_fugas_hidraulicas == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Pasadores, suspensión",
                "status" => $pasadores_suspension == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Control de fugas de aire",
                "status" => $control_de_fugas_de_aire == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Grapas y anclajes de chasis",
                "status" => $grapas_y_anclajes_de_chasis == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Cadena del cardan",
                "status" => $cadena_del_cardan == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Mangueras",
                "status" => $mangueras == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Motor",
                "status" => $motor == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Estado general del tanque",
                "status" => $estado_gral_del_tanque == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Soporte del tanque",
                "status" => $soporte_del_tanque == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Instalación de puesta a tierra",
                "status" => $instalacion_de_puesta_a_tierra == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Tanque de combustible (abrazaderas, soporte)",
                "status" => $tanque_de_combustible == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Kit de carreteras",
                "status" => $kit_carretera == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Motor de bomba",
                "status" => $motor_de_bomba == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Kit ambiental",
                "status" => $kit_ambiental == 1 ? 1 : 0,
            ],
            [
                "nombre" => "Observaciones",
                "status" => $observaciones,
            ]
        ];

        $placa_vehiculo = $data['placa'];
        $coductor_id  = $data['user_id'];

        $localizacion = [
            "lat" => $data['lat'],
            "lng" => $data['lng']
        ];

        $insert = [
            "chequeos_preoperativos_id_conductor" => $coductor_id,
            "chequeos_preoperativos_json" => json_encode($check_list),
            "chequeos_preoperativos_placa_vechiculo" => $placa_vehiculo,
            "chequeos_preoperativos_localizacion" => json_encode($localizacion),
            "chequeos_preoperativos_date" => $fecha_date
        ];

        try {
            $this->db->insertInto('chequeos_preoperativos', $insert)
                ->execute();
            return $this->response->SetResponse(true);
        } catch (Exception $e) {
            return $this->response->SetResponse(false);
        }
    }

    //Guardar Reporte de Incidentes
    public function reporar_incidente($data) {
        $fecha =  $data['fecha'];
        $incidente = $data['incidente'];
        $mensaje = $data['message'];
        foreach ($incidente as $inc) {
            if ($inc == 'trafico_denso') {
                $tipo_incidente = "TRÁFICO DENSO";
            }
            if ($inc == 'averia_mecanica') {
                $tipo_incidente = "AVERÍA MECÁNICA";
            }
            if ($inc == 'preligro_en_la_via') {
                $tipo_incidente = "PELIGRO EN LA VÍA";
            }
        }
        $insert = [
            "seguimiento_incidentes_seguimeinto_id" => $_SESSION['mudanza_id'],
            "seguimiento_incidente_tipo" => $tipo_incidente,
            "seguimiento_incidente_mensaje" => $mensaje,
            "seguimiento_incidente_time" => $fecha,
            "seguimiento_incidente_ubicacion" => $this->get_localizacion()
        ];

        try {
            $this->db->insertInto('seguimiento_incidentes', $insert)
                ->execute();
            return $this->response->SetResponse(true);
        } catch (Exception $e) {
            return $this->response->SetResponse(false);
        }
    }


}
