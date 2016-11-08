<!-- Se cargan las oficinas -->
<?php $oficinas = $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa')); ?>

<!-- Título -->
<center><h3>Estado de la actualización de las hojas de vida</h3></center>

<!-- Contenedor -->
<div class="well container">
	<div class="col-lg-6">
		<select id="select_estado" class="form-control input-sm" autofocus>
	        <option value="">Todas las hojas de vida</option>
	        <option value="1">Actualizadas</option>
	        <option value="0">Sin actualizar</option>
	    </select>
	</div>

	<div class="col-lg-6">
		<select id="select_oficina" class="form-control input-sm" autofocus>
	        <option value="">Todas las oficinas</option>
	        <?php foreach ($oficinas as $oficina) { ?>
                <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
            <?php } ?>
	    </select>
	</div>
</div><!-- Contenedor -->

<!-- Botón ganador -->
<input type="button" id="btn_ganador" class="btn btn-success btn-block btn-xs" value="Elegir ganador">
<br>

<center>
	<div id="cont_ganador"></div>
	<div id="cont_hojas_vida"></div>
</center>

<script type="text/javascript">
    $(document).ready(function(){
		// De entrada, se carga la interfaz
        $("#cont_hojas_vida").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_actualizados', actualizado: '', id_oficina: ''});

        //Se muestra la barra de carga
        cargando($("#cont_hojas_vida"));

    	// Cuando se cambie el estado o la oficina
    	$("[id^='select']").on("change", function(){
    		// Se carga la interfaz según los parámetros
            $("#cont_hojas_vida").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_actualizados', actualizado: $("#select_estado").val(), id_oficina: $("#select_oficina").val()});

            //Se muestra la barra de carga
            cargando($("#cont_hojas_vida"));
    	}); // change

    	// Cuando se seleccione el ganador
    	$("#btn_ganador").on("click", function(){
    		//se carga el formulario que trae el ganador
    		$("#cont_ganador").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'cliente_ganador'});
    	}); //clic
    });
</script>