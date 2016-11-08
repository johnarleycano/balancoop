<?php
/**
 * Modelo encargado de gestionar toda la informacion obtenida de
 * los filtros
 * 
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Crm_model extends CI_Model{
    function array2csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}

function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download  
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}

    function consultar_productos_asociado($id_producto, $contiene, $id_genero, $id_oficina, $anio){
        ini_set("memory_limit","20048M");

        // El signo será diferente
        $signo = "=";
        $oficina = "";
        $anio_consulta = "";

        // Si lo contiene
        if ($contiene != '1') {
            // El signo será diferente
            $signo = "<>";
        }

        // Si trae oficina
        if ($id_oficina > 0) {
            $oficina = " AND clientes_productos.id_agencia = '{$id_oficina}' ";
        }

        // Si trae año
        if ($anio > 0) {
            $anio_consulta = " AND clientes_productos.ano = '{$anio}' ";
        }

        $sql =
        "SELECT
            clientes_productos.id_cliente,
            clientes_productos.Nombre,
            clientes_productos.PrimerApellido,
            clientes_productos.SegundoApellido,
            clientes_productos.CorreoElectronico,
            clientes_productos.TelefonoCasa,
            clientes_productos.Celular_cliente,
            clientes_productos.TelefonoOficina,
            clientes_productos.ano,
            clientes_productos.mes,
            clientes_productos.dia
        FROM
            clientes_productos
        WHERE
            clientes_productos.id_empresa = '{$this->session->userdata('id_empresa')}'
            AND clientes_productos.id_producto {$signo} '{$id_producto}'
            AND clientes_productos.id_Genero_cliente = {$id_genero}
            {$oficina}
            {$anio_consulta}";

        return $this->db->query($sql)->result();
    }

    function consultar_productos_documento($documento){
        $sql =
        "SELECT
            productos.intCodigo,
            productos.strNombre,
            productos_lineas.strNombre AS Linea,
            productos_categorias.strNombre AS Categoria,
            clientes_productos.cantidad AS Cantidad,
            clientes_productos.valor AS Valor,
            clientes_productos.transferencia,
            clientes_productos.mes AS Mes,
            clientes_productos.ano AS Anio,
            clientes_productos.id_Genero_cliente,
            clientes_productos.Nombre,
            clientes_productos.PrimerApellido,
            clientes_productos.SegundoApellido,
            clientes_productos.Celular_cliente,
            clientes_productos.TelefonoCasa,
            clientes_productos.TelefonoOficina,
            clientes_productos.CorreoElectronico,
            din_agencias.strNombre AS oficina
        FROM
            clientes_productos
            LEFT JOIN productos ON clientes_productos.id_producto = productos.intCodigo
            LEFT JOIN productos_lineas ON productos.id_linea = productos_lineas.intCodigo
            LEFT JOIN productos_categorias ON productos.id_categoria = productos_categorias.intCodigo
            LEFT JOIN din_agencias ON clientes_productos.id_agencia = din_agencias.intCodigo
        WHERE
            clientes_productos.id_cliente = {$documento}  AND
            clientes_productos.id_empresa = '{$this->session->userdata('id_empresa')}'";

        return $this->db->query($sql)->result();
    }

    function consultar_asociados_producto($id_producto){
        $sql =
        "SELECT
            productos.intCodigo,
            clientes_productos.id_cliente,
            clientes_productos.Nombre,
            clientes_productos.PrimerApellido,
            clientes_productos.SegundoApellido,
            clientes_productos.Celular_cliente,
            clientes_productos.CorreoElectronico,
            clientes_productos.TelefonoCasa,
            clientes_productos.TelefonoOficina,
            din_agencias.strNombre AS Oficina,
            productos_categorias.strNombre AS Linea,
            productos_lineas.strNombre AS Categoria,
            clientes_productos.valor,
            clientes_productos.transferencia,
            clientes_productos.ano,
            clientes_productos.mes,
            clientes_productos.id_Genero_cliente
        FROM
            productos
        LEFT JOIN clientes_productos ON clientes_productos.id_producto = productos.intCodigo
        LEFT JOIN din_agencias ON clientes_productos.id_agencia = din_agencias.intCodigo
        LEFT JOIN productos_lineas ON productos.id_linea = productos_lineas.intCodigo
        LEFT JOIN productos_categorias ON productos.id_categoria = productos_categorias.intCodigo
        WHERE productos.intCodigo = {$id_producto}";

        return $this->db->query($sql)->result();
    }

    function listar_campos($id_filtro){
        //Consulta que traerá los campos del filtro
        $sql_campos =
        "SELECT
        filtro_campos.Nombre_Campo
        FROM
        filtro_campos
        Left JOIN filtros_creados_campos ON filtros_creados_campos.id_filtro_campo = filtro_campos.intCodigo
        WHERE
        filtros_creados_campos.id_filtro = $id_filtro";

        //Se almacenan los campos en un arreglo
        $campos = $this->db->query($sql_campos)->result();

        $consulta = '';
        $cont = 1;

        //Recorrido de campos
        foreach ($campos as $campo) {
            //Agregamos los campos una a una, concatenándolas
            $consulta .= "$campo->Nombre_Campo";

            //Si hay más de un registro
            if($cont != count($campos)){
                //Se agrega una coma
                $consulta .= ", ";
            }//if

            //Se aumenta el contador
            $cont++;
        }//Foreach campos

        //Se retorna el strging con los nombres de los campos
        return $consulta;
    }

    function listar_condiciones($id_filtro){
        // Variables
        $consulta = "";
        $relaciones_campos = "";
        $cont = 1;
        $variable= "";

        $sql_condicion =
            "SELECT
                filtros_creados.intCodigo,
                filtro_campos.Nombre_Campo,
                filtro_condiciones.consulta1,
                filtros_creados_condiciones.detalle,
                filtro_condiciones.consulta2
            FROM
                filtros_creados
                Left JOIN filtros_creados_condiciones ON filtros_creados_condiciones.id_filtro = filtros_creados.intCodigo
                Left JOIN filtro_condiciones ON filtros_creados_condiciones.id_filtro_condicion = filtro_condiciones.intCodigo
                Left JOIN filtro_campos ON filtro_campos.intCodigo = filtros_creados_condiciones.id_filtro_campo            
            WHERE
                filtros_creados.intCodigo = {$id_filtro}";

        $sql_campos =
            "SELECT
                filtro_campos.Nombre_Campo,
                filtro_campos.RelacionCampo
            FROM
                filtro_campos
                Left JOIN filtros_creados_campos ON filtros_creados_campos.id_filtro_campo = filtro_campos.intCodigo
            WHERE
                filtros_creados_campos.id_filtro = {$id_filtro}";

            //Se almacenan los campos en un arreglo
            $condiciones = $this->db->query($sql_condicion)->result();

            //Se almacenan los campos en un arreglo
            $campos = $this->db->query($sql_campos)->result();

            //Recorrido de condiciones
            foreach ($condiciones as $condicion) {
                $consulta .= " $condicion->Nombre_Campo $condicion->consulta1$condicion->detalle$condicion->consulta2";

                //Si hay más de un registro
                if($cont != count($condiciones)){
                    //Se agrega un and
                    $consulta .= " AND ";
                }//if

                $cont++;
            } // foreach

            //se agrega el where de empresa
            $consulta = $relaciones_campos .'  WHERE asociados.id_Empresa = '.$this->session->userdata('id_empresa').' AND '.    $consulta;

            //Se retorna toda la consulta
            return $consulta;
    }

    function listar_relaciones($id_filtro){
        $consulta = '';

        // Relaciones de los campos
        $sql_campos =
        "SELECT
            filtro_campos.RelacionCampo
        FROM
            filtros_creados_campos
            INNER JOIN filtro_campos ON filtros_creados_campos.id_filtro_campo = filtro_campos.intCodigo
        WHERE
            filtro_campos.RelacionCampo IS NOT NULL AND
            filtros_creados_campos.id_filtro = {$id_filtro}
        GROUP BY
            filtro_campos.RelacionCampo";
        
        // Relaciones de las condiciones
        $sql_condiciones =
            "SELECT
                filtro_campos.RelacionCampo
            FROM
                filtros_creados_condiciones
                LEFT JOIN filtro_campos ON filtro_campos.intCodigo = filtros_creados_condiciones.id_filtro_campo
            WHERE
                filtro_campos.RelacionCampo IS NOT NULL AND
                filtros_creados_condiciones.id_filtro = {$id_filtro}
            GROUP BY
                filtro_campos.RelacionCampo";

        // Se ejecutan ambas consultas
        $condiciones = $this->db->query($sql_condiciones)->result();
        $campos = $this->db->query($sql_campos)->result();

        // Se unen los arrays y se recorren para mandar una cadena de texto
        foreach (array_merge($condiciones, $campos) as $relacion) {
            // Agregamos las relaciones una a una, concatenándolas
            $consulta .= " $relacion->RelacionCampo ";
        }//Foreach relaciones de condiciones

        //Se retorna el strging con los nombres de los campos
        return $consulta;
    }
	
	function cargar_filtros_segmentacion($tipo){
		// Si el tipo no es filtro de sistema
		if($tipo != "es_sistema"){
			$filtro_empresa = "AND usuarios_sistema.id_empresa = '{$this->session->userdata("id_empresa")}'";
		}else{
			$filtro_sistema = "";
		}
	
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
			filtros_creados
			INNER JOIN usuarios_sistema ON filtros_creados.id_usuario = usuarios_sistema.intCodigo
			INNER JOIN filtros_creados_campos ON filtros_creados_campos.id_filtro = filtros_creados.intCodigo
		WHERE
			filtros_creados.{$tipo} = '1'
			{$filtro_sistema}
		GROUP BY
			filtros_creados.intCodigo
		ORDER BY filtros_creados.strNombre";
		
		// Se retorna el resultado de la consulta
		return $this->db->query($sql)->result();
	}

	function cargar_busquedas_rapidas($campo){
        // Consulta SQL
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
		filtros_creados
		INNER JOIN usuarios_sistema ON filtros_creados.id_usuario = usuarios_sistema.intCodigo
		WHERE
		filtros_creados.privado = '0' AND
		#filtros_creados.id_asociado = '{$this->session->userdata('id_empresa')}' AND
		filtros_creados.{$campo} = '1' AND
		filtros_creados.Estado = '1' AND
		usuarios_sistema.id_empresa = '{$this->session->userdata('id_empresa')}'
		ORDER BY
		filtros_creados.strNombre ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function listar_crm($campos, $relaciones, $condiciones){
        ini_set("memory_limit","20048M");  
        $sql = 
        "SELECT 
            {$campos}
        FROM
            asociados 
            {$relaciones}
            {$condiciones}
        ORDER BY
            asociados.Nombre ASC,
            asociados.PrimerApellido ASC";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function listar_crm_productos($campos, $condiciones){
        ini_set("memory_limit","2048M");  

        $sql = 
        "SELECT
        productos.intCodigo,
        productos.strNombre AS producto,
        proveedores.strNombre AS proveedor,
        productos_categorias.strNombre AS categoria,
        productos_lineas.strNombre AS linea,
        clientes_productos.id_cliente
        FROM
        productos
        LEFT JOIN proveedores ON productos.id_proveedor = proveedores.intCodigo
        LEFT JOIN productos_categorias ON productos.id_categoria = productos_categorias.intCodigo
        LEFT JOIN productos_lineas ON productos.id_linea = productos_lineas.intCodigo
        RIGHT JOIN clientes_productos ON clientes_productos.id_producto = productos.intCodigo
        {$condiciones}
        GROUP BY
        clientes_productos.id_cliente";
        //return $sql;
        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function Actualizar_edades(){
        ini_set("memory_limit","2048M");
        // Consulta para actualizar edad_Cliente tabla asociados
        $sql = 
        "update asociados
        set Edad_Cliente =(SELECT   CASE 
            WHEN (MONTH(asociados.FechaNacimiento) < MONTH(current_date)) THEN YEAR(current_date) - YEAR(asociados.FechaNacimiento) 
            WHEN (MONTH(asociados.FechaNacimiento) = MONTH(current_date)) AND (DAY(asociados.FechaNacimiento) <= DAY(current_date)) 
            THEN YEAR(current_date) - YEAR(asociados.FechaNacimiento) ELSE (YEAR(current_date) - YEAR(asociados.FechaNacimiento)) - 1 
        END as Edad_Cliente)";

        //Se ejecuta la consulta
        $resultado = $this->db->query($sql);

        // Consulta para actualizar edad_Conyugue tabla asociados
        $sqlconyugue = 
        "update asociados
        set Edad_Conyugue =(SELECT  CASE 
            WHEN (MONTH(asociados.FechaNacimiento_Conyugue) < MONTH(current_date)) THEN YEAR(current_date) - YEAR(asociados.FechaNacimiento_Conyugue) 
            WHEN (MONTH(asociados.FechaNacimiento_Conyugue) = MONTH(current_date)) AND (DAY(asociados.FechaNacimiento_Conyugue) <= DAY(current_date)) 
            THEN YEAR(current_date) - YEAR(asociados.FechaNacimiento_Conyugue) ELSE (YEAR(current_date) - YEAR(asociados.FechaNacimiento_Conyugue)) - 1 
        END as Edad_Conyugue)";

        //Se ejecuta la consulta
        $resultado = $this->db->query($sqlconyugue);

        // Consulta para actualizar edad_Conocidos tabla asociados
        $sqlconocidos = 
        "update asociados_conocidos
        set Edad =(SELECT   CASE 
            WHEN (MONTH(asociados_conocidos.FechaNacimiento) < MONTH(current_date)) THEN YEAR(current_date) - YEAR(asociados_conocidos.FechaNacimiento) 
            WHEN (MONTH(asociados_conocidos.FechaNacimiento) = MONTH(current_date)) AND (DAY(asociados_conocidos.FechaNacimiento) <= DAY(current_date)) 
            THEN YEAR(current_date) - YEAR(asociados_conocidos.FechaNacimiento) ELSE (YEAR(current_date) - YEAR(asociados_conocidos.FechaNacimiento)) - 1 
        END as Edad)";

        //Se ejecuta la consulta
        $resultado = $this->db->query($sqlconocidos);

        // Consulta para actualizar edad_hijos tabla asociados
        $sqlhijos = 
        "update asociados_hijos
        set Edad =(SELECT   CASE 
            WHEN (MONTH(asociados_hijos.FechaNacimiento) < MONTH(current_date)) THEN YEAR(current_date) - YEAR(asociados_hijos.FechaNacimiento) 
            WHEN (MONTH(asociados_hijos.FechaNacimiento) = MONTH(current_date)) AND (DAY(asociados_hijos.FechaNacimiento) <= DAY(current_date)) 
            THEN YEAR(current_date) - YEAR(asociados_hijos.FechaNacimiento) ELSE (YEAR(current_date) - YEAR(asociados_hijos.FechaNacimiento)) - 1 
        END as Edad)";

        //Se ejecuta la consulta
        $resultado = $this->db->query($sqlhijos);

        // Consulta asociados hijos para obtener id_asociados a actualizar
        $sqlidasociadoshijos = 
        "select DISTINCT id_asociado from asociados_hijos";

        //Se ejecuta la consulta
        $campos = $this->db->query($sqlidasociadoshijos)->result();

        $cont = 1;

        //Recorrido de campos
        foreach ($campos as $campo) {
            // Consulta asociados hijos para obtener id_asociados a actualizar
            $sqlasociadoshijos = 
            "update asociados
            set `[Hombres<18]` = (SELECT SUM(CASE WHEN id_Genero = 1 THEN CASE WHEN Edad < 18 THEN 1 ELSE 0 END END) AS masculinomenoredad FROM asociados_hijos WHERE id_Asociado = $campo->id_asociado),
            `[Hombre>18]` = (SELECT SUM(CASE WHEN id_Genero = 1 THEN CASE WHEN Edad >= 18 THEN 1 ELSE 0 END END) AS masculinomayoredad FROM asociados_hijos WHERE id_Asociado = $campo->id_asociado),
            `[Mujeres>18]` = (SELECT SUM(CASE WHEN id_Genero = 2 THEN CASE WHEN Edad >= 18 THEN 1 ELSE 0 END END) AS femeninomenoredad FROM asociados_hijos WHERE id_Asociado = $campo->id_asociado),
            `[Mujeres<18]` = (SELECT SUM(CASE WHEN id_Genero = 2 THEN CASE WHEN Edad < 18 THEN 1 ELSE 0 END END) AS femeninomayoredad FROM asociados_hijos WHERE id_Asociado = $campo->id_asociado)
            WHERE id_Asociado = $campo->id_asociado
            ";

            //Se ejecuta la consulta
            $resultado = $this->db->query($sqlasociadoshijos);
            //Se aumenta el contador
            $cont++;
        }//Foreach campos

        return true;

    }

    function listar_nombres_campos($id_filtro){
        //Consulta que traerá los campos del filtro
        $sql_campos =
        "SELECT
        filtro_campos.strNombre AS Nombre,
        filtro_campos.Nombre_Campo 
        FROM
        filtro_campos
        INNER JOIN filtros_creados_campos ON filtros_creados_campos.id_filtro_campo = filtro_campos.intCodigo
        WHERE
        filtros_creados_campos.id_filtro = $id_filtro";

        //Se almacenan los campos en un arreglo
        return $this->db->query($sql_campos)->result();
    }
    
}
/* Fin del archivo crm_model.php */
/* Ubicación: ./application/models/crm_model.php */