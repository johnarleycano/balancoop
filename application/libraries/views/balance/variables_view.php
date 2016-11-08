<?php
//Se obtiene el año y el id que viene por post
$id_dimension = $this->input->post('id_dimension');
$id_oficina = $this->input->post('id_oficina');
$anio = $this->input->post('anio');
$id_balance = $this->input->post('id_balance');

//Si el usuario es responsable
if($this->session->userdata('tipo') == '2'){
	// Declaramos un arreglo para las variables
	$variables = array();

	//Consultamos las variables donde este usuario tiene que configurar algo
	$array_variables = $this->balance_model->cargar_variables_usuario($anio, $id_oficina, null);

	// Recorremos las variables almacenando las mismas
	foreach ($array_variables as $variable) {
		//Si la variable pertenece a esa dimensión
		if($variable->id_dimension == $id_dimension){
			// echo $variable->id_variable."<br>";

			//Iremos alimentando el arreglo
			array_push($variables, $this->balance_model->cargar_variable($variable->id_variable));
		}
	}
}else{
	//Se listan las variables	
	$variables = $this->balance_model->cargar('V', $anio, $id_dimension, '0');
}

?>

<!-- Panel de variables -->
<div class="panel panel-default">
	<!-- Cabecera -->
	<div class="panel-heading"><b>Variables</b>
		<!-- Si no es administrador, no puede agregar variables -->
		<?php if($this->session->userdata('tipo') != '2'){ ?>
			<a href="javascript:crear('V', '<?php echo $id_balance; ?>', '<?php echo $id_dimension; ?>')" class="icono_balance" title="Agregar una variable"><span class="glyphicon glyphicon-plus"></span></a>
		<?php } ?>
	</div>

	<!-- Lista -->
	<div class="list-group">
		<!-- Si no se encuentra ninguna variable -->
		<?php if (count($variables) < 1) { ?>
			<p class="list-group-item">No se encontraron variables para esta dimensión.</p>
		<?php } ?>

		<!-- Se listan las variables -->
		<?php foreach ($variables as $variable) { ?>
			<!-- Variables -->
			<a href="javascript:cargar_configuracion('<?php echo $variable->intCodigo; ?>')" class="list-group-item">
				<!-- Nombre -->
				<?php // echo $variable->strNombre." - Id ".$variable->intCodigo." - (Conector".$variable->id_conector.")"; ?>
				<?php echo $variable->strNombre; ?>
				
				<!-- Si no es administrador, no puede modificar los pesos -->
				<?php if($this->session->userdata('tipo') != '2'){ ?>
					<!-- Peso de la variable -->
					<span class="badge" onclick="javascript:cambiar_peso('<?php echo $variable->intCodigo; ?>', '<?php echo $variable->peso; ?>')"><?php echo $variable->peso; ?></span>
				<?php } ?>
			</a>

			<!-- Contenedor de variable -->
			<div id="cont_configuracion<?php echo $variable->intCodigo; ?>" class="contenedor_balance oculto"></div>
		<?php } // foreach variables ?>
	</div><!-- Lista -->
</div><!-- Panel de variables -->