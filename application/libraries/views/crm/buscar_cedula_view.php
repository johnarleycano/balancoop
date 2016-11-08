<form id="form_busqueda" role="search">
    <div class="form-group">
        <div class="col-sm-10">
            <input value="" id="input_busqueda" type="text" class="form-control" placeholder="Digite el número de cédula del cliente" autofocus>
        </div>
        <div class="col-sm-2s">
            <button type="submit" class="btn btn-default">Buscar cédula</button>
        </div>
    </div>
</form>

<!-- Contenedor -->
<div id="cont_tabla"></div>

<script type="text/javascript">
    $(document).ready(function(){
        // Declaración de variables
        var busqueda = $("#input_busqueda");

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
            asociado = ajax("<?php echo site_url('crm/buscar_asociado'); ?>", {'documento': busqueda.val()}, 'json');

            // Si se encontró
            if(asociado != 'false'){
                // Consultamos todos los productos del asociado
                productos = ajax("<?php echo site_url('crm/consultar_productos_asociado'); ?>", {'documento': busqueda.val()}, 'json');

                /**
                 * Cargamos la vista
                 */
                $("#cont_tabla").load("listas/cargar_interfaz", {tipo: 'crm_tabla_productos', asociado: asociado, productos: productos});

                //Se muestra la barra de carga
                cargando($("#cont_tabla"));
            } // if

            // Se detiene el formulario
            return false;
        });// form busqueda
    });//Document.ready
</script>