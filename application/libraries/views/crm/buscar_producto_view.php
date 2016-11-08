<form id="form_busqueda" role="search">
    <div class="form-group">
        <div class="col-sm-10">
            <input value="" id="input_busqueda" type="text" class="form-control" placeholder="Digite el producto que desea buscar" autofocus>
        </div>
        <div class="col-sm-2s">
            <button type="submit" class="btn btn-default">Buscar producto</button>
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
                mostrar_mensaje('Digite un nombre', 'Por favor digite un producto o una palabra clave para realizar la búsqueda.');

                return false;
            }else{
                // Consultamos todos los asociados con ese producto
                asociados = ajax("<?php echo site_url('crm/consultar_asociados_producto'); ?>", {'producto': busqueda.val()}, 'json');

                /**
                 * Cargamos la vista
                 */
                $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'crm_tabla_asociados', asociados: asociados});

                //Se muestra la barra de carga
                cargando($("#cont_tabla"));
            } // if

            // Se detiene el formulario
            return false;
        });// form busqueda
    });//Document.ready
</script>