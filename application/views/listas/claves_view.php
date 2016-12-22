<input type="hidden" id="id_asociado">

<!-- Botón buscar asociado -->
<button id="btn_buscar_asociado" type="button" class="btn btn-info btn-block">Buscar asociado</button>
<br>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="usuarios_claves" class="table">
		<!-- Cabecera -->
        <thead>
            <tr>
				<th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
            </tr>
        </thead><!-- Cabecera -->
        
        <!-- Cuerpo -->
        <tbody>
			<tr>
				<td></td>
				<td></td>
			</tr>
		</tbody><!-- Cuerpo -->
    </tabla><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal buscar asociado -->
<div id="modal_buscar_asociado" class="modal fade">
	<form id="form_asociado">
    	<div class="modal-dialog">
    		<div class="modal-content">
	    		<!-- Cabecera -->
	            <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 id="titulo_mensaje" class="modal-title">Búsqueda y cambio de clave de asociado</h4>
            	</div><!-- Cabecera -->

	            <!-- Cuerpo -->
	            <div class="modal-body">
					<!-- Container -->
					<div class="container">
						<div class="col-lg-3"></div>
						<div class="col-lg-6">
							<!-- Cédula -->
           	 				<label for="input_cedula" class="control-label">Número de cédula *</label>
							<input id="input_cedula" class="form-control input-sm" type="text" autofocus ><!-- Cédula -->

                    		<!-- Botón -->
                			<button type="button" class="btn btn-info" id="btn_buscar">Buscar</button>
						</div>
						<div class="col-lg-3">
							
						</div>
                        
                        <div id="form_claves" class="oculto">
                            <div class="col-lg-6">
                                <!-- Contraseña 1 -->
                                <label for="input_clave1" class="control-label">Contraseña *</label>
                                <input id="input_clave1" class="form-control input-sm" type="password" ><!-- Contraseña 1 -->
                            </div>

                            <div class="col-lg-6">
                                <!-- Contraseña 2 -->
                                <label for="input_clave2" class="control-label">Repita la contraseña *</label>
                                <input id="input_clave2" class="form-control input-sm" type="password" ><!-- Contraseña 2 -->
                            </div>
                        </div>
					</div><!-- Container -->
            	</div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" onClick="javascript:cambiar_clave()" id="btn_guardar" class="btn btn-success" disabled>Guardar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</form>
</div><!-- Modal buscar asociado -->

<script type="text/javascript">
    /**
     * 
     */
	function cambiar_clave(){
        // Recolección de datos
        var clave1 = $("#input_clave1");
        var clave2 = $("#input_clave2");

        //Datos a validar
        datos_obligatorios = new Array(
            clave1.val(),
            clave2.val()
        ); // datos
        // imprimir(datos_obligatorios)

        //Se ejecuta la validación de los campos obligatorios
        validacion = validar_campos_vacios(datos_obligatorios);

        //Si no supera la validacíón
        if (!validacion) {
            //Se muestra el mensaje de error
            mostrar_mensaje('Aun no se ha completado el proceso', 'Por favor diligencie ambas contraseñas.');

            return false;
        } // if

        // Si la contraseña no es igual
        if (clave1.val() != clave2.val()) {
            //Se muestra el mensaje de error
            mostrar_mensaje('Contraseñas diferentes', 'Las contraseñas no coinciden.');

            // Se detiene el formulario
            return false;
        };

        //Arreglo JSON de datos a enviar posteriormente
        datos_formulario = {
            'Clave_Transferencia': clave1.val(),
        }
        // imprimir(datos_formulario)
        

        actualizar = ajax("<?php echo site_url('cliente/actualizar'); ?>", {"datos": datos_formulario, "tipo": "asociado", "id_asociado": $("#id_asociado").val()}, "html");
        imprimir(actualizar)






	} // cambiar_clave

	// Cuando el DOM esté listo   
	$(document).ready(function(){
		// Inicialización de la tabla
        $('#usuarios_claves').dataTable( {
            "bProcessing": true,
        }); // Tabla

        // Buscar asociado
        $("#btn_buscar_asociado").on("click", function(){
            // Se quita el id del usuario
            $("#id_asociado").val(0);

            //Se limpia el formulario
            limpiar("#form_asociado");

            //Se abre la ventana
            $('#modal_buscar_asociado').modal('show');
        }); // Buscar asociado

        // Buscar cédula
        $("#btn_buscar").on("click", function(){
        	// Se consulta la cédula 
            asociado = ajax("<?php echo site_url('cliente/buscar'); ?>", {'documento': $("#input_cedula").val(), 'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>"}, 'json');
            
            // Si no existe el asociado
            if (!asociado.id_Asociado) {
                // Se activa el botón para guardar los cambios
                $("#btn_guardar").attr("disabled", true);

                // Se muestra el formulario de contraseñas
                $("#form_claves").hide();

            	//Se muestra el mensaje de error
                mostrar_mensaje('No se encontró el número de cédula', 'El número de cédula no se encuentra registrado para esta cooperativa. Verifique e intente nuevamente.');

                return false;
            } else {
                // Se oculta el formulario de contraseñas
                $("#form_claves").show();

                // Se activa el botón para guardar los cambios
                $("#btn_guardar").attr("disabled", false);

                // Se pone el id del usuario
                $("#id_asociado").val(asociado.id_Asociado);
            } // if
        }); // Buscar cédula
	});//document.rady
</script>