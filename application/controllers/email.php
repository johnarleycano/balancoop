<?php
//Zona horaria
date_default_timezone_set('America/Bogota');

if ( ! defined('BASEPATH')) exit('Lo sentimos, usted no tiene acceso a esta ruta');

/**
 * Cliente
 * 
 * @author              John Arley Cano Salinas
 */
Class Email extends CI_Controller{
	function __construct() {
        parent::__construct();

        //Si no ha iniciado sesión
        if(!$this->session->userdata('id_usuario')){
            //Se cierra la sesion obligatoriamente
            redirect('inicio/cerrar_sesion');
        }//Fin if

        //Se cargan los modelos, librerias y helpers
    	$this->load->library(array('email'));
        // $this->load->model(array('cliente_model'));
    }

    function enviar(){
    	echo "ok";
    }
 }
/* Fin del archivo email.php */
/* Ubicación: ./application/controllers/email.php */