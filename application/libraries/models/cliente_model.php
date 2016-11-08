<?php
/**
 * Modelo encargado de gestionar toda la informacion relacionada al cliente
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Cliente_model extends CI_Model{
    function actualizar($datos, $id_asociado){
        $this->db->where('id_Asociado', $id_asociado);
        if($this->db->update('asociados', $datos)){
            //Retorna verdadero
            return true;
        }
    }

	function borrar($tipo, $id_asociado){
        switch ($tipo) {
            case 'beneficiarios':
                //Si se borran los beneficiarios asociados al usuario
                if($this->db->delete('asociados_beneficiarios', array('id_Asociado' => $id_asociado))){
                    //Se retorna true           
                    return true;
                }
                break;

            case 'cargos':
                //Si se borran los cargos asociados al usuario
                if($this->db->delete('asociados_cargos', array('id_Asociado' => $id_asociado))){
                    //Se retorna true           
                    return true;
                }
                break;

            case 'conocidos':
                //Si se borran los conocidos asociados al usuario
                if($this->db->delete('asociados_conocidos', array('id_Asociado' => $id_asociado))){
                    //Se retorna true           
                    return true;
                }
                break;

            case 'gustos':
                //Si se borran los gustos asociados al usuario
                if($this->db->delete('asociados_gustos', array('int_IdAsociado' => $id_asociado))){
                    //Se retorna true           
                    return true;
                }
                break;

            case 'hijos':
                //Si se borran los gustos asociados al usuario
                if($this->db->delete('asociados_hijos', array('id_Asociado' => $id_asociado))){
                    //Se retorna true           
                    return true;
                }
                break;
        }
		
	}

    function buscar($documento){
        $sql = 
        "SELECT
        *
        FROM
        asociados
        WHERE Identificacion = '{$documento}'
        AND id_Empresa = '{$this->session->userdata('id_empresa')}'";

        $resultado = $this->db->query($sql)->row();

        if(count($resultado) < 1){
            $documento = str_pad($documento, 12 , "0", STR_PAD_LEFT);
            
            $sql = 
            "SELECT
            *
            FROM
            asociados
            WHERE Identificacion = '{$documento}'
            AND id_Empresa = '{$this->session->userdata('id_empresa')}'";

            $resultado = $this->db->query($sql)->row();
        }

        return $resultado;  
    }

    function cargar_asociado($id){
        $this->db->where('id_Asociado', $id);
        $this->db->select('*');

        return $this->db->get('asociados')->row();
    }

    function cargar_beneficiarios($id_asociado){
        $this->db->select('*');
        $this->db->where('id_Asociado', $id_asociado);

        return $this->db->get('asociados_beneficiarios')->result();
    }
    function cargar_productos_matriculados($id_asociado){
        $this->db->select('*');
        $this->db->select('*');
        $this->db->select('*');
        $this->db->where('id_Asociado', $id_asociado);

        return $this->db->get('asociados_beneficiarios')->result();
    }
    function cargar_cargos($id_asociado){
        $this->db->where('id_Asociado', $id_asociado);
        $this->db->select('*');

        return $this->db->get('asociados_cargos')->result();
    }

    function cargar_conocidos($id_asociado){
        $this->db->select('*');
        $this->db->where('id_Asociado', $id_asociado);

        return $this->db->get('asociados_conocidos')->result();
    }

    function cargar_hijos($id_asociado){
        $this->db->select('*');
        $this->db->where('id_Asociado', $id_asociado);

        return $this->db->get('asociados_hijos')->result();
    }

    function cargar_gustos($id_asociado){
        $this->db->select('int_IdGusto');
        $this->db->where('int_IdAsociado', $id_asociado);

        return $this->db->get('asociados_gustos')->result();
    }

	function guardar($datos){
		//Se ejecuta el modelo que guarda los datos
		$guardar = $this->db->insert('asociados', $datos);

		//Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
	}

	function guardar_beneficiario($datos){
		//Se ejecuta el modelo que guarda los datos
		$guardar = $this->db->insert('asociados_beneficiarios', $datos);

		//Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
	}

	function guardar_conocido($datos){
		//Se ejecuta el modelo que guarda los datos
		$guardar = $this->db->insert('asociados_conocidos', $datos);

		//Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
	}

	function guardar_hijo($datos){
		//Se ejecuta el modelo que guarda los datos
		$guardar = $this->db->insert('asociados_hijos', $datos);

		//Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
	}

	function guardar_cargos($datos){
		//Se ejecuta el modelo que guarda los datos
		$guardar = $this->db->insert('asociados_cargos', $datos);

		//Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
	}

	function guardar_gustos($datos){
		//Se ejecuta el modelo que guarda los datos
		$guardar = $this->db->insert('asociados_gustos', $datos);

		//Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
	}
}
/* Fin del archivo cliente_model.php */
/* Ubicación: ./application/models/cliente_model.php */