<?php
/**
 * Modelo encargado de gestionar toda la informacion que pueda ser usada en
 * cualquier parte de la aplicación
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Listas_model extends CI_Model{
    function cargar($tabla){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->order_by('strNombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get($tabla)->result();
    }

    function cargar_activos($tabla){
		//Columnas a retornar
        $this->db->where('Estado', '1');
        $this->db->select('*');
        $this->db->order_by('strNombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get($tabla)->result();
	}

    function cargar_campanas($id_empresa){
        //Columnas a retornar
        $this->db->where('id_empresa', $id_empresa);
        $this->db->select('*');
        $this->db->order_by('strNombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get('campanas')->result();
    }

    function cargar_datos_usuario($id_usuario){
         //Columnas a retornar
         $this->db->select('*');
         $this->db->where('intCodigo', $id_usuario);


        //Se ejecuta y retorna la consulta
        return $this->db->get('usuarios_sistema')->row();
    }

    function cargar_empresa($tabla, $id_empresa){
        //Columnas a retornar
        $this->db->where('Estado', '1');
        $this->db->where('id_empresa', $id_empresa);
        $this->db->select('*');
        $this->db->order_by('strNombre');
        
        //Se ejecuta y retorna la consulta
        return $this->db->get($tabla)->result();
    }

	function cargar_paises(){
        //Columnas a retornar
        $this->db->select('*');
        $this->db->order_by('strNombre');
        $this->db->where('strTipo', 'P');

        //Se ejecuta y retorna la consulta
        return $this->db->get('regiones')->result();
	}

    function cargar_departamentos($codigo_pais){
        $codigo_paisc= substr($codigo_pais, 0, 4);
        // Consulta SQL
        $sql =
        "SELECT
            *
        FROM
            regiones
        WHERE
            regiones.strTipo = 'D' AND
            regiones.strCodigo LIKE '{$codigo_paisc}%'

        ORDER BY
            regiones.strNombre ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_ciudades($codigo_departamento){
        $codigo_departamentoc= substr($codigo_departamento, 0, 6);
        // Consulta SQL
        $sql =
        "SELECT
            *
        FROM
            regiones
        WHERE
            regiones.strTipo = 'C' AND
            regiones.strCodigo LIKE '{$codigo_departamentoc}%'
        ORDER BY
            regiones.strNombre ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function cargar_barrios($codigo_ciudad){
        $codigo_ciudadc= substr($codigo_ciudad, 0, 9);
        // Consulta SQL
        $sql =
        "SELECT
            *
        FROM
            regiones
        WHERE
            regiones.strTipo = 'B' AND
            regiones.strCodigo LIKE '{$codigo_ciudadc}%'
        ORDER BY
            regiones.strNombre ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function guardar($datos, $tabla){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert($tabla, $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    function actualizar($datos, $tabla, $campo, $id_campo){
        //Se ejecuta el modelo que guarda los datos
        $this->db->where($campo, $id_campo);
        $guardar = $this->db->update($tabla, $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }else{
            //Retorna falso
            return false;
        }
    }

    //No utilizada aun
    function listar_campos($tabla){
        // Consulta SQL
        $sql = 
        "SELECT /*SO.NAME,*/ SC.NAME as Nombre
        FROM sys.objects SO INNER JOIN sys.columns SC
        ON SO.OBJECT_ID = SC.OBJECT_ID
        WHERE SO.TYPE = 'U' AND SO.NAME = '{$tabla}'
        ORDER BY SC.NAME";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function listar_dias(){
        //Se crea un arreglo
        $dias = array();

        for ($dia = 1; $dia < 32; $dia++) { 
            array_push($dias, str_pad($dia, 2 , "0", STR_PAD_LEFT));
        }//Fin for

        //Se retorna el arreglo
        return $dias;
    }//Fin listar_dias

    /**
     * Lista los meses del año
     * @return [array] [meses con número y nombre, además del número de columna
     * para efectos del reporte]
     */
    function listar_meses(){
        //Se crea un arreglo de dos dimensiones con la informacion de cada mes
        $meses = array(
            array('Numero' => "01", 'Nombre' => 'Enero', 'Columna' => 'B'),
            array('Numero' => "02", 'Nombre' => 'Febrero', 'Columna' => 'C'),
            array('Numero' => "03", 'Nombre' => 'Marzo', 'Columna' => 'D'),
            array('Numero' => "04", 'Nombre' => 'Abril', 'Columna' => 'E'),
            array('Numero' => "05", 'Nombre' => 'Mayo', 'Columna' => 'F'),
            array('Numero' => "06", 'Nombre' => 'Junio', 'Columna' => 'G'),
            array('Numero' => "07", 'Nombre' => 'Julio', 'Columna' => 'H'),
            array('Numero' => "08", 'Nombre' => 'Agosto','Columna' => 'I'),
            array('Numero' => "09", 'Nombre' => 'Septiembre', 'Columna' => 'J'),
            array('Numero' => "10", 'Nombre' => 'Octubre', 'Columna' => 'K'),
            array('Numero' => "11", 'Nombre' => 'Noviembre', 'Columna' => 'L'),
            array('Numero' => "12", 'Nombre' => 'Diciembre', 'Columna' => 'M')
        );

        //Se retorna el arreglo
        return $meses;
    }//Fin listar_meses


    function listar_anios(){
        //Se crea un arreglo
        $anios = array();

        //Se declaran los rangos de años
        $anio_actual = date ("Y") + 1;
        $anio_inicial = $anio_actual - 100;
        

        //Recorrido por años
        for ($anio = $anio_inicial; $anio < $anio_actual; $anio++) { 
            //Se agrega el año al arreglo
            array_push($anios, $anio);
        }//Fin for

        //Se retorna el arreglo
        return $anios;

        //Se crea un array con los años
        $anios = array( '2010', '2011', '2012', '2013', '2014');

        //Se retorna el array
        return $anios;
    }

    function obtener_nombre_oficina($id_oficina){
        $this->db->select('strNombre');
        $this->db->where('intCodigo', $id_oficina);
        $resultado = $this->db->get('din_agencias')->row();

        return $resultado->strNombre;
    }

    function obtener_nombre_campo($tabla, $id){
        //Columna a retornar
        $this->db->select('strNombre');
        
        //Condición de id
        $this->db->where('intCodigo', $id);
        
        //Se ejecuta  
        $resultado = $this->db->get($tabla)->row();
        
        //Se retorna el nombre del campo
        return $resultado->strNombre;
    }
}
/* Fin del archivo listas_model.php */
/* Ubicación: ./application/models/listas_model.php */