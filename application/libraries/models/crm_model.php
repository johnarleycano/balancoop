<?php
/**
 * Modelo encargado de gestionar toda la informacion obtenida de
 * los filtros
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Crm_model extends CI_Model{
    function consultar_productos_asociado($documento){
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
        clientes_productos.ano AS Anio
        FROM
        clientes_productos
        LEFT JOIN productos ON clientes_productos.id_producto = productos.intCodigo
        LEFT JOIN productos_lineas ON productos.id_linea = productos_lineas.intCodigo
        LEFT JOIN productos_categorias ON productos.id_categoria = productos_categorias.intCodigo
        WHERE
        clientes_productos.id_cliente = {$documento}";

        return $this->db->query($sql)->result();
    }

    function consultar_asociados_producto($producto){
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
        din_agencias.strNombre AS Oficina
        FROM
        productos
        INNER JOIN clientes_productos ON clientes_productos.id_producto = productos.intCodigo
        INNER JOIN din_agencias ON clientes_productos.id_agencia = din_agencias.intCodigo
        WHERE
                        productos.strNombre LIKE '%{$producto}%'
        GROUP BY
        clientes_productos.id_cliente";

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
        $sql_condicion =
            "SELECT
            filtros_creados.intCodigo,
            filtro_campos.Nombre_Campo,
            filtro_campos.RelacionCampo,
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

            //Se almacenan los campos en un arreglo
            $condiciones = $this->db->query($sql_condicion)->result();

            $consulta = "";
            $relaciones_campos = "";
            $cont = 1;
            // campos relaciones
            //Consulta que traerá los campos del filtro
            $sql_campos =
                "SELECT
                filtro_campos.Nombre_Campo,
                filtro_campos.RelacionCampo
                FROM
                filtro_campos
                Left JOIN filtros_creados_campos ON filtros_creados_campos.id_filtro_campo = filtro_campos.intCodigo
                WHERE
                filtros_creados_campos.id_filtro = $id_filtro";
            $contc = 1;    
            
            //Se almacenan los campos en un arreglo
            $campos = $this->db->query($sql_campos)->result();
            
            $variable = ""; 
               
            //Recorrido de condiciones
            foreach ($condiciones as $condicion) { 
                
                foreach ($campos as $campo) {                               
                    //Agregamos condicionales
                    if($campo->RelacionCampo != ""){
                        if($campo->Nombre_Campo != $condicion->Nombre_Campo ){
                            $relaciones_campos .= "$campo->RelacionCampo  "; 
                            $campo->RelacionCampo = "";                                                           
                        }//if                    
                    }                
                    //Se aumenta el contador
                    $contc++;
                }//Foreach campos

                if($variable != $condicion->Nombre_Campo){
                    $relaciones_campos .= "$condicion->RelacionCampo  ";
                    $variable = $condicion->Nombre_Campo;
                }

                //Agregamos las condiciones una a una, concatenándolas
                $consulta .= " $condicion->Nombre_Campo $condicion->consulta1$condicion->detalle$condicion->consulta2";

                //Si hay más de un registro
                if($cont != count($condiciones)){
                    //Se agrega un and
                    $consulta .= " AND ";
                }//if

            //Se aumenta el contador
            $cont++;
        }//Foreach

////////////////////////////////// campos relaciones

            //se agrega el where
            $consulta = $relaciones_campos .'  WHERE '.    $consulta;
            //Se retorna toda la consulta
            return $consulta;
    }

	function cargar_busquedas_rapidas($campo){
        // Consulta SQL
        $sql =
        "SELECT
            filtros_creados.strNombre,
            filtros_creados.intCodigo,
            filtros_creados.es_reporte,
            filtros_creados.es_sistema,
            filtros_creados.es_cliente,
            filtros_creados.busqueda_rapida,
            filtros_creados.id_asociado,
            filtros_creados.privado,
            filtros_creados.Estado,
            filtros_creados.id_usuario
        FROM
            filtros_creados
        WHERE
            filtros_creados.privado = '0' AND
            filtros_creados.id_asociado = '{$this->session->userdata('id_usuario')}' AND
            filtros_creados.{$campo} = '1' AND 
            filtros_creados.Estado = 1
        ORDER BY filtros_creados.strNombre ";

        // Se retorna el resultado de la consulta
        return $this->db->query($sql)->result();
    }

    function listar_crm($campos, $condiciones){
        ini_set("memory_limit","2048M");  

        $relacion_campana = "";
        $relacion_oportunidad = "";
        $relacion_producto = "";                                  

        $buscar = "productos";
        $resultado = strpos($campos, $buscar);
        if($resultado !== FALSE){
            $relacion_producto = " 
            Left Join clientes_productos ON asociados.id_Asociado = clientes_productos.id_cliente
            Left Join productos ON productos.intCodigo = clientes_productos.id_producto ";
        }else{
            $buscar = "productos";
            $resultado = strpos($condiciones, $buscar);
            if($resultado !== FALSE){
                $relacion_producto = " 
                Left Join clientes_productos ON asociados.id_Asociado = clientes_productos.id_cliente
                Left Join productos ON productos.intCodigo = clientes_productos.id_producto ";
            }
        }

        $buscar1 = "oportunidad";
        $resultado1 = strpos($campos, $buscar1);
        if($resultado1 !== FALSE){
            $relacion_oportunidad = " 
            Left Join oportunidad_x_cliente ON asociados.id_Asociado = oportunidad_x_cliente.id_cliente ";                                           
        }else{
            $buscar1 = "oportunidad";
            $resultado1 = strpos($condiciones, $buscar1);
            if($resultado1 !== FALSE){
                $relacion_oportunidad = " 
                Left Join oportunidad_x_cliente ON asociados.id_Asociado = oportunidad_x_cliente.id_cliente ";
            }
        }

        $buscar2 = "campanas";
        $resultado2 = strpos($campos, $buscar2);
        if($resultado2 !== FALSE){
            $relacion_campana = "
            Left Join clientes_productos ON asociados.id_Asociado = clientes_productos.id_cliente
            Left Join productos ON productos.intCodigo = clientes_productos.id_producto
            Left Join oportunidad_x_cliente ON asociados.id_Asociado = oportunidad_x_cliente.id_cliente              
            Left Join campanas ON campanas.intCodigo = oportunidad_x_cliente.id_campana 
            Left Join clientes_campanas ON asociados.id_Asociado = clientes_campanas.id_cliente
            Left Join campanas AS campana_cliente ON campana_cliente.intCodigo = clientes_campanas.id_campana
            Left Join din_agencias AS agenciaproductos ON agenciaproductos.intCodigo = clientes_productos.id_agencia
            Left Join crm_campanas_tipo ON crm_campanas_tipo.id_campana_tipo = campana_cliente.tipo_campana
            Left Join asociados_cargos ON asociados.id_Asociado = asociados_cargos.id_Asociado
            Left Join cargos ON cargos.intCodigo = asociados_cargos.id_cargo ";
            $relacion_oportunidad = "";
            $relacion_producto = "";
        }else{
            $buscar2 = "campanas";
            $resultado2 = strpos($condiciones, $buscar2);
            if($resultado2 !== FALSE){
                $relacion_campana = " 
                Left Join clientes_productos ON asociados.id_Asociado = clientes_productos.id_cliente
                Left Join productos ON productos.intCodigo = clientes_productos.id_producto
                Left Join oportunidad_x_cliente ON asociados.id_Asociado = oportunidad_x_cliente.id_cliente 
                Left Join campanas ON campanas.intCodigo = oportunidad_x_cliente.id_campana 
                Left Join clientes_campanas ON asociados.id_Asociado = clientes_campanas.id_cliente
                Left Join campanas AS campana_cliente ON campana_cliente.intCodigo = clientes_campanas.id_campana
                Left Join din_agencias AS agenciaproductos ON agenciaproductos.intCodigo = clientes_productos.id_agencia
                Left Join crm_campanas_tipo ON crm_campanas_tipo.id_campana_tipo = campana_cliente.tipo_campana
                Left Join asociados_cargos ON asociados.id_Asociado = asociados_cargos.id_Asociado
                Left Join cargos ON cargos.intCodigo = asociados_cargos.id_cargo ";
                $relacion_oportunidad = "";
                $relacion_producto = "";
            } 
        }       


        $sql = 
        "SELECT 
            {$campos}
        FROM
            asociados            
            $relacion_campana
            $relacion_oportunidad
            $relacion_producto                                   

            {$condiciones}";
        //return $sql;
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