<?php
//Se obtiene el año y el id que viene por post
$id_categoria = $this->input->post('id_categoria');
$id_oficina = $this->input->post('id_oficina');
$anio = $this->input->post('anio');
$id_balance = $this->input->post('id_balance');

//Si el usuario es responsable
if($this->session->userdata('tipo') == '2'){
	// Declaramos un arreglo para las dimensiones
	$dimensiones = array();

	//Consultamos las variables donde este usuario tiene que configurar algo
	$array_variables = $this->balance_model->cargar_variables_usuario($anio, $id_oficina, 'C');

	// print_r($array_variables);

	// Recorremos las variables almacenando las dimensiones
	foreach ($array_variables as $array_variable) {
		//Si la dimensión pertenece a esta categoría
		if($array_variable->id_categoria == $id_categoria){
			// echo "id dimension: " .$array_variable->id_dimension."<br>";

			//Agregamos al arreglo de dimensiones cada variable encontrada
			array_push($dimensiones, $this->balance_model->cargar_variable($array_variable->id_dimension));
		}
	}
}else{
	//Se listan las dimensiones
	$dimensiones = $this->balance_model->cargar('D', $anio, $id_categoria, '0');
}
?>

<!-- Panel de dimensiones -->
<div class="panel panel-default">
	<!-- Cabecera -->
	<div class="panel-heading"><b>Dimensiones</b>
		<!-- Si no es administrador, no puede agregar dimensiones -->
		<?php if($this->session->userdata('tipo') != '2'){ ?>
			<a href="javascript:crear('D', '<?php echo $id_balance; ?>', '<?php echo $id_categoria; ?>')" class="icono_balance" title="Agregar una dimensión"><span class="glyphicon glyphicon-plus"></span></a>
		<?php } ?>
	</div>
	

	<!-- Lista -->
	<div class="list-group">
		<!-- Si no se encuentra ninguna dimensión -->
		<?php if (count($dimensiones) < 1) { ?>
			<p class="list-group-item">No se encontraron dimensiones para esta categoría.</p>
		<?php } ?>

		<!-- Se listan las dimensiones -->
		<?php foreach ($dimensiones as $dimension) { ?>
			<!-- Dimensiones -->
			<a href="javascript:cargar_variables('<?php echo $dimension->intCodigo; ?>', '<?php echo $id_balance; ?>')" class="list-group-item">
				<!-- Nombre -->
				<?php // echo $dimension->strNombre." - Id ".$dimension->intCodigo." - (Conector".$dimension->id_conector.")"; ?>
				<?php echo $dimension->strNombre; ?>

				<!-- Si no es administrador, no puede modificar los pesos -->
				<?php if($this->session->userdata('tipo') != '2'){ ?>
					<!-- Peso de la dimensión -->
					<span class="badge" onclick="javascript:cambiar_peso('<?php echo $dimension->intCodigo; ?>', '<?php echo $dimension->peso; ?>')"><?php echo $dimension->peso; ?></span>
				<?php } ?>
			</a>

			<!-- Contenedor de variables -->
			<div id="cont_variable<?php echo $dimension->intCodigo; ?>" class="contenedor_balance oculto"></div>
		<?php } // foreach dimensiones ?>
	</div><!-- Lista -->
</div><!-- Panel de dimensiones -->
