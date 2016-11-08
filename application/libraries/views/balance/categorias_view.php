<?php
//Se obtiene el año y la oficina que vienen por post
$anio = $this->input->post('anio');
$id_oficina = $this->input->post('id_oficina');

// Se consulta el balance existente con el año y la oficina seleccionados
$balance = $this->balance_model->consultar_balance($anio, $id_oficina);

//Si el usuario es responsable
if($this->session->userdata('tipo') == '2'){
	// Declaramos un arreglo para las cateforías
	$categorias = array();

	//Consultamos las variables donde este usuario tiene que configurar algo
	$variables = $this->balance_model->cargar_variables_usuario($anio, $id_oficina, 'C');

	// Recorremos las variables almacenando las categorías
	foreach ($variables as $variable) {
		//Agregamos al arreglo de categorías cada variable encontrada
		array_push($categorias, $this->balance_model->cargar_variable($variable->id_categoria));
	}
}else{
	//Se cargarán todas las categorías
	$categorias = $this->balance_model->cargar('C', $anio, null, $id_oficina);
}
?>

<!-- Si es administrador y si hay categorías -->
<?php if (count($categorias) > 0 && $this->session->userdata('tipo') != '2') { ?>
	<!-- Botón de generación de balance -->
	<button id="btn_generar_balance" type="button" class="btn btn-danger btn-block btn-xs">Generar balance social para esta oficina</button>
	<div class="clear"><br></div>
<?php } ?>

<!-- Panel de categorias -->
<div class="panel panel-default">
	<!-- Si no existe un balance -->
	<?php if (count($balance) == 0) { ?>
		<div class="panel-heading"><b>No existe el balance</b></div>
		<div class="list-group">
			<p class="list-group-item">No hay un balance creado para el año y oficina seleccionados. Por favor cree uno.</p>
		</div>
	<?php }else{ ?>
		<!-- Como existe, se mostrarán las categorías -->
		<!-- Cabecera -->
		<div class="panel-heading"><b>Categorías</b>
			<!-- Si no es administrador, no puede agregar categorías -->
			<?php if($this->session->userdata('tipo') != '2'){ ?>
				<!-- Crear categorías -->
				<a href="javascript:crear('C', '<?php echo $balance->id_balance; ?>', '0')" class="icono_balance" title="Agregar una categoría"><span class="glyphicon glyphicon-plus"></span></a>

				<a href="#" class="icono_balance">  </a>

				<!-- Configurar pesos -->
				<a href="javascript:configurar_pesos('C','<?php echo $balance->id_balance; ?>')" class="icono_balance" title="Configurar los pesos de esta categoría"><span class="glyphicon glyphicon-cog"></span></a>
			<?php } ?>
		</div>

		<!-- Lista -->
		<div id="lista_categorias" class="list-group">
			<!-- Si no se encuentra ninguna categoría -->
			<?php if (count($categorias) < 1) { ?>
				<p class="list-group-item">No se encontraron categorías para esta oficina.</p>
			<?php } ?>

			<!-- Se listan las categorías -->
			<?php foreach ($categorias as $categoria) { ?>
				<!-- Categorías -->
				<a href="javascript:cargar_dimensiones('<?php echo $categoria->intCodigo; ?>', '<?php echo $balance->id_balance; ?>')" class="list-group-item">
					<!-- Nombre -->
					<?php echo $categoria->strNombre; ?>
					<?php //echo $categoria->strNombre. " - id_balance(".$categoria->id_balance.")" . " - id_estructura(".$categoria->intCodigo.") - id_conector(".$categoria->id_conector.")" ; ?>
					
					<!-- Si no es administrador, no puede modificar los pesos -->
					<?php if($this->session->userdata('tipo') != '2'){ ?>
						<!-- Peso de la categoría -->
						<span id="peso_categoria<?php echo $categoria->intCodigo; ?>" class="badge" onclick="javascript:cambiar_peso('<?php echo $categoria->intCodigo; ?>', '<?php echo $categoria->peso; ?>')"><?php echo $categoria->peso; ?></span>
					<?php } ?>

					<!-- Descripción de la categoría -->
					<?php //echo $categoria->descripcion; ?>
				</a><!-- Categorías -->
				
				<!-- Contenedor de dimensiones -->
				<div id="cont_dimension<?php echo $categoria->intCodigo; ?>" class="contenedor_balance oculto"></div>
			<?php } //foreach categorías ?>
		</div><!-- Lista -->
	<?php }	?> <!-- if balance count -->
</div><!-- Panel de categorias -->

<script type="text/javascript">
	$(document).ready(function(){
		// Generar balance social
        $("#btn_generar_balance").on("click", function(){
        	//Se obtiene la url y se mandan los parámetros
        	url = "reporte/balance_social/" + $("#select_anio option:selected").text() + "/" + $("#select_oficina").val();
        	imprimir(url)

        	//Se abre una nueva ventana con el reporte
        	window.open(url);
        });//Agregar condicional
	});
</script>