<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Administracion
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Inicio extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Carga de modelos
        $this->load->model(array('inicio_model', 'listas_model', 'transferencia_model'));

        //Carga de listas
        $this->data['empresas'] = $this->listas_model->cargar('empresas_usuarias');
    }

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	function index(){
		//se establece el titulo de la pagina
        $this->data['titulo'] = 'Inicio';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'inicio/inicio_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
	}

    function cargar_interfaz(){
        //Suiche
        switch ($this->input->post('tipo')) {
            //Si es campaña
            case 'transferencia':
                // $this->data['datos_asociado'] = $this->input->post('datos_asociado');
                
                //Usaremos esta variable para identificar que sea asociado
                $this->data['es_asociado'] = true;
                
                //Se establece la vista que tiene el contenido principal
                $this->load->view('transferencia/index_view', $this->data);
                break;

            //Si es campaña
            case 'transferencia_vista':
                //Cargamos la vista
                $this->load->view('transferencia/transferencia_view');
                break;
        }
    }

    function cerrar_sesion(){
        //Se destruye la sesion actual
        $this->session->sess_destroy();
        
        //Se redirige hacia el controlador principal
        redirect('');
    }

	function ingresar(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Inicio';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'inicio/inicio_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
	}

    function actualizar_estados(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            // Se ejecuta el modelo
            echo $this->inicio_model->actualizar_estados($this->input->post("tipo"));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_oficinas(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el id de la empresa por post
            $id_empresa = $this->input->post("id_empresa");

            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_empresa("din_agencias", $id_empresa));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function validar_sesion(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Recibo los datos por POST
            $usuario = $this->input->post('usuario');
            $password = sha1($this->input->post('password'));
            $id_empresa = $this->input->post('id_empresa');

            //Ejecuto el modelo
            $datos_sesion = $this->inicio_model->validar_sesion($usuario, $password, $id_empresa);

            //Si el usuario existe
            if ($datos_sesion) {
                $sesion = array(
                    "id_usuario" => $datos_sesion->intCodigo,
                    "nombre_usuario" => $datos_sesion->strNombre,
                    "identificacion" => $datos_sesion->Identificacion,
                    "id_empresa" => $datos_sesion->id_empresa,
                    "id_filtro_por_defecto" => $datos_sesion->id_filtro_por_defecto,
                    "estado" => $datos_sesion->estado,
                    "tipo" => $datos_sesion->id_tipo_usuario,
                    "Actualizacion" => '0'
                );

                //Se cargan los datos a la sesión
                $this->session->set_userdata($sesion);
        
                //Respuesta ok
                echo true;
            }else{
                echo false;
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function validar_asociado(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Ejecuto el modelo
            $asociado = $this->inicio_model->validar_asociado($this->input->post('documento'));

            //Se retorna el resultado
            print json_encode($asociado);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function obtener_id_empresa(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Ejecuto el modelo
            $empresa = $this->inicio_model->obtener_id_empresa($this->input->post('documento'));

            //Se retorna el resultado
            print json_encode($empresa);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo inicio.php */
/* Ubicación: ./application/controllers/inicio.php */