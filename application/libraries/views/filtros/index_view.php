<!-- Cargamos los datos necesarios -->
<?php 
$campos = $this->listas_model->cargar('filtro_campos'); 
//print_r($datos);
//$datosc = "";
//$datos = $datos;
?>
<!-- Formulario -->
<form id="form_filtro" class="form-inline" role="form">
	<!-- Banner de información -->
	<div class="well row">
		<!-- Checks -->
	    <div class="col-lg-2">
	    	<!-- Privado -->
			<div class="checkbox">
				<label><input id="check_privado" type="checkbox"> Privado</label>
			</div><!-- Privado -->

			<!-- Por defecto -->
			<div class="checkbox">
				<label><input id="check_por_defecto" type="checkbox"> Por defecto</label>
			</div><!-- Por defecto -->
		</div><!-- Checks -->
		
		<!-- Nombre del filtro -->
		<div class="col-lg-2">
	        <input type="hidden" id="input_intCodigo" value="">
	        <input id="input_nombre_filtro" class="form-control input-sm" type="text" placeholder="Nombre del filtro" autofocus>
		</div><!-- Nombre del filtro -->
		
		<!-- Como reporte -->
		<div class="col-lg-2">
			<select id="select_como_reporte" class="form-control input-sm">
                <option value="0">No es reporte</option>
                <option value="1">Es reporte</option>
            </select>
		</div><!-- Como reporte -->

		<!-- Filtro de cliente -->
		<div class="col-lg-2">
			<select id="select_filtro_cliente" class="form-control input-sm">
                <option value="0">No es filtro de cliente</option>
                <option value="1">Es filtro de cliente</option>
            </select>
		</div><!-- Filtro de cliente -->

		<!-- Aparece sólo si es usuario super administrador -->
		<?php if($this->session->userdata('tipo') == "3"){ ?>
			<!-- Filtro de sistema -->
			<div class="col-lg-2">
				<select id="select_filtro_sistema" class="form-control input-sm">
	                <option value="0">No es filtro de sistema</option>
	                <option value="1">Es filtro de sistema</option>
	            </select>
			</div><!-- Filtro de sistema -->			
	 	<?php }else{ ?>
			<input id="select_filtro_sistema" type="hidden" value="0">
	 	<?php } ?>
		
		<!-- Búsqueda rápida -->
		<div class="col-lg-2">
			<select id="select_busqueda_rapida" class="form-control input-sm">
                <option value="0">No es filtro de búsqueda rápida</option>
                <option value="1">Es filtro de búsqueda rápida</option>
            </select>
		</div><!-- Búsqueda rápida -->
	</div><!-- Banner de información -->

	<!-- si es filtro del sistema -->
	<div id="si_filtro_sistema" class="oculto" >
		<!-- Condición Filtro -->
		<div class="col-lg-12">
			<div id="condicion_balance" class="col-lg-8">
				<label> Seleccione el tipo de Condicion para balance</label>
				<select id="condicion_filtro_sistema" class="form-control input-sm">
	                <option value="">Select</option>
	                <option value="1">Contar</option>
	                <option value="2">Sumar</option>
	            </select>
        	</div>
    		<div class="col-lg-4">
		        <div id="si_suma" class="oculto" >    
		            <!-- Condición Filtro Balance class="oculto"  -->		            
		        	<label for="select_nombre_campo_balance" class="control-label">Seleccione el Campo a sumar</label>
		            <select id="select_campo_balance" class="form-control input-sm" autofocus>
		                <option value="">Seleccione el campo...</option>
		                <?php foreach ($campos as $campo) { ?>
		                    <option value="<?php echo $campo->intCodigo; ?>" ><?php echo $campo->strNombre; ?></option>
		                <?php } ?>
		            </select>
				</div>
            </div>
            <label for=""></label>     
        </div><!-- Condiciones -->
	</div><!-- si es filtro del sistema -->

	<!-- Columna 1 (Wheres) -->
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"></span>Constructor de condiciones</h3>
            </div><!-- panel-heading -->

            <div class="panel-body">
				<!-- Contenedor para agregar los condicionales -->
	            <div id="cont_condicionales">
	            	
	            </div><!-- Contenedor para agregar los condicionales -->
	            
	            <!-- Botón agregar condicional -->
    			<button id="btn_agregar_condicional" type="button" class="btn btn-info btn-block btn-xs">Agregar nueva condición</button>
			</div><!-- panel-body -->
		</div><!-- panel panel-primary -->
	</div><!-- Columna 1 (Wheres) -->

	<!-- Columna 2 (Selects) -->
	<div class="col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"></span> Campos a mostrar</h3>
            </div>
            <div class="panel-body">
				<div id="campos"></div>
				
            	<!-- Botón agregar campo -->
    			<button id="btn_agregar_campo" type="button" class="btn btn-info btn-block btn-xs">Agregar nuevo campo</button>
			</div><!-- panel-body -->
		</div><!-- panel panel-primary -->
	</div><!-- Columna 2 (Selects) -->

	<!-- Botón de guardado del filtro -->
	<input type="submit" class="btn btn-success btn-block" value="Guardar filtro"></input>
