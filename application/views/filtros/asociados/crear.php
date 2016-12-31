<?php
// Cargamos los datos necesarios
$campos = $this->filtro_model->cargar_campos();

// Cantidad de campos y condiciones que se permitirán
$total_campos = 12;
$total_condiciones = 10;

// Input oculto con el total de campos y condiciones
echo '<input id="total_campos" type="hidden" value="'.$total_campos.'">';
echo '<input id="total_condiciones" type="hidden" value="'.$total_condiciones.'">';

// Si es edición de un registro
if ($id != 0) {
    // Se consultan los datos
    $filtro = $this->filtro_model->cargar_informacion_filtro($id);

    // Input oculto
    echo '<input id="id_filtro" type="hidden" value="'.$id.'">';
} // if
echo $this->session->userdata('id_filtro_por_defecto');
?>

<!-- Modal para el registro nuevo o el que se editará -->
<div id="modal_filtro" class="modal fade">
	<div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cerrar</span></button>
                <h4 id="modal_mensaje_titulo" class="modal-title">Gestión de filtros</h4>
            </div>
            <div class="modal-body">
            	<!-- Datos básicos -->
            	<div class="row">
            		<!-- Nombre -->
            		<div class="col-lg-12">
	                    <div class="form-group">
	                    	<input id="input_nombre_filtro" class="form-control input-sm" type="text" placeholder="Nombre del filtro" value="<?php echo $nombre = (isset($filtro->strNombre)) ? $filtro->strNombre : "" ; ?>" autofocus>
	                    </div>
                	</div>
	            </div>

            	<!-- Listas -->
            	<div class="row">
            		<!-- Filtro de cliente -->
                	<div class="col-lg-4">
	                    <div class="form-group">
	                    	<select id="select_filtro_cliente" class="form-control input-sm">
				                <option value="1">Es filtro de cliente</option>
				                <option value="0">No es filtro de cliente</option>
				            </select>
	                    </div>
                	</div>

                	<!-- Si es usuario super administrador -->
	        		<?php if($this->session->userdata('tipo') == "3"){ ?>
						<!-- Filtro del sistema -->
			        	<div class="col-lg-4">
		                    <select id="select_filtro_sistema" class="form-control input-sm">
			                    <option value="0">No es filtro de sistema</option>
			                    <option value="1">Es filtro de sistema</option>
			                </select>
	                	</div>
			        <?php }else{ ?>
			        	<!-- Input oculto -->
            			<input id="select_filtro_sistema" type="hidden" value="0">
			        <?php } ?>

					<!-- Filtro de búsqueda rápida -->
            		<div class="col-lg-4">
	                    <div class="form-group">
	                    	<select id="select_busqueda_rapida" class="form-control input-sm">
				                <option value="0">No es filtro de búsqueda rápida</option>
				                <option value="1">Es filtro de búsqueda rápida?</option>
				            </select>
	                    </div>
                	</div>
            	</div>

            	<!-- Checks -->
            	<div class="row">
            		<div class="col-lg-4">
			            <!-- Activo -->
			            <div class="checkbox">
			                <label><input id="check_activo" type="checkbox" checked> Activo</label>
			            </div><!-- Activo -->
                	</div>

            		<div class="col-lg-4">
	                    <!-- Privado -->
			            <div class="checkbox">
			                <label><input id="check_privado" type="checkbox"> Privado</label>
			            </div><!-- Privado -->
                	</div>

            		<div class="col-lg-4">
			            <!-- Por defecto -->
			            <div class="checkbox">
			                <label><input id="check_por_defecto" type="checkbox"> Por defecto</label>
			            </div><!-- Por defecto -->
                	</div>
	            </div>

            	<!-- Campos -->
            	<legend>Campos</legend>
                <div class="row ">
                	<!-- Se recorren 14 campos -->
                	<?php for ($i=1; $i <= $total_campos; $i++) { ?>
            			<div class="col-lg-6">
		                    <div class="form-group">
	                            <select id="select_campo<?php echo $i; ?>" class="form-control input-sm">
				                    <option value=""><?php echo "$i..." ?></option>
				                    <?php foreach ($campos as $campo) { ?>
				                        <option value="<?php echo $campo->intCodigo; ?>" ><?php echo $campo->strNombre; ?></option>
				                    <?php } // foreach campos ?>
				                </select>
	                        </div>
		                </div>
                	<?php } // for ?>
            	</div><!-- Campos -->
				
				<!-- Condiciones -->
            	<legend>Condiciones</legend>
            	<div class="row">
            		<div class="col-lg-4">
						<label class="control-label">Campo</label>
		            </div>
            		<div class="col-lg-4">
						<label class="control-label">Condición</label>
		            </div>
            		<div class="col-lg-4">
						<label class="control-label">Detalle</label>
		            </div>
            	</div>
            	
            	<div class="row ">
					<!-- Se recorren 14 condiciones -->
                	<?php for ($i=1; $i <= $total_condiciones; $i++) { ?>
                		<!-- Campo -->
	                	<div class="col-lg-4">
		                    <div class="form-group">
		                		<select id="select_campo_condicion<?php echo $i; ?>" class="form-control input-sm" data-contador="<?php echo $i; ?>">
					                <option value=""><?php echo "$i..." ?></option>
					                <?php foreach ($campos as $campo) { ?>
					                    <option value="<?php echo $campo->intCodigo; ?>"><?php echo $campo->strNombre; ?></option>
					                <?php } ?>
					            </select>
				            </div>
			            </div>

			            <!-- Condición -->
	                	<div class="col-lg-4">
		                    <div class="form-group">
					            <select id="select_condicion<?php echo $i; ?>" class="form-control input-sm">
					                <option value=""></option>
					            </select>
				            </div>
			            </div>

			            <!-- Detalle -->
	                	<div class="col-lg-4">
		                    <div class="form-group">
            					<input id="input_detalle<?php echo $i; ?>" class="form-control input-sm" type="text" placeholder="Escriba...">
				            </div>
			            </div>
                	<?php } // for ?>
        		</div><!-- Condiciones -->
            </div>
            <div class="modal-footer">
                <button type="button" onclick="javascript:guardar('asociados')" class="btn btn-success">Guardar</button>
                <button type="button" class="btn btn-outline btn-info" data-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
    // Cuando el DOM esté listo
    $(document).ready(function() {
        // Se muestra el modal
        $('#modal_filtro').modal('show');

        /**
         * Cuando se seleccione el campo de las condicionales
         */
        $("select[id^='select_campo_condicion']").on("change", function(){
        	// Número del select
        	var numero = $(this).attr("data-contador");
        	
            // Si se selecciona algún campo
    		if ($(this) != "") {
                //Se invoca la petición ajax que traerá todas las condiciones que aplican para el tipo de campo
                condiciones = ajax("<?php echo site_url('filtros/cargar'); ?>", {"id_campo": $(this).val(), "tipo": "condiciones"}, "json");

                //Si trae resultados
                if (condiciones.length > 0) {
                	$("#select_condicion" + numero).html('').append("<option value=''>...</option>");

                	//Se recorren las condiciones
                    $.each(condiciones, function(key, val){
                        //Se agrega cada condicion al select
                        $("#select_condicion" + numero).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                    })//Fin each
                } // if
    		} // if
        }); // change
    }); // document.ready
