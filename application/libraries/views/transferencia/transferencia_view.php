<?php
// se verifica si los datos vienen por get
if ($this->uri->segment(6) == "get") {
	//Cuando la transferencia se genera desde afuera, los datos se toman por get
	// echo "Vienen por GET<br>";
	
	$anio = date("Y") -1 ;
	$id_empresa = $this->uri->segment(3);
	$id_oficina = $this->uri->segment(4);
	$identificacion = $this->uri->segment(5);
}

//Puede que estando dentro lo modifique, y estos vienen por post
if($this->input->post('metodo') == 'post') {
	//Cuando es generada desde el usuario logueado o desde dentro, es por POST
	// echo "Vienen por POST<br>";
	
	$anio = $this->input->post('anio');
	$id_empresa = $this->input->post('id_empresa');
	$id_oficina = $this->input->post('id_oficina');
	$identificacion = $this->input->post('identificacion');
}

// Se declaran las variables en cero
$compras_anio_seleccionado = "0";
$compras_anio_actual = "0";
$compras_ultimos_meses = "0";

//Datos
$datos_asociado = $this->transferencia_model->buscar_asociado($identificacion, $id_empresa);
$datos_generales = array("anio" => $anio, "id_oficina" => $id_oficina, "id_empresa" => $id_empresa, "identificacion" => $identificacion);

// echo "datos del asociado " . $datos_asociado->Nombre."<br>";
//print_r($datos_generales);

//
$anio_actual = $this->transferencia_model->compras_anio_actual($datos_generales);
if (isset($anio_actual->Total_Compras)) {
	$compras_anio_actual = $anio_actual->Total_Compras;
}

//
$anio_seleccionado = $this->transferencia_model->compras_anio_seleccionado($datos_generales);
if (isset($anio_seleccionado->Total_Compras) == 1) {
	$compras_anio_seleccionado = $anio_seleccionado->Total_Compras;
}

//
$ultimos_meses = $this->transferencia_model->compras_ultimos_meses($datos_generales);
if (isset($ultimos_meses->Total_Compras) == 1) {
	$compras_ultimos_meses = $ultimos_meses->Total_Compras;
}

//Transferencias por mes
$transferencias = $this->transferencia_model->transferencias_mensuales($datos_generales);
?>

<!-- Nombre del asociado -->
<div class="well">
	<p>
		Transferencia solidaria de <b><?php echo $datos_asociado->Nombre." ".$datos_asociado->PrimerApellido." ".$datos_asociado->SegundoApellido; ?></b><?php if ($datos_asociado->id_EstadoactualEntidad == "1"){echo " (Activo)";}else{echo " (Inactivo)";}; ?></b>
	</p>
	<p>Utiliza nuestros servicios y recibe una mayor transferencia solidaria. Somos una Cooperativa con alto beneficio social.<br> Accede a los siguientes enlaces y conoce todo lo que podemos hacer por tí.</p>
	<a href="http://www.consumo.com.co/eventos-y-ofertas/ofertas/" target="_blank">http://www.consumo.com.co/eventos-y-ofertas/ofertas</a><br>
	<a href="http://www.consumo.com.co/asociate/beneficios/educacion/" target="_blank">http://www.consumo.com.co/asociate/beneficios/educacion</a><br>
	<a href="http://www.consumo.com.co/asociate/beneficios/solidaridad/" target="_blank">http://www.consumo.com.co/asociate/beneficios/solidaridad</a><br>
	<a href="http://www.consumo.com.co/asociate/beneficios/fomento-cooperativa/" target="_blank">http://www.consumo.com.co/asociate/beneficios/fomento-cooperativa</a>
</div><!-- Nombre del asociado -->

<!-- Compras del año seleccionado -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($compras_anio_seleccionado, 0, '', '.'); ?></span>
			Transferencia en el año <?php echo $datos_generales['anio']; ?>
		</a>
	</li>
</ul><!-- Compras del año seleccionado -->

<!-- Compras del año actual -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($compras_anio_actual, 0, '', '.'); ?></span>
			Transferencia este año <?php echo "(".date('Y').")"; ?>
		</a>
	</li>
</ul><!-- Compras del año actual -->

<!-- Compras últimos tres meses -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($compras_ultimos_meses, 0, '', '.'); ?></span>
			Transferencia últimos 3 meses
		</a>
	</li>
</ul><!-- Compras últimos tres meses -->

<!-- Estado del asociado -->
<ul class="nav nav-pills nav-stacked col-sm-3">
	<li class="active">
		<a href="#">
			<span class="badge pull-right"><?php echo "$".number_format($this->transferencia_model->total_transferencias($datos_generales['identificacion']), 0, '', '.'); ?></span>
			Transferencia acumulada
		</a>
	</li>
</ul><!-- Estado del asociado -->
<?php if($transferencias != 'false'){ ?>
<br>
	<table class="table table-hover">
		<thead>
			<tr>
				<th align="center">Descripción</th>
				<th align="center">Punto de venta</th>
				<th align="center">Mes</th>
				<th align="center">Compras</th>
				<th align="center">Transferencias</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$total_compras = 0;
			$total_transferencias = 0;
			foreach ($transferencias as $transferencia) {
			?>
				<tr>
					<td>Transferencia (descuentos o auxilios educativos)</td>
					<td><?php echo $this->listas_model->obtener_nombre_oficina($transferencia->id_agencia); ?></td>
					<td><?php echo $transferencia->Mes; ?></td>
					<td align="right"><?php echo "$".number_format($transferencia->Compras, 0, '', '.'); ?></td>
					<td align="right"><?php echo "$".number_format($transferencia->Transferencias, 0, '', '.') ; ?></td>
				</tr>
			<?php
				$total_compras += $transferencia->Compras;
				$total_transferencias += $transferencia->Transferencias;
			}
			?>
			
			<tr>
				<td></td>
				<td></td>
				<td align="right"><b>Total año <?php echo $anio; ?></b></td>
				<td align="right"><b><?php echo "$".number_format($total_compras, 0, '', '.'); ?></b></td>
				<td align="right"><b><?php echo "$".number_format($total_transferencias, 0, '', '.'); ?></b></td>
			</tr>
		</tbody>
	</table>
<?php }else{ ?>
<div class="clear"></div>
	<div class="well">
		No hay transferencia solidaria registrada para el período y la oficina seleccionados.
	</div>
<?php } ?>