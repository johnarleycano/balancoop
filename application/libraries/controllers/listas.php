<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Genérico
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Listas extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Carga de modelos
        $this->load->model(array('crm_model', 'filtro_model', 'cliente_model', 'transferencia_model', 'balance_model'));

        $this->data['anios'] = $this->listas_model->listar_anios();
        $this->data['cargos'] = $this->listas_model->cargar('cargos');
        $this->data['conocimientos'] = $this->listas_model->cargar('conocimiento_cooperativismo');
        $this->data['escolaridades'] = $this->listas_model->cargar('escolaridad');
        $this->data['estados_civiles'] = $this->listas_model->cargar('estado_civil');
        $this->data['designaciones'] = $this->listas_model->cargar('designacion');
        $this->data['designaciones'] = $this->listas_model->cargar('designacion');
        $this->data['dias'] = $this->listas_model->listar_dias();
        $this->data['estados_usuario'] = $this->listas_model->cargar('estado_asociado');
        $this->data['estratos'] = $this->listas_model->cargar('estratos');
        $this->data['generos'] = $this->listas_model->cargar('generos');
        $this->data['gustos'] = $this->listas_model->cargar('gustos');
        $this->data['grupos_familiares'] = $this->listas_model->cargar('grupo_familiar');
        $this->data['industrias'] = $this->listas_model->cargar('industrias');
        $this->data['meses'] = $this->listas_model->listar_meses();
        $this->data['motivos_retiro'] = $this->listas_model->cargar('motivo_retiro');
        $this->data['oficinas'] = $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));
        $this->data['origenes_cliente'] = $this->listas_model->cargar('origen_cliente');
        $this->data['paises'] = $this->listas_model->cargar_paises();
        $this->data['parentescos'] = $this->listas_model->cargar('parentescos');
        $this->data['profesiones'] = $this->listas_model->cargar('profesiones');
        $this->data['rangos_salario'] = $this->listas_model->cargar('rango_de_salario');
        $this->data['tipos_cliente'] = $this->listas_model->cargar('tipo_cliente');
        $this->data['tipos_documento'] = $this->listas_model->cargar('tipo_documento');
        $this->data['usuarios'] = $this->listas_model->cargar('usuarios_sistema');
        $this->data['zonas'] = $this->listas_model->cargar('zonas');
        $this->data['tipo_empleados'] = $this->listas_model->cargar('tipo_empleado');
        $this->data['ubicacion_empleados'] = $this->listas_model->cargar('ubicacion_empleado');

        //Carga de listas desplegables del formulario
        $this->data['campanas'] = $this->listas_model->cargar('campanas');        
        $this->data['productos'] = $this->listas_model->cargar('productos');
        $this->data['busquedas_rapidas'] = $this->crm_model->cargar_busquedas_rapidas('busqueda_rapida');
        $this->data['filtros_cliente'] = $this->crm_model->cargar_busquedas_rapidas('es_cliente');
        $this->data['filtros_sistema'] = $this->crm_model->cargar_busquedas_rapidas('es_sistema');
        $this->data['usuarios'] = $this->listas_model->cargar('usuarios_sistema');

        //Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if
    }

    function index(){
        //se establece el titulo de la pagina
        $this->data['titulo'] = 'Gestión de datos';
        //Se establece la vista que tiene el contenido principal
        $this->data['contenido_principal'] = 'listas/index_view';
        //Se carga la plantilla con las demas variables
        $this->load->view('plantillas/template', $this->data);
    }

	function calcular_edad(){
		//Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
        	//Se recibe la fecha
        	$fecha_nacimiento = $this->input->post('fecha_nacimiento');

        	list($Y,$m,$d) = explode("-",$fecha_nacimiento);
			
			echo date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y;
		}else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
	}//calcular_edad

    function cargar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe la tabla por post
            $tabla = $this->input->post("tabla");

            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar($tabla));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_barrios(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el código de la ciudad por post
            $codigo_ciudad = $this->input->post("codigo_ciudad");

            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_barrios($codigo_ciudad));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

    function cargar_ciudades(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el código del departamento por post
            $codigo_departamento = $this->input->post("codigo_departamento");

            //Se hace la consulta en el modelo y se retorna como array JSON
            print json_encode($this->listas_model->cargar_ciudades($codigo_departamento));
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
    }

	function cargar_departamentos(){
		//Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
        	//Se recibe el código del país por post
        	$codigo_pais = $this->input->post("codigo_pais");

        	//Se hace la consulta en el modelo y se retorna como array JSON
        	print json_encode($this->listas_model->cargar_departamentos($codigo_pais));
    	}else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        } //if
	}

    function cargar_interfaz(){
        //Suiche
        switch ($this->input->post('tipo')) {
            //Si es categoría de un balance
            case 'balance_categorias':
                //Cargamos la vista
                $this->load->view('balance/categorias_view');
                break;

            //Si es creación de un balance
            case 'balance_creacion':
                //Cargamos la vista
                $this->load->view('balance/crear_view');
                break;

            //Si es dimensión de un balance
            case 'balance_dimensiones':
                //Cargamos la vista
                $this->load->view('balance/dimensiones_view');
                break;

            //Si es variables de un balance
            case 'balance_variables':
                //Cargamos la vista
                $this->load->view('balance/variables_view');
                break;

            //Si creará una estructura de un balance
            case 'balance_configuracion':
                //Cargamos la vista
                $this->load->view('balance/configuracion_view');
                break;

            //Si es el peso de un balance
            case 'balance_pesos':
                //Cargamos la vista
                $this->load->view('balance/pesos_view');
                break;
                
            //Si es barrio
            case 'barrio':
                //Se recibe el código del departamento por post
                $this->data['codigo_ciudad'] = $this->input->post('codigo_ciudad');

                //Cargamos la vista
                $this->load->view('listas/regiones/barrios_view', $this->data);
                break;

            //Si es campaña
            case 'campana':
                //Cargamos la vista
                $this->load->view('listas/campana_view');
                break;

            //Datos personales del cliente
            case 'cliente':
                //Se recibe el código del departamento por post
                $this->data['id_asociado'] = $this->input->post('id_asociado');

                //Cargamos la vista
                $this->load->view('cliente/index_view', $this->data);
                break;

            //Si es ciudad
            case 'ciudad':
                //Se recibe el código del departamento por post
                $this->data['codigo_departamento'] = $this->input->post('codigo_departamento');

                //Cargamos la vista
                $this->load->view('listas/regiones/ciudades_view', $this->data);
                break;

            //Si es búsqueda por cédula
            case 'crm_cedula':
                //Cargamos la vista
                $this->load->view('crm/buscar_cedula_view', $this->data);
                break;

            //Si es búsqueda por producto
            case 'crm_producto':
                //Cargamos la vista
                $this->load->view('crm/buscar_producto_view', $this->data);
                break;

            //Si es filtros
            case 'crm_filtro':
                //Se recibe la tabla por post
                //$this->data['asociados'] = $this->input->post('asociados');

                //Cargamos la vista
                $this->load->view('crm/filtros_view', $this->data);
                break;

            //Si es tabla de productos
            case 'crm_tabla_productos':
                //Se recibe la tabla por post
                $this->data['productos'] = $this->input->post('productos');
                $this->data['asociado'] = $this->input->post('asociado');

                //Cargamos la vista
                $this->load->view('crm/tabla_productos_view', $this->data);
                break;

            //Si es tabla de asociados
            case 'crm_tabla_asociados':
                //Se recibe la tabla por post
                $this->data['asociados'] = $this->input->post('asociados');

                //Cargamos la vista
                $this->load->view('crm/tabla_asociados_view', $this->data);
                break;

            //Si es departamento
            case 'departamento':
                //Se recibe el código del país por post
                $this->data['codigo_pais'] = $this->input->post('codigo_pais');

                //Cargamos la vista
                $this->load->view('listas/regiones/departamentos_view', $this->data);
                break;

            //Si es empresa u oficina
            case 'empresa_oficina':
                //Se recibe la variable que define si es empresa u oficina por post
                $this->data['empresa'] = $this->input->post('empresa');

                //Cargamos la vista
                $this->load->view('listas/empresa_oficina_view', $this->data);
                break;

            //Si es lista
            case 'lista':
                //Cargamos la vista
                $this->load->view('listas/listas_desplegables/index_view');
                break;

            //Si es region
            case 'lista_desplegable':
                //Se recibe la tabla por post
                $this->data['tabla'] = $this->input->post('tabla');

                //Cargamos la vista
                $this->load->view('listas/listas_desplegables/listas_view', $this->data);
                break;

            //Si es oportunidad
            case 'oportunidad':
                //Cargamos la vista
                $this->load->view('listas/oportunidad_view');
                break;

            //Si es país
            case 'pais':
                //Cargamos la vista
                $this->load->view('listas/regiones/paises_view');
                break;

            //Si es producto
            case 'producto':
                //Cargamos la vista
                $this->load->view('listas/producto_view');
                break;

            //Si es proveedor
            case 'proveedor':
                //Cargamos la vista
                $this->load->view('listas/proveedor_view');
                break;

            //Si es region
            case 'region':
                //Cargamos la vista
                $this->load->view('listas/regiones/index_view');
                break;

            //Si es tabla
            case 'tabla':
                //Se recibe la tabla por post
                $this->data['id_filtro'] = $this->input->post('id_filtro');

                //Cargamos la vista
                $this->load->view('crm/tabla_view', $this->data);
                break; 

            //Si es campaña
            case 'transferencia_vista':
                //Cargamos la vista
                $this->load->view('transferencia/transferencia_view');
                break;
        }
    }
    
    function guardar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST
            $datos = $this->input->post('datos');
            $tabla = $this->input->post('tabla');

            //Se retorna el resultado de la inserción 
            echo $guardar = $this->listas_model->guardar($datos, $tabla);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function actualizar(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Se recibe el arreglo de datos que viene por POST
            $datos = $this->input->post('datos');
            $tabla = $this->input->post('tabla');
            $campo = $this->input->post('campo');
            $id_campo = $this->input->post('id_campo');

            //Se retorna el resultado de la inserción 
            echo $guardar = $this->listas_model->actualizar($datos, $tabla, $campo, $id_campo);
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }

    function subir(){
        //Se valida que la peticion venga mediante ajax y no mediante el navegador
        if($this->input->is_ajax_request()){
            //Almacenamos la ruta de los logos
            $ruta_logos = base_url()."img/logos/";
            echo $ruta_logos;
        }else{
            //Si la peticion fue hecha mediante navegador, se redirecciona a la pagina de inicio
            redirect('');
        }
    }
}
/* Fin del archivo listas.php */
/* Ubicación: ./application/controllers/listas.php */