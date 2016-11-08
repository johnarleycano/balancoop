<?php
/**
* Modelo encargado de gestionar toda la informacion que pueda ser usada en
* el inicio de la aplicación
* 
* @author 		       John Arley Cano Salinas
* @author 		       Oscar Humberto Morales
*/
Class Inicio_model extends CI_Model{
    function obtener_id_empresa($documento){
    	//Columnas a retornar
        $this->db->select('*');
        $this->db->where('nit', $documento);
        
        //Se ejecuta y retorna la consulta
        $resultado = $this->db->get('empresas_usuarias')->row();

        //Si existe el usuario
        if (count($resultado) == 1) {
            //se retorna verdadero
            return $resultado;
        } else {
            //se retorna falso
            return false;
        }
    }

    function validar_sesion($usuario, $password, $id_empresa){
    	$this->db->select('*');

    	//Se validan el usuario, el password y la empresa
        $this->db->where('login', $usuario);
        $this->db->where('password', $password);
        $this->db->where('id_empresa', $id_empresa);

        $resultado = $this->db->get('usuarios_sistema')->row();

        //Si existe el usuario
        if (count($resultado) == 1) {
        	//se retorna verdadero
        	return $resultado;
        } else {
        	//se retorna falso
        	return false;
        }
    }
}
/* Fin del archivo inicio_model.php */
/* Ubicación: ./application/models/inicio_model.php */