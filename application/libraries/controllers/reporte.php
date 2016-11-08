<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

//Se carga la librer&iacute;a de PDF y la libreria de impresion rapida
require('system/libraries/Fpdf.php');

//Definir la ruta de las fuentes
define('FPDF_FONTPATH','system/fonts/');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Balance
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Reporte extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if
        
        //Carga de modelos
        $this->load->model(array('balance_model', 'listas_model'));

        //Carga de listas desplegables del formulario        
        // $this->data['oficinas'] =  $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));               
    }

    function balance_social(){
    	//Se carga la vista que contiene el reporte
        $this->load->view('reporte/pdf/balance_social');
    }
}
/* Fin del archivo reporte.php */
/* Ubicación: ./application/controllers/reporte.php */