<?php
//
$compras_anio_actual = "0";
$compras_anio_seleccionado = "0";
$compras_ultimos_meses = "0";

// Se toman los datos del asociado
$datos_generales = $this->input->post('datos_filtro'); 
$datos_asociado = $this->input->post('datos_asociado'); 

//Se calculan las compras
$anio_actual = $this->transferencia_model->compras_anio_actual($datos_generales);
$anio_seleccionado = $this->transferencia_model->compras_anio_seleccionado($datos_generales);
$ultimos_meses = $this->transferencia_model->compras_ultimos_meses($datos_generales);

//Si traen datos, se actualiza
if (isset($anio_actual->Total_Compras)) {
	$compras_anio_actual = $anio_actual->Total_Compras;
}

if (isset($anio_seleccionado->Total_Compras) == 1) {
	$compras_anio_seleccionado = $anio_seleccionado->Total_Compras;
}

if (isset($ultimos_meses->Total_Compras) == 1) {
	$compras_ultimos_meses = $ultimos_meses->Total_Compras;
}
?>

<!-- Nombre del asociado -->
<div class="well">
	Transferencia solidaria de <b><?php echo $datos_asociado['Nombre']." ".$datos_asociado['PrimerApellido']." ".$datos_asociado['SegundoApellido']; ?></b>
</div><!-- Nombre del asociado -->

<!-- Compras del año seleccionado -->
<ul class="nav nav-pills nav-stacked col-sm-4">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($compras_anio_seleccionado, 0, '', '.'); ?></span>
			Transferencia en el año <?php echo $datos_generales['anio']; ?>
		</a>
	</li>
</ul><!-- Compras del año seleccionado -->