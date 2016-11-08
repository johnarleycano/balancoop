<?php
$dias = $this->listas_model->listar_dias();
$meses = $this->listas_model->listar_meses();
$anios = $this->listas_model->listar_anios();
// $productos = $this->listas_model->cargar_productos_matriculados('productos');

//Tomamos los datos que vienen por post
// $datos = $this->input->post('datos');
?>

<!-- Contenedor producto -->
<div id="cont_producto<?php echo $numero; ?>">
	<legend>
		<!-- Borrar registro -->
        <a href="javascript:eliminar('cont_producto<?php echo $numero ?>','guardar_producto<?php echo $numero ?>')" title="Eliminar este producto">
            <span class="glyphicon glyphicon-remove"></span>                
        </a><!-- Borrar registro -->

        <!-- Expandir - Contraer -->
        <a href="javascript:expandir_contraer('cont_producto<?php echo $numero ?>')" title="Expandir / Contraer datos">
            Producto <?php echo $numero; ?>
            <span class="glyphicon glyphicon-resize-vertical"></span>
        </a><!-- Expandir - Contraer -->
	</legend>
	
	<!-- Título fechas -->
	<div class="form-group">
        <div class="col-sm-6"><label for="">Fecha de apertura</label></div>
        <div class="col-sm-6"><label for="">Fecha de vencimiento</label></div>
    </div><!-- Título fechas -->

    <!-- Fechas -->
	<div class="form-group">
		<!-- Día -->
        <div class="col-sm-2">
            <select id="dia_inicio_producto<?php echo $numero; ?>" class="form-control input-sm">
                <option value="00">Día</option>
                <?php foreach ($dias as $dia) { ?>
                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                <?php } ?>
            </select>
        </div><!-- Día -->
        
        <!-- Mes -->
        <div class="col-sm-2">
            <select id="mes_inicio_producto<?php echo $numero; ?>" class="form-control input-sm">
                <option value="00">Mes</option>
                <?php foreach ($meses as $mes) { ?>
                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                <?php } ?>
            </select>
        </div><!-- Mes -->
        
        <!-- Año -->
        <div class="col-sm-2">
            <select id="anio_inicio_producto<?php echo $numero; ?>" class="form-control input-sm" >
                <option value="0000">Año</option>
                <?php foreach ($anios as $anio) { ?>
                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                <?php } ?>
            </select>
        </div><!-- Año -->

        <!-- Día -->
        <div class="col-sm-2">
            <select id="dia_fin_producto<?php echo $numero; ?>" class="form-control input-sm">
                <option value="00">Día</option>
                <?php foreach ($dias as $dia) { ?>
                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
                <?php } ?>
            </select>
        </div><!-- Día -->
        
        <!-- Mes -->
        <div class="col-sm-2">
            <select id="mes_fin_producto<?php echo $numero; ?>" class="form-control input-sm">
                <option value="00">Mes</option>
                <?php foreach ($meses as $mes) { ?>
                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
                <?php } ?>
            </select>
        </div><!-- Mes -->
        
        <!-- Año -->
        <div class="col-sm-2">
            <select id="anio_fin_producto<?php echo $numero; ?>" class="form-control input-sm" >
                <option value="0000">Año</option>
                <?php foreach ($anios as $anio) { ?>
                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
                <?php } ?>
            </select>
        </div><!-- Año -->
	</div><!-- Fechas -->

	<!-- Títulos de valor, cantidad y transferencia -->
	<!-- <div class="form-group"> -->
        <!-- <div class="col-sm-4"><label for="">Valor</label></div> -->
        <!-- <div class="col-sm-4"><label for="">Cantidad</label></div> -->
        <!-- <div class="col-sm-4"><label for="">Transferencia</label></div> -->
	<!-- </div> -->
	<!-- Títulos de valor, cantidad y transferencia -->

	<!-- valor, cantidad y transferencia -->
	<div class="form-group">
		<!-- Valor -->
		<div class="col-sm-4 input-group input-group-sm">
            <span class="input-group-addon">$</span>
            <input id="input_valor" type="text" class="form-control" placeholder="Valor" />
            <span class="input-group-addon">.00</span>
        </div>

        <!-- Cantidad -->
		<div class="col-sm-4 input-group input-group-sm">
            <input id="input_cantidad" type="text" class="form-control" placeholder="Cantidad" />
            <span class="input-group-addon">.00</span>
        </div>

        <!-- Transferencia -->
		<div class="col-sm-4 input-group input-group-sm">
            <span class="input-group-addon">$</span>
            <input id="input_transferencia" type="text" class="form-control" placeholder="Transferencia" />
            <span class="input-group-addon">.00</span>
        </div>
	</div><!-- valor, cantidad y transferencia -->
</div><!-- Contenedor producto -->

<script type="text/javascript">
    $(document).ready(function(){ 
        /**
         * Campos que cargan información del cliente seleccionado, en caso de que lo haya
         */
            

        });//Document.ready
</script>