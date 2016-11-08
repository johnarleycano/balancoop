<?php
//Se cargan los elementos de base de datos
$campanas = $this->listas_model->cargar_campanas($this->session->userdata('id_empresa'));
$usuarios = $this->listas_model->cargar('usuarios_sistema');
$tipos = $this->listas_model->cargar('tipo_campana');
$oficinas =  $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));
$dias = $this->listas_model->listar_dias();
$meses = $this->listas_model->listar_meses();
$anios = $this->listas_model->listar_anios();
// $proveedores = $this->listas_model->cargar('proveedores');
?>
<!-- Botón agregar campaña -->
<button id="btn_agregar_campana" type="button" class="btn btn-info btn-block">Agregar campaña</button>
<br>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
	<table id="tbl_campanas" class="table">
		<!-- Cabecera -->
		<thead>
            <tr>
				<th></th>
				<th>Código</th>
				<th>Nombre</th>
				<th>Fecha Inicial</th>
				<th>Estado</th>
				<th>Usuario creador</th>
				<th>Usuario responsable</th>
				<th>Usuario asignado</th>
				<th class="oculto">Fecha final</th>
				<th class="oculto">Tipo Campaña</th>
				<th class="oculto">costo estimado</th>
				<th class="oculto">costo real</th>								
				<th class="oculto">invitado</th>								
				<th class="oculto">oficina</th>								
				<th class="oculto">descripcion</th>								
				<th class="oculto">Estado campaña</th>								
        	</tr>
        </thead><!-- Cabecera -->
		<!-- Cuerpo -->
        <tbody>
        	<?php
            //Contador
            $cont = 1;
            // Recorrido de las campanas
            foreach ($campanas as $campana) {
            	//Usuarios
            	$asignado = $this->listas_model->cargar_datos_usuario($campana->id_usuario_asignado);
            	$creador = $this->listas_model->cargar_datos_usuario($campana->id_usuario_creador);
            	$responsable = $this->listas_model->cargar_datos_usuario($campana->id_usuario_responsable);
            ?>
			<tr>
				<td onclick="javascript:editar_dato(<?php echo $campana->intCodigo; ?>)"><span class="glyphicon glyphicon-edit"></span></td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
                <td id="strNombre<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></td>
                <td id="fecha_inicia<?php echo $campana->intCodigo; ?>"><?php echo $campana->fecha_inicia; ?></td>
                <td id="Estado<?php echo $campana->intCodigo; ?>"><?php if($campana->Estado == "1") {echo "Activo";}else{echo "Inactivo";} ?>
				<td id="creador<?php echo $campana->intCodigo; ?>"><?php if(isset($creador->strNombre)){ echo $creador->strNombre; }  ?></td>
				<td id="responsable<?php echo $campana->intCodigo; ?>"><?php if(isset($responsable->strNombre)){ echo $responsable->strNombre; }  ?></td>
				<td id="asignado<?php echo $campana->intCodigo; ?>"><?php if(isset($asignado->strNombre)){ echo $asignado->strNombre; }  ?></td>
				<td id="fecha_finaliza<?php echo $campana->intCodigo; ?>" class="oculto"><?php echo $campana->fecha_finaliza; ?></td>				
				<td id="tipo_campana<?php echo $campana->intCodigo; ?>" class="oculto"><?php if(isset($campana->tipo_campana)){ echo $campana->tipo_campana; }  ?></td>
				<td id="costo_estimado<?php echo $campana->intCodigo; ?>" class="oculto"><?php if(isset($campana->costo_estimado)){ echo $campana->costo_estimado; }  ?></td>
				<td id="costo_real<?php echo $campana->intCodigo; ?>" class="oculto"><?php if(isset($campana->costo_real)){ echo $campana->costo_real; }  ?></td>
				<td id="invitado<?php echo $campana->intCodigo; ?>" class="oculto"><?php if(isset($campana->numero_invitados)){ echo $campana->numero_invitados; }  ?></td>
				<td id="oficina<?php echo $campana->intCodigo; ?>" class="oculto"><?php if(isset($campana->id_agencia)){ echo $campana->id_agencia; }  ?></td>
				<td id="descripcion<?php echo $campana->intCodigo; ?>" class="oculto"><?php if(isset($campana->descripcion)){ echo $campana->descripcion; }  ?></td>
				<td id="Estadocampana<?php echo $campana->intCodigo; ?>" class="oculto"><?php if(isset($campana->Estado)){ echo $campana->Estado; }  ?></td>
			</tr>
			<?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
    	</tbody><!-- Cuerpo -->
	</tabla><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nueva campaña -->
<div id="modal_nueva_campana" class="modal fade">
    <form id="form_campana">
    	<div class="modal-dialog">
    		<div class="modal-content">
	    		<!-- Cabecera -->
	            <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 id="titulo_mensaje" class="modal-title">Agregar nueva campaña</h4>
	            </div><!-- Cabecera -->

	            <!-- Cuerpo -->
	            <div class="modal-body">
					<!-- Container -->
					<div class="container">
						<div class="col-lg-12">
							<input type="hidden" id="input_id_campana" value="">

							<!-- Nombre de la campaña -->
           	 				<label for="input_nombre" class="control-label">Nombre</label>
							<input id="input_nombre" class="form-control input-sm" type="text" autofocus ><!-- Nombre de la campaña -->
						</div>

						<div class="col-lg-12">
							<!-- Descripción de la campaña -->
							<label for="input_descripcion" class="control-label">Descripción</label>
							<textarea id="input_descripcion" class="form-control input-sm" type="text" ></textarea><!-- Descripción de la campaña -->
						</div>
						<br>
						<div class="form-group">						    
						    <!-- Fecha de Inicio -->
					        <label for="dia_inicio" class="col-sm-3 control-label">Fecha inicio</label>

					        <!-- Día -->
					        <div class="col-sm-3">
					            <select id="dia_inicio" class="form-control input-sm">
					                <option value="00">Día</option>
					                <?php foreach ($dias as $dia) { ?>
					                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Día -->
					        
					        <!-- Mes -->
					        <div class="col-sm-3">
					            <select id="mes_inicio" class="form-control input-sm">
					                <option value="00">Mes</option>
					                <?php foreach ($meses as $mes) { ?>
					                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Mes -->
					        
					        <!-- Año -->
					        <div class="col-sm-3">
					            <select id="anio_inicio" class="form-control input-sm" >
					                <option value="0000">Año</option>
					                <?php foreach ($anios as $anio) { ?>
					                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Año -->
						</div>
						<br>
						<div class="form-group">
							<label for="dia_fin" class="col-sm-3 control-label">Fecha final</label>
					        <!-- Día -->
					        <div class="col-sm-3">
					            <select id="dia_fin" class="form-control input-sm">
					                <option value="00">Día</option>
					                <?php foreach ($dias as $dia) { ?>
					                    <option value="<?php echo $dia; ?>"><?php echo $dia; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Día -->
					        
					        <!-- Mes -->
					        <div class="col-sm-3">
					            <select id="mes_fin" class="form-control input-sm">
					                <option value="00">Mes</option>
					                <?php foreach ($meses as $mes) { ?>
					                    <option value="<?php echo $mes['Numero']; ?>"><?php echo $mes['Nombre']; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Mes -->
					        
					        <!-- Año -->
					        <div class="col-sm-3">
					            <select id="anio_fin" class="form-control input-sm" >
					                <option value="0000">Año</option>
					                <?php foreach ($anios as $anio) { ?>
					                    <option value="<?php echo $anio; ?>"><?php echo $anio; ?></option>
					                <?php } ?>
					            </select>
					        </div><!-- Año -->
						</div>

						<div class="col-lg-4">
							<!-- Estado -->
							<label for="select_estado">Estado</label>
							<select id="select_estado" class="form-control input-sm">
	                            <option value="1">Activo</option>
	                            <option value="0">Inactivo</option>
	                        </select><!-- Estado -->
						</div>

						<div class="col-lg-4">
							<!-- Tipo de campaña -->
							<label for="select_tipo_campana">Tipo de campaña</label>
							<select id="select_tipo_campana" class="form-control input-sm">
								<option value="0">Seleccionar	</option>
								<?php foreach ($tipos as $tipo) { ?>
			                        <option value="<?php echo $tipo->intCodigo; ?>"><?php echo $tipo->strNombre; ?></option>
			                    <?php } ?>
	                        </select><!-- Tipo de campaña -->
						</div>

						<div class="col-lg-4">
							<!-- Valor estimado -->
							<label for="input_valor_estimado">Valor estimado</label>
							<div class="col-sm-12 input-group input-group-sm">
								<span class="input-group-addon">$</span>
			                    <input id="input_valor_estimado" type="text" class="form-control" />
							</div><!-- Valor estimado -->
						</div>

						<div class="col-lg-4">
							<!-- Valor real -->
							<label for="input_valor_real">Valor real</label>
							<div class="col-sm-12 input-group input-group-sm">
								<span class="input-group-addon">$</span>
			                    <input id="input_valor_real" type="text" class="form-control" />
							</div><!-- Valor real -->
						</div>

						<div class="col-lg-4">
							<!-- A invitar -->
           	 				<label for="input_invitar" class="control-label">A invitar</label>
							<input id="input_invitar" class="form-control input-sm" type="text" ><!-- A invitar -->
						</div>

						<div class="col-lg-8">
							<!-- Tipo de campaña -->
							<label for="select_oficinas">Oficinas</label>
							<select id="select_oficinas" class="form-control input-sm">
								<option value="0">Todas las oficinas</option>
								<?php foreach ($oficinas as $oficina) { ?>
			                        <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
			                    <?php } ?>
	                        </select><!-- Tipo de campaña -->
						</div>
					</div><!-- Container -->
	        	</div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</form>
</div><!-- Modal nueva campaña -->

<script type="text/javascript">
	
	// Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_variable').val('');	        
        $("#input_nombre").val('');
        $("#input_descripcion").val('');
        $("#dia_inicio").val('00');
        $("#mes_inicio").val('00');
        $("#anio_inicio").val('0000');
        $("#dia_fin").val('00');
        $("#mes_fin").val('00');
        $("#anio_fin").val('0000');
        $("#select_estado").val('1');
        $("#select_tipo_campana").val('');
        $("#input_valor_estimado").val('');
        $("#input_valor_real").val('');
        $("#input_invitar").val('');
        $("#select_oficinas").val('0');
    }

	// Cuando den clic sobre editar     
    function editar_dato(elemento){    	
    	borrar_formulario();

    	//mostrar_elemento($("#" + elemento));     
        var strNombre = document.getElementById('strNombre'+elemento).innerHTML
        var fecha_inicia = document.getElementById('fecha_inicia'+elemento).innerHTML
        var fecha_finaliza = document.getElementById('fecha_finaliza'+elemento).innerHTML
        var estado = document.getElementById('Estadocampana'+elemento).innerHTML
        var tipo = document.getElementById('tipo_campana'+elemento).innerHTML
        var valor_estimado = document.getElementById('costo_estimado'+elemento).innerHTML             
        var valor_real = document.getElementById('costo_real'+elemento).innerHTML      
        var invitar = document.getElementById('invitado'+elemento).innerHTML      
        var oficina = document.getElementById('oficina'+elemento).innerHTML      
        var descripcion = document.getElementById('descripcion'+elemento).innerHTML           
        var dia_inicio = fecha_inicia.substring(0,2);
        var mes_inicio = fecha_inicia.substring(3,5);
        var anio_inicio = fecha_inicia.substring(6,10);     
        var dia_fin = fecha_finaliza.substring(0,2);     
        var mes_fin = fecha_finaliza.substring(3,5);     
        var anio_fin = fecha_finaliza.substring(6,10);

        //alert("id_variable"+elemento); 
        $('#modal_nueva_campana').modal('show');
        $('#input_id_campana').val(elemento);	        
        $("#input_nombre").val(strNombre);
        $("#input_descripcion").val(descripcion);
        $("#dia_inicio").val(dia_inicio);
        $("#mes_inicio").val(mes_inicio);
        $("#anio_inicio").val(anio_inicio);
        $("#dia_fin").val(dia_fin);
        $("#mes_fin").val(mes_fin);
        $("#anio_fin").val(anio_fin);
        $("#select_estado").val(estado);
        $("#select_tipo_campana").val(tipo);
        $("#input_valor_estimado").val(valor_estimado);
        $("#input_valor_real").val(valor_real);
        $("#input_invitar").val(invitar);
        $("#select_oficinas").val(oficina);
    }

	$(document).ready(function(){

		//Recolección de datos
		var id_campana = $('#input_id_campana');    
        var nombre = $("#input_nombre");
        var descripcion = $("#input_descripcion");
        var dia_inicio = $("#dia_inicio");
        var mes_inicio = $("#mes_inicio");
        var anio_inicio = $("#anio_inicio");
        var dia_fin = $("#dia_fin");
        var mes_fin = $("#mes_fin");
        var anio_fin = $("#anio_fin");
        var estado = $("#select_estado");
        var tipo = $("#select_tipo_campana");
        var valor_estimado = $("#input_valor_estimado");
        var valor_real = $("#input_valor_real");
        var invitar = $("#input_invitar");
        var oficina = $("#select_oficinas");        

        // Inicialización de la tabla
        $('#tbl_campanas').dataTable( {
            "bProcessing": true,
        }); // Tabla

        //Agregar campana
        $("#btn_agregar_campana").on("click", function(){
            //Se abre la ventana
            $('#modal_nueva_campana').modal('show');
            borrar_formulario();
        });//Agregar campana

        //Guardar campaña
        $("#form_campana").on("submit", function(){
    		//Datos a validar
            datos_obligatorios = new Array(
            	nombre.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha completado el registro de la campaña', 'Por favor escriba un nombre para esta campaña.');
            } else {
            	//Arreglo JSON de datos a enviar posteriormente
	            datos_formulario = {
	            	'costo_estimado': valor_estimado.val(),
					'costo_real': valor_real.val(),
					'descripcion': descripcion.val(),
					'Estado': estado.val(),
	            	'fecha_finaliza': dia_inicio.val()+"/"+mes_inicio.val()+"/"+anio_inicio.val()+" 00:00",
	            	'fecha_inicia': dia_fin.val()+"/"+mes_fin.val()+"/"+anio_fin.val()+" 00:00",
	            	'id_agencia': oficina.val(),
	            	'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>",
	            	'id_usuario_creador': "<?php echo $this->session->userdata('id_usuario'); ?>",
	            	// 'id_usuario_asignado': "<?php echo $this->session->userdata('id_usuario'); ?>",
	            	// 'id_usuario_asignado': "<?php echo $this->session->userdata('id_usuario'); ?>",
					'numero_invitados': invitar.val(),
					'strNombre': nombre.val(),
	            	'tipo_campana': tipo.val()
	            };
	            //imprimir(datos_formulario);
	            if(id_campana.val()!=''){
	            	//Se invoca la petición ajax que guardará el registro
		            campana = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "campanas", "campo": "intCodigo", "id_campo": id_campana.val() }, "html");
		            
		            // Si se guardó correctamente
		            if(campana){
						//Se cierra la ventana
			            $('#modal_nueva_campana').modal('hide');

			            //Cuando se termine de cerrar
			            $('#modal_nueva_campana').on('hidden.bs.modal', function (e) {
			                //Se recarga la tabla para que muestre los datos
			                $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'campana'});
			            });
		            }//if

	            }else{ 
		            //Se invoca la petición ajax que guardará el registro
		            campana = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "campanas"}, "html");
		            
		            // Si se guardó correctamente
		            if(campana){
						//Se cierra la ventana
			            $('#modal_nueva_campana').modal('hide');

			            //Cuando se termine de cerrar
			            $('#modal_nueva_campana').on('hidden.bs.modal', function (e) {
			                //Se recarga la tabla para que muestre los datos
			                $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'campana'});
			            });
		            }//if
		        }    

            }//if validacion

        	//Se detiene el formulario
            return false;
        });//Guardar campaña
	});//document.rady
</script>