<?php
/**
 * Modelo encargado de gestionar toda la informacion relacionada a los filtros
 * 
 * @author             John Arley Cano Salinas
 * @author             Oscar Humberto Morales
 */
Class Filtro_model extends CI_Model{
    function cambiar_filtro_por_defecto($id_filtro){
        //Condición
        $this->db->where('intCodigo', $this->session->userdata('id_usuario'));

        //Actualiza
        if ($this->db->update('usuarios_sistema', array("id_filtro_por_defecto" => $id_filtro))) {
            return true;
         } 
    }

    function cargar_campos($tipo){
        $this->db->select('*');
        if(!$tipo){
        }else{
            $this->db->where('Asociado', $tipo);
        }
        
        //Retornamos el resultado
        return $this->db->get('filtro_campos')->result();
    }

    function cargar_filtros_asociados($tipo){
        $sql =
        "SELECT
        filtros_creados.intCodigo,
        filtros_creados.strNombre,
        filtros_creados.es_reporte,
        filtros_creados.es_sistema,
        filtros_creados.es_cliente,
        filtros_creados.busqueda_rapida,
        filtros_creados.id_asociado,
        filtros_creados.privado,
        filtros_creados.Estado,
        filtros_creados.id_usuario,
        filtros_creados.id_Filtro_balance,
        filtros_creados.id_campo_balance,
        filtro_campos.Asociado
        FROM
        filtros_creados
        INNER JOIN filtros_creados_campos ON filtros_creados_campos.id_filtro = filtros_creados.intCodigo
        INNER JOIN filtro_campos ON filtros_creados_campos.id_filtro_campo = filtro_campos.intCodigo
        WHERE
        filtros_creados.id_usuario = {$this->session->userdata('id_usuario')}
        AND filtro_campos.Asociado = {$tipo}
        GROUP BY
        filtros_creados.intCodigo";

        // $this->db->select('*');
        // $this->db->where('id_asociado', $this->session->userdata('id_usuario'));
        
        //Retornamos el resultado
        // return $this->db->get('filtros_creados')->result();
        return $this->db->query($sql)->result();
    }

    function cargar_filtros_productos(){
        $sql_ =
        "SELECT
                filtros_creados.intCodigo,
                filtros_creados.strNombre,
                filtros_creados.es_reporte,
                filtros_creados.es_sistema,
                filtros_creados.es_cliente,
                filtros_creados.busqueda_rapida,
                filtros_creados.id_asociado,
                filtros_creados.privado,
                filtros_creados.Estado,
                filtros_creados.id_usuario,
                filtros_creados.id_Filtro_balance,
                filtros_creados.id_campo_balance
        FROM
        filtros_creados_productos
        INNER JOIN filtros_creados ON filtros_creados_productos.id_filtro = filtros_creados.intCodigo
        GROUP BY
                filtros_creados_productos.id_filtro
        ORDER BY
        filtros_creados.strNombre ASC";

        $sql =
        "SELECT
            filtros_creados.intCodigo,
            filtros_creados.strNombre,
            filtros_creados.es_reporte,
            filtros_creados.es_sistema,
            filtros_creados.es_cliente,
            filtros_creados.busqueda_rapida,
            filtros_creados.id_asociado,
            filtros_creados.privado,
            filtros_creados.Estado,
            filtros_creados.id_usuario,
            filtros_creados.id_Filtro_balance,
            filtros_creados.id_campo_balance
        FROM
            filtros_creados_productos
        INNER JOIN filtros_creados ON filtros_creados_productos.id_filtro = filtros_creados.intCodigo
        INNER JOIN usuarios_sistema ON filtros_creados.id_asociado = usuarios_sistema.intCodigo
        WHERE
            usuarios_sistema.id_empresa = '{$this->session->userdata('id_empresa')}'
        GROUP BY
            filtros_creados_productos.id_filtro
        ORDER BY
            filtros_creados.strNombre ASC";

        return $this->db->query($sql)->result();
    }

    function cargar_filtro_producto($id_filtro){
        $this->db->select('*');
        $this->db->where('id_filtro', $id_filtro);

        return $this->db->get('filtros_creados_productos')->row();
    }

    function guardar($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('filtros_creados', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    function guardar_condicional_producto($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('filtros_creados_productos', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    function guardar_condicional($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('filtros_creados_condiciones', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    function guardar_campos($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('filtros_creados_campos', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    function actualizar($datos,$id){        
        //Se ejecuta el modelo que guarda los datos
        $this->db->where('intCodigo', $id);
        $guardar = $this->db->update('filtros_creados', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    function actualizar_estado($id, $datos){        
        $sql = 
        "UPDATE filtros_creados SET Estado = $datos WHERE (intCodigo = $id )";

        return $this->db->query($sql)->row();
    }
    
    function borrar_datos($id){
        //Se borran los condicionales que hay en BD
        $this->db->delete('filtros_creados_condiciones', array('id_filtro' => $id));

        //Se borran los condicionales que hay en BD
        $this->db->delete('filtros_creados_campos', array('id_filtro' => $id));

    }
    
    function borrar_datos_filtro_producto($id){
        //Se borran los condicionales que hay en BD
        $this->db->delete('filtros_creados_productos', array('id_filtro' => $id));
    }

    function actualizar_condicional($datos){        
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('filtros_creados_condiciones', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    function actualizar_campos($datos){        
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('filtros_creados_campos', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }
	
	function cargar_informacion_filtro($id_filtro){
		$sql =
		"SELECT
		filtros_creados.intCodigo,
		filtros_creados.strNombre,
		filtros_creados.es_reporte,
		filtros_creados.es_sistema,
		filtros_creados.es_cliente,
		filtros_creados.busqueda_rapida,
		filtros_creados.id_asociado,
		filtros_creados.privado,
		filtros_creados.Estado,
		filtros_creados.id_usuario,
		(SELECT
		COUNT(filtros_creados_campos.intCodigo)
		FROM
		filtros_creados_campos
		WHERE
		filtros_creados_campos.id_filtro = filtros_creados.intCodigo) AS Total_Campos
		FROM
		filtros_creados
		WHERE
		filtros_creados.intCodigo = {$id_filtro}";
		return $this->db->query($sql)->row();
	}

    function cargar_filtros_actualizar($id){
        $this->db->where('intCodigo', $id);
        $this->db->select('*');

        return $this->db->get('filtros_creados')->row();
    }

    function cargar_condiciones_actualizar($id){
        $this->db->where('id_filtro', $id);
        $this->db->select('*');

        return $this->db->get('filtros_creados_condiciones')->result();
    }

    function cargar_condiciones_productos_actualizar($id){
        $this->db->where('id_filtro', $id);
        $this->db->select('*');

        return $this->db->get('filtros_creados_productos')->result();
    }
    
    function cargar_campos_actualizar($id){
        $this->db->where('id_filtro', $id);
        $this->db->select('*');

        return $this->db->get('filtros_creados_campos')->result();
    }

    function listar_condiciones($id_campo){
        //Primero obtenemos el id del tipo de filtro del campo
        $this->db->where('intCodigo', $id_campo);
        $this->db->select('id_filtro_tipo');
        $resultado = $this->db->get('filtro_campos')->row();
        $id_tipo_filtro = $resultado->id_filtro_tipo;

        //Ahora consultamos las condiciones para ese tipo de filtro
        $this->db->select('*');
        $this->db->where('id_filtro_tipo', $id_tipo_filtro);
        
        //Retornamos el resultado
        return $this->db->get('filtro_condiciones')->result();
    }
}
/* Fin del archivo filtro_model.php */
/* Ubicación: ./application/models/filtro_model.php */