</script>

<!-- Si es edición -->
<?php if ($id) { ?>
	<script type="text/javascript">
		// Listas por defecto
		select_por_defecto("select_filtro_cliente", "<?php echo $filtro->es_cliente; ?>");
		select_por_defecto("select_filtro_sistema", "<?php echo $filtro->es_sistema; ?>");
		select_por_defecto("select_busqueda_rapida", "<?php echo $filtro->busqueda_rapida; ?>");
		
		// Checks por defecto
		check_por_defecto("check_activo", "<?php echo $filtro->Estado; ?>");
		check_por_defecto("check_privado", "<?php echo $filtro->privado; ?>");
		
		// Si el id por defecto es el mismo seleccionado
		if ("<?php echo $this->session->userdata('id_filtro_por_defecto'); ?>" == "<?php echo $id; ?>") {
			check_por_defecto("check_por_defecto", 1);
		} // if

		// Se consultan los campos del filtro creado
		campos = ajax("<?php echo site_url('filtros/cargar_filtros'); ?>", {"tipo": "campos", "codigo_filtro": "<?php echo $id; ?>"}, "json");

		//Se recorren los campos
        $.each(campos, function(key, val){
			// Se pone cada valor por defecto de la lista
			select_por_defecto("select_campo" + (key + 1), val.id_filtro_campo);
        })//Fin each

		// Se consultan las condiciones del filtro creado
		condiciones = ajax("<?php echo site_url('filtros/cargar_filtros'); ?>", {"tipo": "condiciones", "codigo_filtro": "<?php echo $id; ?>"}, "json");

		//Se recorren las condiciones
        $.each(condiciones, function(key, val){
			// Se cargan las condiciones, de acuerdo al campo del filtro
			condiciones = ajax("<?php echo site_url('filtros/cargar'); ?>", {"id_campo": val.id_filtro_campo, "tipo": "condiciones"}, "json");

			//Si trae resultados
            if (condiciones.length > 0) {
            	$("#select_condicion" + (key + 1)).html('').append("<option value=''>...</option>");

            	//Se recorren las condiciones
                $.each(condiciones, function(key2, val){
                    //Se agrega cada condicion al select
                    $("#select_condicion" + (key + 1)).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                })//Fin each
            } // if

            // Se pone cada valor por defecto de la lista
			select_por_defecto("select_campo_condicion" + (key + 1), val.id_filtro_campo);
			select_por_defecto("select_condicion" + (key + 1), val.id_filtro_condicion);
			$("#input_detalle" + (key + 1)).val(val.detalle);
        })//Fin each
	</script>
<?php } ?>