<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Balance
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Balance extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if
        
        //Carga de modelos
        $this->load->model(array('balance_model', 'transferencia_model'));

        //Carga de listas desplegables del formulario        
        // $this->data['oficinas'] =  $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));               
    }

	/**
	 * [index description]
	 * @return [type] [description]
	 */
	function index(){
		//se establece el titulo de la pagina
        $this->data['titulo'] = 'Balance social';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'balance/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
	}

    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $datos = $this->input->post('datos');
            $id_variable = $this->input->post('anio');
            $id_variable = $this->input->post('id_variable');

            //Si se guarda
            if ($this->balance_model->actualizar($datos, $id_variable)) {
                echo 'true';
            } else {
                echo 'false';
            }
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function actualizar_peso(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $id = $this->input->post('id');
            $valor = $this->input->post('peso');

            //Se ejecuta el modelo que actualiza
            echo $this->balance_model->actualizar_peso($id, $valor);

            //Se ejecuta el modelo
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function borrar_valores_reales(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que 
            echo $this->balance_model->borrar_valores_reales($this->input->post('id_balance'), $this->input->post('datos'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $tipo = $this->input->post('tipo');
            $anio = $this->input->post('anio');
            $id_variable = $this->input->post('id_variable');
            
            //Se listan las categorías

            //Se listan las dimensiones
            print json_encode($this->balance_model->cargar($tipo, $anio, $id_variable, '0'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar_estructuras(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $tipo = $this->input->post('tipo');
            $id_balance = $this->input->post('id_balance');
            $id_variable = $this->input->post('id_variable');
            
            //Se listan las categorías

            //Se listan las dimensiones
            print json_encode($this->balance_model->cargar_estructuras($tipo, $id_balance, $id_variable, '0'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar_balances_comparacion(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por POST
            $anio_anterior = $this->input->post('anio')-1;

            //Se ejecuta el modelo que actualiza
            print json_encode($this->balance_model->cargar_balances($anio_anterior));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function cargar_filtros(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que actualiza
            print json_encode($this->balance_model->cargar_filtros());
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function consultar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que actualiza
            echo $this->balance_model->consultar($this->input->post('id_estructura'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function crear(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $guardar = false;
            $tipo = $this->input->post('tipo');
            $datos = $this->input->post('datos');

            // suiche
            switch ($tipo) {
                case 'estructura':
                    // Se ejecuta para guardar
                    $guardar = $this->balance_model->guardar($datos);
                    break;

                case 'balance':
                    // Se ejecuta para guardar
                    $guardar = $this->balance_model->guardar($datos);
                    break;
            } // swith

            //Si se guarda
            if($guardar) {
                //Retorna verdadero
                echo 'true';
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function crear_balance(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $guardar = false;
            $datos = $this->input->post('datos');

            // Se ejecuta para guardar
            $guardar = $this->balance_model->crear('balance', $datos);

            //Si se guarda
            if($guardar == 'true') {
                //Retorna el id
                print json_encode(array('id_balance' => mysql_insert_id()));
            } else {
                echo "false";
            }//If
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function crear_estructuras(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se reciben los datos por post
            $guardar = false;
            $id_balance_copia = $this->input->post('id_balance_copia');
            $id_balance_nuevo = $this->input->post('id_balance_nuevo');

            // Se recorren y se guardan sólo las categorías
            foreach ($this->balance_model->consultar_estructuras($id_balance_copia) as $estructura) {
                // Se actualiza el id del balance
                $estructura->id_balance = $id_balance_nuevo;

                //Se quita el id primario
                unset($estructura->intCodigo);

                /**
                 * Con este suiche controlaremos la creación descendiente de los datos
                 * Basándonos en el tipo de estructura
                 */
                switch ($estructura->tipo) {
                    //Cuando es categoría
                    case 'C':
                        //Se crea la estructura normalmente
                        $this->balance_model->guardar($estructura);

                        //Se toma el id creado para usarlo como conector
                        $id_categoria = mysql_insert_id();
                        break;

                    //Cuando es dimensión
                    case 'D':
                        //Se modifica el id del conector, y se toma el id de la categoría que se creó
                        $estructura->id_conector = $id_categoria;

                        //Se crea la estructura normalmente
                        $this->balance_model->guardar($estructura);

                        //Se declara el id del de la dimensión para usar como conector para las variables
                        $id_dimension = mysql_insert_id();
                        break;

                    //Cuando es variable
                    case 'V':
                        //Se modifica el id del conector y se pone el id de la dimensión
                        $estructura->id_conector = $id_dimension;

                        //Se crea la estructura normalmente
                        $this->balance_model->guardar($estructura);
                        break;
                } // suiche
            } //foreach
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function validar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se ejecuta el modelo que valida la existencia del balance y se retorna el resultado
            echo $this->balance_model->validar($this->input->post('datos'));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo balance.php */
/* Ubicación: ./application/controllers/balance.php */