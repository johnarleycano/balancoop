<?php
/**
 * Modelo encargado de gestionar toda la informacion relacionada al balance social
 * 
 * @author 		       John Arley Cano Salinas
 * @author 		       Oscar Humberto Morales
 */
Class Balance_model extends CI_Model{
    function actualizar($datos, $id_variable){
        $this->db->where('intCodigo', $id_variable);
        if($this->db->update('estructuras', $datos)){
            //Retorna verdadero
            return true;
        }
    }

    function actualizar_peso($id, $valor){
        $this->db->where('intCodigo', $id);
        if($this->db->update('estructuras', array('peso' => $valor))){
            //Retorna verdadero
            return true;
        }
    }

    function borrar_valores_reales($id_balance, $datos){
        $this->db->where('id_balance', $id_balance);

        if($this->db->update('estructuras', $datos)){
            //Retorna verdadero
            return 'true';
        }
    }

    function cargar($tipo, $anio, $id_conector, $id_oficina){
        //Id de oficina cuando se seleccionan todas
        $oficina = "";

        //Si 
        if ($id_oficina != "0") {
            $oficina = " AND balances.id_agencia = {$id_oficina} ";
        }

        // Si tiene conector
        if ($id_conector) { $conector = " AND estructuras.id_conector = {$id_conector}";}else{$conector = "";}
        
        $sql =
        "SELECT
        *
        FROM
        balances
        INNER JOIN estructuras ON estructuras.id_balance = balances.id_balance
        WHERE
        balances.Estado = 1 AND
        estructuras.tipo = '{$tipo}' AND
        balances.id_empresa = {$this->session->userdata('id_empresa')}
        AND balances.ano = {$anio}
        {$conector}
        {$oficina}";

        return $this->db->query($sql)->result();
    }

    /**
     * [cargar_estructuras description]
     * @param  [type] $tipo        [description]
     * @param  [type] $id_balance  [description]
     * @param  [type] $id_conector [description]
     * @param  [type] $id_oficina  [description]
     * @return [type]              [description]
     */
    function cargar_estructuras($tipo, $id_balance, $id_conector, $id_oficina){
       //Id de oficina cuando se seleccionan todas
        $oficina = "";

        //Si trae oficina 
        if ($id_oficina != "0") { $oficina = " AND balances.id_agencia = {$id_oficina} "; }

        // Si tiene conector
        if ($id_conector) { $conector = " AND estructuras.id_conector = {$id_conector}";}else{$conector = "";}
        
        $sql =
        "SELECT
        *
        FROM
        estructuras
        INNER JOIN balances ON estructuras.id_balance = balances.id_balance
        WHERE
        estructuras.tipo = '{$tipo}' 
        AND balances.id_balance = {$id_balance} 
        {$oficina} 
        {$conector}";

        return $this->db->query($sql)->result();
    }

    function cargar_balances($anio){
        $sql =
        "SELECT
        balances.id_balance,
        balances.ano,
        din_agencias.strNombre
        FROM
        balances
        INNER JOIN din_agencias ON balances.id_agencia = din_agencias.intCodigo
        WHERE
        balances.ano = {$anio} AND
        balances.id_empresa = {$this->session->userdata('id_empresa')}";

        return $this->db->query($sql)->result();
    }

    function cargar_variables_usuario($anio, $id_oficina, $tipo){
        switch ($tipo) {
            case 'C':
                $tipo = "GROUP BY id_categoria";
                break;

            case null:
                $tipo = "";
                break;
        }
        //Id de oficina cuando se seleccionan todas
        $oficina = "";

        //Si 
        if ($id_oficina != "0") {
            $oficina = " AND balances.id_agencia = {$id_oficina} ";
        }

        $sql =
        "SELECT
        estructuras.intCodigo AS id_variable,
        estructuras.id_conector AS conector,
        (SELECT
        estructuras.intCodigo
        FROM
        estructuras
        WHERE
        estructuras.intCodigo = conector) AS id_dimension,
        (SELECT
        estructuras.id_conector
        FROM
        estructuras
        WHERE
        estructuras.intCodigo =id_dimension) as id_categoria,
        estructuras.strNombre
        FROM
        balances
        INNER JOIN estructuras ON estructuras.id_balance = balances.id_balance
        WHERE
        balances.Estado = 1 AND
        balances.id_empresa = {$this->session->userdata('id_empresa')} AND
        balances.ano = {$anio} AND
        estructuras.modo_ingreso = 1 AND
        estructuras.fuente = {$this->session->userdata('id_usuario')}
        {$oficina}
        {$tipo}";
        
        return $this->db->query($sql)->result();
    }

    /**
     * [cargar_variable description]
     * @param  [type] $id_variable [description]
     * @return [type]              [description]
     */
    function cargar_variable($id_variable){
        $this->db->where('intCodigo', $id_variable);
        $this->db->select('*');
        return $this->db->get('estructuras')->row();
    }

    function cargar_variable_reporte($id_variable){
        $sql =
        "SELECT
        estructuras.intCodigo,
        estructuras.id_conector,
        estructuras.strNombre,
        estructuras.descripcion,
        estructuras.tipo,
        estructuras.peso,
        estructuras.id_balance,
        estructuras.modo_ingreso,
        estructuras.fuente,
        estructuras.id_variable_comparacion,
        SUM(e_p + f_p + mr_p + a_p + m_p + j_p + jl_p + ag_p + s_p + o_p + n_p + d_p) AS Presupuestado,
        SUM(e_r + f_r + mr_r + a_r + m_r + j_r + jl_r + ag_r + s_r + o_r + n_r + d_r ) AS Reales
        FROM
        estructuras
        WHERE
        estructuras.intCodigo = {$id_variable}";

        return $this->db->query($sql)->row();
    }

    function cargar_filtros(){
        $sql =
        "SELECT
        filtros_creados.intCodigo,
        filtros_creados.strNombre
        FROM
        filtros_creados
        INNER JOIN usuarios_sistema ON filtros_creados.id_asociado = usuarios_sistema.intCodigo
        WHERE
        usuarios_sistema.id_empresa = {$this->session->userdata('id_empresa')}
        ORDER BY filtros_creados.strNombre";

        return $this->db->query($sql)->result();
    }
    
    function consultar($id_variable){
        $this->db->where('intCodigo', $id_variable);
        $this->db->select('*');
        $resultado = $this->db->get('estructuras')->row();

        return $resultado->id_conector;
    }

    function consultar_balance($anio, $id_oficina){

        $this->db->where('ano', $anio);
        $this->db->where('id_agencia', $id_oficina);
        $this->db->select('*');
        
        return $this->db->get('balances')->row();
    }

    function consultar_estructuras($id_balance){
        // $this->db->where('tipo', $tipo);
        $this->db->where('id_balance', $id_balance);
        return $this->db->get('estructuras')->result();
    }

    function crear($tipo, $datos){
        switch ($tipo) {
            case 'balance':
                //Se ejecuta el modelo que guarda los datos
                $guardar = $this->db->insert('balances', $datos);
                break;
            
            default:
                # code...
                break;
        }//suiche

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return 'true';
        }
    }

    function guardar($datos){
        //Se ejecuta el modelo que guarda los datos
        $guardar = $this->db->insert('estructuras', $datos);

        //Si el registro es exitoso
        if($guardar){
            //Retorna verdadero
            return true;
        }
    }
    
    function listar_anios(){
        $sql =
        "SELECT
        id_balance,
        ano
        FROM
        balances
        WHERE
        balances.ano > 1
        GROUP BY
        balances.ano";

        return $this->db->query($sql)->result();
    }

    function validar($datos){
        $this->db->where($datos);

        $resultado = $this->db->get('balances')->row();

        //Si retorna un registro
        if (count($resultado) == 1) {
            return $resultado->id_balance;
        }else{
            return 'false';
        }
    }
}
/* Fin del archivo balance_model.php */
/* Ubicación: ./application/models/balance_model.php */