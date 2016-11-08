<form id="form_busqueda" role="search">
    <div class="form-group">
        <div class="col-sm-10">
            <input value="" id="input_busqueda" type="text" class="form-control" placeholder="Digite el número de cédula del cliente" autofocus>
        </div>
        <div class="col-sm-2s">
            <button type="submit" class="btn btn-default">Buscar</button>
        </div>
    </div>
</form>

<!-- Input oculto con el id del asociado -->
<input type="hidden" id="input_id_asociado">

<!-- Contenedor de cliente -->
<div id="cont_cliente"></div>

<script type="text/javascript">
    $(document).ready(function(){
    	// Declaración de variables
    	var busqueda = $("#input_busqueda");
    	var id_asociado = $("#input_id_asociado"); 

    	/**
         * Cuando se busque la cédula
         */
        $("#form_busqueda").on("submit", function(){
        	//Validar que se haya escrito algo
        	if($.trim(busqueda.val()) == ""){
                //Se muestra el mensaje de error
                mostrar_mensaje('Digite un número de cédula', 'Por favor digite un número de cédula.');

                return false;
        	}// if

            // Petición para buscar el documento
            encontrado = ajax("<?php echo site_url('cliente/buscar'); ?>", {'documento': busqueda.val()}, 'json');
            
            //Si se encontró
            if(encontrado != 'false'){
                //Se envía el id a un input invisible
                id_asociado.val(encontrado.id_Asociado);
            }

            /**
             * Cargaremos las vistas del asociado, y traeremos contenido, si el id existe
             */
            $("#cont_cliente").load("listas/cargar_interfaz", {"tipo": 'cliente', "id_asociado": id_asociado.val()});

            //Se muestra la barra de carga
            cargando($("#cont_cliente"));
            
            // Se detiene el formulario
            return false;
        });// form busqueda
    });//Document.ready
</script>