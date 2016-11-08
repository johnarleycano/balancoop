<?php
$datos_asociado = $this->input->post('datos_asociado');
$datos_transferencia = $this->input->post('datos_transferencia');
$datos = $this->input->post('datos');
?>

<!-- Nombre del asociado -->
<div class="well">
	Transferencia solidaria de <b><?php echo $datos_asociado['Nombre']." ".$datos_asociado['PrimerApellido']." ".$datos_asociado['SegundoApellido']; ?></b>
</div><!-- Nombre del asociado -->

<!-- Compras del año seleccionado -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($datos_transferencia['compras_anio_seleccionado'], 0, '', '.'); ?></span>
			Transferencia en el año <?php echo $datos['anio']; ?>
		</a>
	</li>
</ul><!-- Compras del año seleccionado -->

<!-- Compras del año actual -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($datos_transferencia['compras_anio_actual'], 0, '', '.'); ?></span>
			Transferencia en este año
		</a>
	</li>
</ul><!-- Compras del año actual -->

<!-- Compras últimos tres meses -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($datos_transferencia['compras_ultimos_meses'], 0, '', '.'); ?></span>
			Transferencia últimos 3 meses
		</a>
	</li>
</ul><!-- Compras últimos tres meses -->