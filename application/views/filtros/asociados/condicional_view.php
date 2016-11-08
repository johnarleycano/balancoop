<?php
// Carga de datos necesarios
$campos = $this->filtro_model->cargar_campos($tipo);
?>

<!-- Contenedor Condiciones -->
<div id="cont_condicion<?php echo $numero; ?>">
    <legend>
        <!-- Borrar registro -->
        <a href="javascript:eliminar('cont_condicion<?php echo $numero ?>','guardar_condicion<?php echo $numero ?>')" title="Eliminar este cargo">
            <span class="glyphicon glyphicon-remove"></span>                
        </a><!-- Borrar registro -->
    </legend>

    <!-- Condición -->
    <div class="form-group">
        <!-- Campos -->
        <div class="col-lg-4">
            <label for="select_filtro_campo<?php echo $numero; ?>" class="control-label">Campo <?php echo $numero; ?></label>
            <select id="select_filtro_campo<?php echo $numero; ?>" class="form-control input-sm" autofocus>
                <option value="">Seleccione...</option>
                <?php foreach ($campos as $campo) { ?>
                    <option value="<?php echo $campo->intCodigo; ?>"><?php echo $campo->strNombre; ?></option>
                <?php } ?>
            </select>
        </div><!-- Campos -->

        <!-- Condiciones -->
        <div class="col-lg-4">
            <label for="select_filtro_condicion<?php echo $numero; ?>" class="control-label">Condición</label>
            <select id="select_filtro_condicion<?php echo $numero; ?>" class="form-control input-sm" autofocus>
                <option value="">Seleccione primero un campo...</option>
            </select>
        </div><!-- Condiciones -->

        <!-- Detalles -->
        <div class="col-lg-4">
            <label for="cont_detalle<?php echo $numero; ?>" class="control-label">Detalle</label>
            <input id="detalle<?php echo $numero; ?>" class="form-control input-sm" type="text" placeholder="Escriba...">
        </div><!-- Detalles -->
        <label for=""></label>
    </div><!-- Condición -->
</div><!-- Contenedor Condiciones -->

<!-- Si el estado es Guardar, se guardara el registro -->
<div id="cont_condicion_guardar" class="oculto">
    <div class="form-group">
        <!-- Estado Guardado -->
        <div class="col-sm-4">
            <select id="guardar_condicion<?php echo $numero ?>" class="form-control input-sm">
                <option value="true">Guardar</option>
                <option value="">Seleccione...</option>
                <option value="false">Inactivo</option>                    
            </select>
        </div><!-- Estado Guardado -->                
    </div>
</div><!-- cont_cargos_guardar -->

<script type="text/javascript"> 
    function validar_campos(campo){
        //alert('validar que campo no exista en condiciones');
        var campor=0;
        for (var i = 1; i < total_condidionales; i++){
            //Recogemos las variables
            var id_campo = $("#select_filtro_campo" + i);
            var id_condicion = $("#select_filtro_condicion" + i);
            var detalle = $("#detalle" + i);
            var guardar_dato = $("#guardar_condicion" + i).val();
            if(id_campo.val() == campo){
                campor++;
                //alert(campor);
                if(campor>1){
                    id_campo.val('');
                    mostrar_mensaje('el campo ya existe como una condición, seleccione un nuevo campo');
                    i = total_condidionales + 10;                   
                }
            }
        };
    }

    $(document).ready(function(){       
        //Recolección de datos
        var numero = "<?php echo $numero; ?>";
        var campo = $("#select_filtro_campo" + numero);
        var condicion = $("#select_filtro_condicion" + numero);

        /**
         * Cuando se seleccione el campo
         */
        $("#select_filtro_campo" + numero).on("change", function(){
            // Si se selecciona algún campo
            if ($(this).val() != "") {
                //Se invoca la petición ajax que traerá todas las condiciones que aplican para el tipo de campo
                condiciones = ajax("<?php echo site_url('filtros/cargar'); ?>", {"id_campo": $(this).val(), "tipo": "condiciones"}, "json");

                //Si trae resultados
                if (condiciones.length > 0) {
                    //Se resetea el select y se agrega una option vacia
                    $(condicion).html('').append("<option value=''>Seleccione...</option>");

                    //Se recorren las condiciones
                    $.each(condiciones, function(key, val){
                        //Se agrega cada condicion al select
                        $(condicion).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                    })//Fin each
                }// if
            }; //if
        });//Campo change

        if($("#input_intCodigo").val() > 0){                                
            // se cargan las condiciones        
            $('#select_filtro_campo' + "<?php echo $numero ?>" + ' > option[value="<?php echo $datos["id_filtro_campo"]; ?>"]').attr('selected', 'selected');
            //Se invoca la petición ajax que traerá todas las condiciones que aplican para el tipo de campo
            condiciones = ajax("<?php echo site_url('filtros/cargar'); ?>", {"id_campo": "<?php echo $datos['id_filtro_campo']; ?>", "tipo": "condiciones"}, "json");

            //Si trae resultados
            if (condiciones.length > 0) {
                //Se resetea el select y se agrega una option vacia
                $(condicion).html('').append("<option value=''>Seleccione...</option>");

                //Se recorren las condiciones
                $.each(condiciones, function(key, val){
                    //Se agrega cada condicion al select
                    $(condicion).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                })//Fin each
            }// if
            $('#select_filtro_condicion' + "<?php echo $numero ?>" + ' > option[value="<?php echo $datos["id_filtro_condicion"]; ?>"]').attr('selected', 'selected');
            $('#detalle' + "<?php echo $numero ?>").val("<?php echo $datos['detalle']; ?>");                     
        }
    });//document.ready
</script>