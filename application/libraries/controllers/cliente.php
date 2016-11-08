<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Cliente
 * 
 * @author              John Arley Cano Salinas
 * @author              Oscar Humberto Morales 
 */
Class Cliente extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if

        //Carga de modelos
        $this->load->model(array('cliente_model'));
    }

    function index(){
    	//se establece el titulo de la pagina
        $this->data['titulo'] = 'Cliente';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'cliente/buscar_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST y el tipo de guardado
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');
            $id_asociado = $this->input->post('id_asociado');
            $actualizar = false;

            //Suiche
            switch ($tipo) {
                case 'asociado':
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->actualizar($datos, $id_asociado);
                    break;
                case 'beneficiario':                   
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_beneficiario($datos);
                    break;
                case 'hijo':
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_hijo($datos);
                    break;
                case 'conocido':
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_conocido($datos);
                    break;
                case 'cargo':
                    //Se envían los datos al modelo que los guardará
                    $actualizar = $this->cliente_model->guardar_cargos($datos);
                    break;
            }// Switch

            //Si se guarda
            if($actualizar) {
                //Se toma el último id
                //$resultado = mssql_fetch_assoc(mssql_query("select @@IDENTITY as id"));
                // $resultado = $this->db->insert_id();

                //Se retorna como respuesta el id del asociado
                // print json_encode(array("id_asociado" => $resultado));
                echo $actualizar;
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function agregar_beneficiarios(){
        //Se captura el número del beneficiario
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/beneficiario_view', $this->data);
    }

    function agregar_hijos(){
        //Se captura el número del hijo
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/hijo_view', $this->data);
    }

    function agregar_conocidos(){
        //Se captura el número del conocido
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/conocido_view', $this->data);
    }

    function agregar_cargos(){
        //Se captura el número de cargos
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/cargos_view', $this->data);
    }

    function agregar_productos(){
        //Se captura el número del beneficiario
        $this->data['numero'] = $this->input->post('numero'); 

        //Se carga la vista
        $this->load->view('cliente/producto_view', $this->data);
    }

    function borrar(){
        switch ($this->input->post('tipo')) {
            case 'beneficiarios':
                // Se borra
                $this->cliente_model->borrar('beneficiarios', $this->input->post('id_asociado'));
                break;
            
            case 'cargos':
                // Se borra
                $this->cliente_model->borrar('cargos', $this->input->post('id_asociado'));
                break;


            case 'conocidos':
                // Se borra
                $this->cliente_model->borrar('conocidos', $this->input->post('id_asociado'));
                break;

            case 'hijos':
                // Se borra
                $this->cliente_model->borrar('hijos', $this->input->post('id_asociado'));
                break;
        }
    }

    function buscar(){
        //Se recibe el número de documento por post
        $documento = $this->input->post('documento');

        //Se ejecuta el modelo
        $busqueda = $this->cliente_model->buscar($documento);

        // Si lo encuentra
        if (count($busqueda) != 0) {
            print json_encode($busqueda);
        }else{
            echo "false";
        }
    }

    function cargar(){
        //Se recibe el id de asociado por post
        $id_asociado = $this->input->post('id_asociado');

        // suiche
        switch ($this->input->post('tipo')) {
            case 'beneficiario':
                //Se consultan los beneficiarios que pueda tener ese asociado
                $beneficiarios = $this->cliente_model->cargar_beneficiarios($id_asociado);

                //Si se recibe algo
                if ($beneficiarios) {
                    print json_encode($beneficiarios);
                }else{
                    echo "false";
                }
                break;

            case 'cargo':
                //Se consultan los cargos que pueda tener ese asociado
                $cargos = $this->cliente_model->cargar_cargos($id_asociado);

                //Si se recibe algo
                if ($cargos) {
                    print json_encode($cargos);
                }else{
                    echo "false";
                }
                break;

            case 'hijo':
                //Se consultan los hijos que pueda tener ese asociado
                $hijos = $this->cliente_model->cargar_hijos($id_asociado);

                //Si se recibe algo
                if ($hijos) {
                    print json_encode($hijos);
                }else{
                    echo "false";
                }
                break;

            case 'conocido':
                //Se consultan los hijos que pueda tener ese asociado
                $hijos = $this->cliente_model->cargar_conocidos($id_asociado);

                //Si se recibe algo
                if ($hijos) {
                    print json_encode($hijos);
                }else{
                    echo "false";
                }
                break;

            case 'producto':
                //Se consultan los productos que pueda tener ese asociado
                $cargos = $this->cliente_model->cargar_productos_matriculados($id_asociado);

                //Si se recibe algo
                if ($cargos) {
                    print json_encode($cargos);
                }else{
                    echo "false";
                }
                break;
        }
    }

    function guardar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST y el tipo de guardado
            $datos = $this->input->post('datos');
            $tipo = $this->input->post('tipo');
            $guardar = false;

            //Suiche
            switch ($tipo) {
                case 'asociado':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar($datos);
                    break;
                case 'beneficiario':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_beneficiario($datos);
                    break;
                case 'hijo':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_hijo($datos);
                    break;
                case 'conocido':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_conocido($datos);
                    break;
                case 'cargo':
                    //Se envían los datos al modelo que los guardará
                    $guardar = $this->cliente_model->guardar_cargos($datos);
                    break;
            }// Switch

            //Si se guarda
            if($guardar) {
                //Se toma el último id
                //$resultado = mssql_fetch_assoc(mssql_query("select @@IDENTITY as id"));
                $resultado = $this->db->insert_id();

                //Se retorna como respuesta el id del asociado
                print json_encode(array("id_asociado" => $resultado));
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function guardar_gustos(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST y el id del asociado
            $datos_gustos = $this->input->post('datos');
            $id_asociado = $this->input->post('id_asociado');

            $array_gustos = array();

            //Se borran todos los gustos anteriores
            $this->cliente_model->borrar("gustos", $id_asociado);

            //Se procede recorrer los gustos
            foreach ($datos_gustos as $gusto) {
                //Se inserta el gusto
                $this->cliente_model->guardar_gustos(array('int_IdAsociado' => $id_asociado, 'int_IdGusto' => $gusto));
            }// if
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo cliente.php */
/* Ubicación: ./application/controllers/cliente.php */