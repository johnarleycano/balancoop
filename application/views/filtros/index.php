<!-- Opciones de filtros -->
<center>
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-default" onClick="javascript:cargar('asociados')">Asociados</button>
        <button type="button" class="btn btn-default" onClick="javascript:cargar('productos')">Productos</button>
    </div>
<center>

<!-- Contenedor de filtro -->
<div id="cont_filtro"></div>

<!-- Contenedor de modal -->
<div id="cont_modal"></div>

<script type="text/javascript">
	/**
	 * Agregar un dato
	 * @param  {string} tipo Campo, condicional, etc
	 * @return {[type]}      [description]
	 */
	function agregar(tipo)
	{
		// // Se toma el valor del contador de campos
		// var total_campos = $("#contador_campos");

		// // Suiche (dependiendo del tipo)
		// switch(tipo) {
		// 	// Campo de asociado
		//     case "campo":
		//     	//Se aumenta el total de campos
		//     	total_campos.val(parseInt(total_campos.val())+1);
       
  //           	// Si el total de campos no supera los 14 permitidos
  //           	if(total_campos.val() > 14) {
  //           		//Se muestra el mensaje
  //               	mostrar_mensaje('Advertencia', 'No se pueden agregar más campos a este filtro');

  //               	return false;
  //           	} // if

  //           	// En el contenedor de campos, agregamos un contenedor por cada condición nueva
  //               $("#cont_campos").append("<div id='campo" + total_campos.val() + "'></div><br>");

  //               //Cargamos la vista en el div
  //               $("#campo" + total_campos.val()).load("<?php echo site_url('filtros/agregar/campo'); ?>", {"numero": total_campos.val(), "tipo": 1});
  //       	break; // Campo de asociado

		// 	// Condicional de asociado
		//     case "condicional":
	 //        	imprimir("agregando condicional")

  //       	break; // Condicional de asociado
		// } // suiche
	} // agregar

	/**
	 * Función que carga los filtros
	 * @return void 
	 */
	function cargar(tipo)
	{
		//Se muestra la barra de carga
        cargando($("#cont_filtro"));

		// Se carga la interfaz
        $("#cont_filtro").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: "filtro_" + tipo});
	} // cargar

	/**
	 * Función que se activa al presionar el botón crear del menú
	 * @return void 
	 */
	function crear(tipo)
	{
		// Se carga la interfaz
	    $("#cont_modal").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "filtro_" + tipo + "_crear", "id": 0});
	} // crear

	/**
	 * Función que se activa al presionar el botón editar del menú
	 * @return void 
	 */
	function editar(tipo, id)
	{
		// Se carga la interfaz
	    $("#cont_modal").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {"tipo": "filtro_" + tipo + "_crear", "id": id});
	} // editar

	/**
	 */
	function eliminar(tipo, identificador)
	{
		// // Suiche (dependiendo del tipo)
		// switch(tipo) {
		// 	// Campo de asociado
		//     case "campo":
		//     	// Se marca el select como inactivo
		//     	$("#select_campo" + identificador).attr("data-activo", 0);

		//     	// Se reduce el contador
		// 		$("#contador_campos").val(parseInt($("#contador_campos").val()) - 1);

		//     	// Se oculta
		//     	$("#cont_campo" + identificador).slideUp('slow');
  //       	break; // Campo de asociado
		// } // suiche
	} // eliminar

	/**
	 * Guardar en base de datos 
	 */
	function guardar(tipo){
    	// Recolección del id
    	var id_filtro = $("#id_filtro").val();
		
		// Suiche (dependiendo del tipo)
		switch(tipo) {
			// Asociados
		    case "asociados":
		    	// Recolección de datos
        		var nombre = $("#input_nombre_filtro");
		        var filtro_cliente = $("#select_filtro_cliente");
		        var filtro_sistema = $("#select_filtro_sistema");
		        var busqueda_rapida = $("#select_busqueda_rapida");
        		var por_defecto = $("#check_por_defecto");

		    	/********************************************************************
		        *************************** Datos básicos ***************************
		        ********************************************************************/
		    	// Arreglo de datos a validar
			    datos_basicos_obligatorios = new Array(
			    	nombre.val()
		    	);
		    	// imprimir(datos_basicos_obligatorios);

		    	//Se ejecuta la validación del nombre
	            validacion = validar_campos_vacios(datos_basicos_obligatorios);

	            // Si no supera la validacíón del nombre
	            if (!validacion) {
	                //Se muestra el mensaje de error
	                mostrar_mensaje('Aun no se ha guardado el filtro', 'Por favor digite un nombre para este filtro.');

	                return false;
	            } // if

		    	/********************************************************************
		        ****************************** Campos *******************************
		        ********************************************************************/
		    	// Arreglo de datos a validar
			    datos_campos_obligatorios = new Array(
			    	$("#select_campo1").val()
		    	);

		    	//Se ejecuta la validación de los campos obligatorios
    			validacion = validar_campos_vacios(datos_campos_obligatorios);

    			//Si no supera la validacíón
			    if (!validacion) {
			        //Se muestra el mensaje de error
                	mostrar_mensaje('Aun no se ha guardado el filtro', 'Por favor, seleccione al menos el primer campo');

			        return false;
			    } // if

            	// Verificaremos que haya seleccionado algún select
	            if(busqueda_rapida.val() == "0" && filtro_cliente.val() == "0" && filtro_sistema.val() == "0"){
	                //Se muestra el mensaje de error
	                mostrar_mensaje('Advertencia', 'El filtro debe ser de cliente, de sistema o de búsqueda rápida. Seleccione al menos una opción, por favor.');
	            } // if

    			/********************************************************************
		        *************************** Condicionales ***************************
		        ********************************************************************/
				// Arreglo de datos a validar
			    datos_campos_obligatorios = new Array(
			    	$("#select_campo_condicion1").val(),
			    	$("#select_condicion1").val()
		    	);

		    	//Se ejecuta la validación de los campos obligatorios
    			validacion = validar_campos_vacios(datos_campos_obligatorios);

    			//Si no supera la validacíón
			    if (!validacion) {
			        //Se muestra el mensaje de error
                	mostrar_mensaje('Aun no se ha guardado el filtro', 'Por favor, configure al menos una condición (campo, condición y detalle).');

			        return false;
			    } // if

			    //Se verifica si será privado o público
	            if ($("#check_privado").is(':checked')) {
	                var privado = 1;
	            }else{
	                var privado = 0;
	            } // if

			    //Se verifica si está activo o no
	            if ($("#check_activo").is(':checked')) {
	                var activo = 1;
	            }else{
	                var activo = 0;
	            } // if

	            // Se recorren las condiciones para verificar que estén llenas
    			for (var i = 1; i <= $("#total_condiciones").val(); i++) {
    				// Si el campo tiene información
    				if ($("#select_campo_condicion" + i).val() != "") {
    					// Si no ha elegido una condición
    					if ($("#select_condicion" + i).val() == "") {
    						//Se muestra el mensaje de error
        					mostrar_mensaje('No se ha podido continuar', "La condición para el campo " + i + " (" + $("#select_campo_condicion" + i + " option:selected").text() + ") no se ha configurado todavía.");

        					return false;
    					};
    				} // if
    			} // for

			   // arreglo con los datos
			    datos = {
			        "strNombre": nombre.val(),
					// "es_reporte": ,
					"es_sistema": filtro_sistema.val(),
					"es_cliente": filtro_cliente.val(),
					"busqueda_rapida": busqueda_rapida.val(),
					"id_asociado": "<?php echo $this->session->userdata('id_usuario'); ?>",
					"privado": privado,
					"Estado": activo,
					"id_usuario": "<?php echo $this->session->userdata('id_usuario'); ?>",
					// "id_Filtro_balance": ,
					// "id_campo_balance": 
			    }
			    // imprimir(datos);

			    // Si trae un id
			    if(id_filtro){
			        // Se actualiza el filtro
                    ajax("<?php echo site_url('filtros/actualizar'); ?>", {"tipo": "filtro", "datos": datos, 'id':id_filtro}, "JSON");
                    
                    // Arreglo con el id del filtro
                    id = {"id_filtro": id_filtro}

                    // Se borran los campos y condiciones del filtro creado
                    ajax("<?php echo site_url('filtros/actualizar'); ?>", {"tipo": "borrar", 'id': id_filtro}, "html");
			    } else {
			    	//Se invoca la petición ajax que guardará el filtro
                	id = ajax("<?php echo site_url('filtros/guardar'); ?>", {"tipo": "filtro", "datos": datos}, "JSON");
			    } // if
			    // imprimir(id.id_filtro);

	        	// Si por defecto está chequeado
                if (por_defecto.is(':checked')) {
                    //Actualizamos el filtro del usuario por defecto vía ajax
                    ajax("<?php echo site_url('filtros/cambiar_filtro_por_defecto'); ?>", {'id_filtro': id.id_filtro}, 'html');
                } // if

    			// Se recorren los campos
    			for (var i = 1; i <= $("#total_campos").val(); i++) {
    				// Si el campo tiene información
    				if ($("#select_campo" + i).val() != "") {
    					// Datos a guardar
    					datos_campo = {
                            'id_filtro': id.id_filtro,
                            'id_filtro_campo': $("#select_campo" + i).val()
    					}

    					// Se guarda en base de datos
                        ajax("<?php echo site_url('filtros/guardar') ?>", {'datos': datos_campo, "tipo": "campo"}, 'html');
    				} // if
    			} // for

    			// Se recorren las condiciones para guardar
    			for (var i = 1; i <= $("#total_condiciones").val(); i++) {
    				// Si el campo tiene información
    				if ($("#select_campo_condicion" + i).val() != "") {
    					// Datos a guardar
    					datos_condicional = {
                            'id_filtro': id.id_filtro,
                            'id_filtro_campo': $("#select_campo_condicion" + i).val(),
                            'id_filtro_condicion': $("#select_condicion" + i).val(),
                            'detalle': $("#input_detalle" + i).val(),
    					}
    					// imprimir(datos_condicional);
    					
    					// Se inserta cada condicional
                        ajax("<?php echo site_url('filtros/actualizar') ?>", {"tipo": "condicional", 'datos': datos_condicional, 'id':id.id_filtro}, 'html');
    				} // if
    			} // for
        	break; // Asociados
		} // suiche

		//Se cierra la ventana
        $('#modal_filtro').modal('hide');

        //Cuando se termine de cerrar
        $('#modal_filtro').on('hidden.bs.modal', function (e) {
            //Se muestra el mensaje de exito
	        mostrar_mensaje('Registro exitoso', 'El filtro se guardó exitosamente.');

	        // Se recarga la interfaz
	        cargar(tipo);
        });
	} // guardar

	/**
	 * Listado de los registros
	 */
	function listar()
	{
		//De entrada. cargamos la interfaz de filtros de asociado
        cargar("asociados");
	} // listar

    // Cuando el DOM esté listo
    $(document).ready(function(){
    	// Por defecto, cargamos la interfaz de la tabla
		listar();
    });//document.ready
</script>