</form><!-- Formulario -->
<p></p>

<!-- Contenedor donde se cargará la información -->
<div id="cont_filtros"></div>

<script type="text/javascript">

	$(document).ready(function(){
		//Cargamos la tabla
        $("#cont_filtros").load("listas/cargar_interfaz", {tipo: 'tabla_filtros'});

        //Se muestra la barra de carga
        cargando($("#cont_filtros"));

		// Recolección de datos
		var id_filtro = $("#input_intCodigo");
		var busqueda_rapida = $("#select_busqueda_rapida");
		var como_reporte = $("#select_como_reporte");
		var filtro_cliente = $("#select_filtro_cliente");
		var filtro_sistema = $("#select_filtro_sistema");
		var nombre = $("#input_nombre_filtro");
		var por_defecto = $("#check_por_defecto");
		var por_filtrosistema = $("#si_filtro_sistema");
		var condicion_filtrosistema = $("#condicion_filtro_sistema");
		var select_campo_balance = $("#select_campo_balance");
		var si_suma = $("#si_suma");
		var condicion_balance = $("#condicion_balance");		
		
		//Contador de condicionales
        total_condidionales = 1;

        /**
		 * Cuando se seleccione filtro del sistema
		 */
		$(filtro_sistema).on("change", function(){
			//alert('entro ala funcion1');			
			// Si se selecciona algún campo
			if ($(this).val() != "") {
				//alert($(this).val());
				//Si trae resultados
            	if ($(this).val() == "1") {
            		//alert("el filtro del sistema muestra combo de condiciones");
            		mostrar_elemento(por_filtrosistema);
            		condicion_balance.attr('class','col-lg-12');


            	}else{ 
            		//alert("el filtro del sistema oculta combo de condiciones y oculta checkbox");        			
        			$(condicion_filtrosistema).val('');    		
            		ocultar_elemento(por_filtrosistema);
            		$(select_campo_balance).val('');
            		ocultar_elemento(si_suma); 
            	}// if
			}; //if
		});//Campo change

		/**
		 * Cuando se seleccione filtro del sistema
		 */
		$(condicion_filtrosistema).on("change", function(){
			//alert('entro ala funcion1');			
			// Si se selecciona algún campo
			if ($(this).val() != "") {
				//alert($(this).val());
				//Si trae resultados
            	if ($(this).val() == "1") {
            		//alert("1");            		
            		//alert("se debe crear count por el id_asociado");            		
            		condicion_balance.attr('class','col-lg-12');
            		ocultar_elemento(si_suma);            		
            	}else{ 
            		//alert("2");
            		//alert("se deben mostrar checkbox en los campos");
            		condicion_balance.attr('class','col-lg-8');
            		mostrar_elemento(si_suma);

            		//ocultar_elemento(por_filtrosistema);
            	}// if
			}; //if
		});//Campo change

        //Agregar condicional
        $("#btn_agregar_condicional").on("click", function(){
            //En el contenedor de condicionales, agregamos un contenedor por cada condición nueva
            $("#cont_condicionales").append("<div id='condicional" + total_condidionales + "'></div>");

            //Cargamos la vista en el div
            $("#condicional" + total_condidionales).load("<?php echo site_url('filtros/agregar/condicional'); ?>", {"numero": total_condidionales});

            //Se muestra la barra de carga
            cargando($("#condicional" + total_condidionales));

            //Se aumenta el total de condicionales
            total_condidionales++;
        });//Agregar condicional

        //Contador de campos
        total_campos = 1;

        //Agregar campo
        $("#btn_agregar_campo").on("click", function(){
            // Si el total de campos no supera los 14 permitidos
            if(total_campos < 15) {
            	//En el contenedor de campos, agregamos un contenedor por cada condición nueva
	            $("#campos").append("<div id='campo" + total_campos + "'></div>");

	            //Cargamos la vista en el div
	            $("#campo" + total_campos).load("<?php echo site_url('filtros/agregar/campo'); ?>", {numero: total_campos});	            

            } else {
				//Se muestra el mensaje de exito
            	mostrar_mensaje('Advertencia', 'No se pueden agregar más campos a este filtro');
            }// if

            //Se aumenta el total de campos
            total_campos++;
        });//Agregar campo

        //Submit
        $("#form_filtro").on("submit", function(){
        	//Primero, validaremos el nombre
        	var datos_obligatorios = new Array(nombre.val());

    		//Se ejecuta la validación del nombre
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón del nombre
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha guardado el filtro', 'Por favor digite un nombre para este filtro.');

                return false;
            //Después, verificaremos que haya seleccionado algún select
            } else if(busqueda_rapida.val() == "0" && como_reporte.val() == "0" && filtro_cliente.val() == "0" && filtro_sistema.val() == "0") {
	            //Se muestra el mensaje de error
	            mostrar_mensaje('Advertencia', 'El filtro debe ser como reporte, de cliente, de sistema o de búsqueda rápida.');
	            
	            return false;
            //Y también verificamos que haya al menos una condición y un campo
	        }else if(total_condidionales == 1 || total_campos == 1){
        		//Se muestra el mensaje de error
	            mostrar_mensaje('Advertencia', 'Seleccione al menos una condición y un campo para mostrar.');
	            
	            return false;
	        }else{
		        //Recorremos los condicionales para verificar que se hayan llenado
		        //alert(total_condidionales);
	        	for (var i = 1; i < total_condidionales; i++){
	        		//Recogemos las variables
	        		var id_campo = $("#select_filtro_campo" + i);
	        		var id_condicion = $("#select_filtro_condicion" + i);
	        		var detalle = $("#detalle" + i);

	        		//Datos a validar
		            datos_obligatorios = new Array(
		                id_campo.val(),
						id_condicion.val()
		            );
		            var guardar_condicion = $("#guardar_condicion" + i).val();
                    //se valida que el registro se guarde
                    if(guardar_condicion=='true'){
			            //Se ejecuta la validación de los campos obligatorios
		    			validacion = validar_campos_vacios(datos_obligatorios);

		    			//Si no supera la validacíón
			            if (!validacion) {
			                //Se muestra el mensaje de error
			                mostrar_mensaje('Advertencia', 'Por favor seleccione el campo y la condición número ' + i);

			                return false;
			            }//if
			        }    
	        	};//for condicionales
	        	//alert(total_campos);
	        	//Recorremos los campos para verificar que se hayan llenado
	        	for (var i = 1; i < total_campos; i++){
	        		//Recogemos las variables
	        		var id_campo = $("#select_campo" + i);

	        		//Datos a validar
		            datos_obligatorios = new Array(
		                id_campo.val()
		            );
		            var guardar_campo = $("#guardar_campo" + i).val();
                    //se valida que el registro se guarde
                    if(guardar_campo=='true'){
			            //Se ejecuta la validación de los campos obligatorios
		    			validacion = validar_campos_vacios(datos_obligatorios);

		    			//Si no supera la validacíón
			            if (!validacion) {
			                //Se muestra el mensaje de error
			                mostrar_mensaje('Advertencia', 'Por favor seleccione el campo ' + i);

			                return false;
			            }
			        }    
	        	};//for campos

				//Se verifica si será privado o público
				if ($("#check_privado").is(':checked')) {var privado = "1"}else{var privado = "0"}
				//Se verifica si se guarda o se actualiza	
				//alert(id_filtro.val());
				if(id_filtro.val() != ''){
					
					//Arreglo JSON de datos a enviar posteriormente
		            datos_filtro = {
	            		'busqueda_rapida': busqueda_rapida.val(),
						'es_cliente': filtro_cliente.val(),
						'es_reporte': como_reporte.val(),
						'es_sistema': filtro_sistema.val(),
						'id_asociado': "<?php echo $this->session->userdata('id_usuario'); ?>",
						'id_usuario': "<?php echo $this->session->userdata('id_usuario'); ?>",
						'strNombre': nombre.val(),
						'privado': privado,
						'id_Filtro_balance': condicion_filtrosistema.val(),
						'id_campo_balance': select_campo_balance.val()						
		            };// datos_filtro
		            // imprimir(datos_filtro)
		            
		            //Se invoca la petición ajax que eliminara los filtros
	            	borrar = ajax("<?php echo site_url('filtros/actualizar'); ?>", {"datos": datos_filtro, "tipo": "borrar", 'id':id_filtro.val()}, "JSON");


		            //Se invoca la petición ajax que guardará el filtro
	            	filtro = ajax("<?php echo site_url('filtros/actualizar'); ?>", {"datos": datos_filtro, "tipo": "filtro", 'id':id_filtro.val()}, "JSON");

	            	// Si por defecto está chequeado
					if (por_defecto.is(':checked')) {
						//Actualizamos el filtro del usuario por defecto vía ajax
						ajax("<?php echo site_url('filtros/cambiar_filtro_por_defecto'); ?>", {'id_filtro': id_filtro.val()}, 'html');
					};

					//Si se recibe respuesta correcta
	            	if (filtro != "false") {
	            		//Recorremos los condicionales
		            	for (var i = 1; i < total_condidionales; i++){
		            		//Recogemos las variables
		            		var id_campo = $("#select_filtro_campo" + i);
		            		var id_condicion = $("#select_filtro_condicion" + i);
		            		var detalle = $("#detalle" + i);
		            		var guardar_condicion = $("#guardar_condicion" + i).val();
		                    //se valida que el registro se guarde
		                    if(guardar_condicion=='true'){
			            		//Datos a validar
					            datos_obligatorios = new Array(
					                id_campo.val(),
									id_condicion.val()
					            );

					            //Se ejecuta la validación de los campos obligatorios
		            			validacion = validar_campos_vacios(datos_obligatorios);

		            			//Si no supera la validacíón
					            if (!validacion) {
					                //Se muestra el mensaje de error
					                mostrar_mensaje('Advertencia', 'Por favor seleccione el campo y la condición ' + i);
					                return false;
					            } else {
					            	//Arreglo JSON de datos a enviar posteriormente
			            			datos_condicional = {
				            			'id_filtro': id_filtro.val(),
				            			'id_filtro_campo': id_campo.val(),
										'id_filtro_condicion': id_condicion.val(),
										'detalle': detalle.val(),
				            		}//datos_condicional
				            		// imprimir(datos_condicional)

				            		//Por medio de ajax insertamos cada condicional
			                    	ajax("<?php echo site_url('filtros/actualizar') ?>", {'datos': datos_condicional, "tipo": "condicional",'id':id_filtro.val()}, 'html');
					            };//Fin validacion
					        };    
		            	};//for condicionales

		            	//Recorremos los campos
		            	for (var i = 1; i < total_campos; i++){
		            		//Recogemos las variables
		            		var id_campo = $("#select_campo" + i);
		            		var guardar_campo = $("#guardar_campo" + i).val();
		                    //se valida que el registro se guarde
		                    if(guardar_campo=='true'){
			            		//Datos a validar
					            datos_obligatorios = new Array(
					                id_campo.val()
					            );

					            //Se ejecuta la validación de los campos obligatorios
		            			validacion = validar_campos_vacios(datos_obligatorios);

		            			//Si no supera la validacíón
					            if (!validacion) {
					                //Se muestra el mensaje de error
					                mostrar_mensaje('Advertencia', 'Por favor seleccione el campo ' + i);

					                return false;
					            } else {
					            	//Arreglo JSON de datos a enviar posteriormente
			            			datos_campo = {
				            			'id_filtro': id_filtro.val(),
				            			'id_filtro_campo': id_campo.val()
				            		}//datos_campo
				            		// imprimir(datos_campo)

				            		//Por medio de ajax insertamos cada campo
			                    	ajax("<?php echo site_url('filtros/actualizar') ?>", {'datos': datos_campo, "tipo": "campo",'id':id_filtro.val()}, 'html');
					            };//Fin validacion
					        };    
		            	};//for campos

	                    //Se muestra el mensaje de exito
		            	mostrar_mensaje('Actualización exitosa', 'El filtro se Actualizó exitosamente.');

		            	//Cargamos la tabla
				        $("#cont_filtros").load("listas/cargar_interfaz", {tipo: 'tabla_filtros'});

				        //Se muestra la barra de carga
				        cargando($("#cont_filtros"));

				        //Se limpia el formulario
	                    limpiar("#form_filtro");
	                    $("#campos").html('').append("<div id='condicional" + total_condidionales + "'></div>");
	                    $("#cont_condicionales").html('').append("<div id='condicional" + total_condidionales + "'></div>");
	                    $(condicion_filtrosistema).val('');    		
	            		ocultar_elemento(por_filtrosistema);
	            		$(select_campo_balance).val('');
	            		ocultar_elemento(si_suma); 
        
	            	}; //if
				}else{	
	            	//Arreglo JSON de datos a enviar posteriormente
		            datos_filtro = {
	            		'busqueda_rapida': busqueda_rapida.val(),
						'es_cliente': filtro_cliente.val(),
						'es_reporte': como_reporte.val(),
						'es_sistema': filtro_sistema.val(),
						'id_asociado': "<?php echo $this->session->userdata('id_usuario'); ?>",
						'id_usuario': "<?php echo $this->session->userdata('id_usuario'); ?>",
						'strNombre': nombre.val(),
						'privado': privado,
						'id_Filtro_balance': condicion_filtrosistema.val(),
						'id_campo_balance': select_campo_balance.val()	
		            };// datos_filtro
		            // imprimir(datos_filtro)

		            //Se invoca la petición ajax que guardará el filtro
	            	filtro = ajax("<?php echo site_url('filtros/guardar'); ?>", {"datos": datos_filtro, "tipo": "filtro"}, "JSON");

	            	// Si por defecto está chequeado
					if (por_defecto.is(':checked')) {
						//Actualizamos el filtro del usuario por defecto vía ajax
						ajax("<?php echo site_url('filtros/cambiar_filtro_por_defecto'); ?>", {'id_filtro': filtro.id_filtro}, 'html');
					};

					//Si se recibe respuesta correcta
	            	if (filtro != "false") {
	            		//Recorremos los condicionales
		            	for (var i = 1; i < total_condidionales; i++){
		            		//Recogemos las variables
		            		var id_campo = $("#select_filtro_campo" + i);
		            		var id_condicion = $("#select_filtro_condicion" + i);
		            		var detalle = $("#detalle" + i);
		            		var guardar_condicion = $("#guardar_condicion" + i).val();
		                    //se valida que el registro se guarde
		                    if(guardar_condicion=='true'){
			            		//Datos a validar
					            datos_obligatorios = new Array(
					                id_campo.val(),
									id_condicion.val()
					            );

					            //Se ejecuta la validación de los campos obligatorios
		            			validacion = validar_campos_vacios(datos_obligatorios);

		            			//Si no supera la validacíón
					            if (!validacion) {
					                //Se muestra el mensaje de error
					                mostrar_mensaje('Advertencia', 'Por favor seleccione el campo y la condición ' + i);
					                return false;
					            } else {
					            	//Arreglo JSON de datos a enviar posteriormente
			            			datos_condicional = {
				            			'id_filtro': filtro.id_filtro,
				            			'id_filtro_campo': id_campo.val(),
										'id_filtro_condicion': id_condicion.val(),
										'detalle': detalle.val(),
				            		}//datos_condicional
				            		// imprimir(datos_condicional)

				            		//Por medio de ajax insertamos cada condicional
			                    	ajax("<?php echo site_url('filtros/guardar') ?>", {'datos': datos_condicional, "tipo": "condicional"}, 'html');
					            };//Fin validacion
					        };    
		            	};//for condicionales

		            	//Recorremos los campos
		            	for (var i = 1; i < total_campos; i++){
		            		//Recogemos las variables
		            		var id_campo = $("#select_campo" + i);
		            		var guardar_campo = $("#guardar_campo" + i).val();
		                    //se valida que el registro se guarde
		                    if(guardar_campo=='true'){
			            		//Datos a validar
					            datos_obligatorios = new Array(
					                id_campo.val()
					            );

					            //Se ejecuta la validación de los campos obligatorios
		            			validacion = validar_campos_vacios(datos_obligatorios);

		            			//Si no supera la validacíón
					            if (!validacion) {
					                //Se muestra el mensaje de error
					                mostrar_mensaje('Advertencia', 'Por favor seleccione el campo ' + i);

					                return false;
					            } else {
					            	//Arreglo JSON de datos a enviar posteriormente
			            			datos_campo = {
				            			'id_filtro': filtro.id_filtro,
				            			'id_filtro_campo': id_campo.val()
				            		}//datos_campo
				            		// imprimir(datos_campo)

				            		//Por medio de ajax insertamos cada campo
			                    	ajax("<?php echo site_url('filtros/guardar') ?>", {'datos': datos_campo, "tipo": "campo"}, 'html');
					            };//Fin validacion
					        };    
		            	};//for campos

	                    //Se muestra el mensaje de exito
		            	mostrar_mensaje('Registro exitoso', 'El filtro se guardó exitosamente.');

		            	//Cargamos la tabla
				        $("#cont_filtros").load("listas/cargar_interfaz", {tipo: 'tabla_filtros'});

				        //Se muestra la barra de carga
				        cargando($("#cont_filtros"));

				        //Se limpia el formulario
	                    limpiar("#form_filtro");
	                    $("#campos").html('').append("<div id='condicional" + total_condidionales + "'></div>");
	                    $("#cont_condicionales").html('').append("<div id='condicional" + total_condidionales + "'></div>");
	                    $(condicion_filtrosistema).val('');    		
	            		ocultar_elemento(por_filtrosistema);
	            		$(select_campo_balance).val('');
	            		ocultar_elemento(si_suma); 
	            	}; //if
				
				}//fin	
			}//if validacion
            //Se detiene el formulario
            return false;
        });//Fin form
	});// document.ready 
</script>