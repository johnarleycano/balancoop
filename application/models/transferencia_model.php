<?php
/**
* Modelo encargado de gestionar toda la informacion que pueda ser usada en
* la transferencia solidaria
* 
* @author 		       John Arley Cano Salinas
* @author 		       Oscar Humberto Morales
*/
Class Transferencia_model extends CI_Model{
	function buscar_asociado($documento, $id_empresa){
        $sql = 
        "SELECT
        *
        FROM
        asociados
        WHERE Identificacion = {$documento}
        AND id_Empresa = '{$id_empresa}'";

        return $this->db->query($sql)->row();
    }

	function listar_anios(){
        $this->db->select('ano');
        $this->db->group_by('ano');
        $this->db->order_by('ano');

        return $this->db->get('clientes_productos')->result();
	}

	function compras_anio_actual($id_empresa, $datos){
		//Id de oficina cuando se seleccionan todas
		$oficina = "";

		//Si 
		if ($datos['id_oficina'] != "0") {
			$oficina = " clientes_productos.id_agencia = {$datos['id_oficina']} AND ";
		}

		$sql =
		"SELECT
			IFNULL(sum(clientes_productos.transferencia),0) AS Total_Compras
		FROM
			clientes_productos
		WHERE
			{$oficina}
			clientes_productos.ano = Date_format(now(),'%Y') AND
			clientes_productos.id_cliente = {$datos['identificacion']} AND
			clientes_productos.id_empresa = {$id_empresa}
		GROUP BY
			clientes_productos.ano";

		$resultado = $this->db->query($sql)->row();

		if ($resultado) {
			return $resultado;
		} else {
			return "false";
		}
	}

	function compras_anio_seleccionado($id_empresa, $datos){
		//Id de oficina cuando se seleccionan todas
		$oficina = "";

		//Si 
		if ($datos['id_oficina'] != "0") {
			$oficina = " clientes_productos.id_agencia = {$datos['id_oficina']} AND ";
		}

		$sql =
		"SELECT
			IFNULL(sum(clientes_productos.transferencia), 0) AS Total_Compras
		FROM
			clientes_productos
		WHERE
			{$oficina}
			clientes_productos.ano = {$datos['anio']} AND
			clientes_productos.id_cliente = {$datos['identificacion']} AND
			clientes_productos.id_empresa = {$id_empresa}
		GROUP BY
			clientes_productos.ano";

		$resultado = $this->db->query($sql)->row();

		if ($resultado) {
			return $resultado;
		} else {
			return "false";
		}
	}

	function compras_ultimos_meses($id_empresa, $datos){
		//Id de oficina cuando se seleccionan todas
		$oficina = "";

		//Si 
		if ($datos['id_oficina'] != "0") {
			$oficina = " clientes_productos.id_agencia = {$datos['id_oficina']} AND ";
		}

		$sql =
		"SELECT
			IFNULL(sum(clientes_productos.transferencia), 0) AS Total_Compras
		FROM
			clientes_productos
		WHERE
			clientes_productos.ano = Date_format(now(),'%Y') AND
			clientes_productos.mes <= DATE_SUB(now(),INTERVAL '90' DAY) AND
			clientes_productos.id_cliente = {$datos['identificacion']} AND
			clientes_productos.id_empresa = {$id_empresa}
		GROUP BY
			clientes_productos.ano";

		$resultado = $this->db->query($sql)->row();

		if ($resultado) {
			return $resultado;
		} else {
			return "false";
		}
	}

	function transferencias_mensuales($id_empresa, $datos){
		//Id de oficina cuando se seleccionan todas
		$oficina = "";

		//Si 
		if ($datos['id_oficina'] != "0") {
			$oficina = " clientes_productos.id_agencia = {$datos['id_oficina']} AND ";
		}

		$sql =
		"SELECT
		clientes_productos.mes AS Mes,
		clientes_productos.id_agencia,
		IFNULL(sum(clientes_productos.valor),0) AS Compras,
		IFNULL(sum(clientes_productos.transferencia),0) AS Transferencias
		FROM
		clientes_productos
		WHERE
		{$oficina}
		clientes_productos.ano = {$datos['anio']} AND
		clientes_productos.id_cliente = {$datos['identificacion']} AND
			clientes_productos.id_empresa = {$id_empresa}
		GROUP BY
		clientes_productos.id_agencia,
		clientes_productos.mes
		ORDER BY
		clientes_productos.mes ASC";

		$resultado = $this->db->query($sql)->result();

		if ($resultado) {
			return $resultado;
		} else {
			return "false";
		}
	}

	function total_transferencias($id_empresa, $identificacion){
		$sql =
		"SELECT
		ifnull(sum(clientes_productos.transferencia), 0) AS Total
		FROM
		clientes_productos
		WHERE
		clientes_productos.id_cliente = {$identificacion} AND
		clientes_productos.id_empresa = {$id_empresa}";

		$resultado = $this->db->query($sql)->row();

		return $resultado->Total;
	}
}/* Fin del archivo transferencia_model.php */
/* Ubicación: ./application/models/transferencia_model.php */