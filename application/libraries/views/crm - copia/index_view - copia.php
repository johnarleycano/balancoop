<!-- Opciones de filtrado -->
<div id="panel_filtros" class="well row">
    <!-- Filtrar por (1) -->
    <div class="col-lg-3">
        <div class="form-group">
            <label class="col-sm-12 control-label">Asociados a mí como:</label>
            
            <div class="checkbox">
                <!-- Responsable -->
                <div class="form-group col-sm-6">
                    <label>
                        <input id="filtro_responsable" type="checkbox" value="">
                        Responsable
                    </label>
                </div><!-- Responsable -->

                <!-- Asignado -->
                <div class="form-group col-sm-6">
                    <label>
                        <input id="filtro_asignado" type="checkbox" value="">
                        Asignado
                    </label>
                </div><!-- Asignado -->
            </div>
        </div>
    </div><!-- Filtrar por (1) -->

    <!-- Filtrar por (2) -->
    <div class="col-lg-9">
        <!-- Row -->
        <div class="row">
            <!-- Campaña -->
            <div class="form-group col-sm-2">
                <label for="filtro_campana" class="control-label">Campaña</label>
                <select type="select" id="filtro_campana" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($campanas as $campana) { ?>
                        <option value="<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Campaña -->

            <!-- Oportunidad -->
            <div class="form-group col-sm-2">
                <label for="filtro_oportunidad" class="control-label">Oportunidad</label>
                <select type="select" id="filtro_oportunidad" class="form-control input-sm" autofocus>
                    <option value="">Seleccione</option>
                </select>
            </div><!-- Oportunidad -->

            <!-- Producto -->
            <div class="form-group col-sm-2">
                <label for="filtro_producto" class="control-label">Producto</label>
                <select type="select" id="filtro_producto" class="form-control input-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($productos as $producto) { ?>
                        <option value="<?php echo $producto->intCodigo; ?>"><?php echo $producto->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Producto -->

            <!-- Usuario responsable -->
            <div class="form-group col-sm-2">
                <label for="filtro_usuario_responsable" class="control-label">Responsable</label>
                <select type="select" id="filtro_usuario_responsable" class="form-control input-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <option value="<?php echo $usuario->intCodigo; ?>"><?php echo $usuario->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Usuario responsable -->

            <!-- Usuario asignado -->
            <div class="form-group col-sm-2">
                <label for="filtro_usuario_asignado" class="control-label">Asignado</label>
                <select type="select" id="filtro_usuario_asignado" class="form-control input-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <option value="<?php echo $usuario->intCodigo; ?>"><?php echo $usuario->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Usuario asignado -->
        </div><!-- Row -->
    </div><!-- Filtrar por (2) -->

    <!-- Filtrar por (3) -->
    <div class="col-lg-3">
        <!-- Row -->
        <div class="row">
            <!-- Búsqueda rápida -->
            <div class="form-group col-sm-12">
                <label for="filtro_seleccion_busqueda_rapida" class="control-label">Búsqueda rápida</label>
                <select type="select" id="filtro_seleccion_busqueda_rapida" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($busquedas_rapidas as $busqueda_rapida) { ?>
                        <option value="<?php echo $busqueda_rapida->intCodigo; ?>"><?php echo $busqueda_rapida->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Búsqueda rápida -->
        </div><!-- Row -->
    </div><!-- Filtrar por (3) -->

    <!-- Filtrar por (4) -->
    <div class="col-lg-9">
        <!-- Row -->
        <div class="row">
            <!-- Tipo de filtro -->
            <div class="form-group col-sm-2">
                <label for="filtro_tipo" class="control-label">Tipo de filtro</label>
                <select type="select" id="filtro_tipo" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione</option>
                </select>
            </div><!-- Tipo de filtro -->

            <!-- Importar a -->
            <div class="form-group col-sm-2">
                <label for="filtro_importar" class="control-label">Importar a</label>
                <select id="filtro_importar" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione</option>
                </select>
            </div><!-- Importar a -->

            <!-- Botón exportar -->
            <div class="form-group col-sm-2">
                <label class="control-label">Exportar filtro</label>
                
                <!-- Botón agregar condicional -->
                <button id="btn_exportar" type="button" class="btn btn-success btn-block btn-xs">Exportar</button>
            </div><!-- Botón exportar -->

            <!-- Filtros del sistema -->
            <div class="form-group col-sm-2">
                <label for="filtro_seleccion_sistema" class="control-label">Del sistema</label>
                <select type="select" id="filtro_seleccion_sistema" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($filtros_sistema as $filtro_sistema) { ?>
                        <option value="<?php echo $filtro_sistema->intCodigo; ?>"><?php echo $filtro_sistema->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Filtros del sistema -->

            <!-- Filtro del cliente -->
            <div class="form-group col-sm-2">
                <label for="filtro_seleccion_cliente" class="control-label">Del cliente</label>
                <select type="select" id="filtro_seleccion_cliente" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($filtros_cliente as $filtro_cliente) { ?>
                        <option value="<?php echo $filtro_cliente->intCodigo; ?>"><?php echo $filtro_cliente->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Filtro del cliente -->

            <!-- Filtros del cliente -->
            <div class="form-group col-sm-2">
                <label class="control-label">Gestión de filtros</label>
                
                <!-- Botón agregar condicional -->
                <button id="btn_filtros" type="button" class="btn btn-info btn-block btn-xs">Ir</button>
            </div><!-- Filtros del cliente -->
        </div><!-- Row -->
    </div><!-- Filtrar por (4) -->
</div><!-- Opciones de filtrado -->

<!-- Tabla -->
<div id="crm_tabla"></div>
<br>

<script type="text/javascript" charset="utf-8">
    //Cuando el DOM esté listo
	$(document).ready(function() {
        //Verificamos si el usuario tiene filtro port defecto
        id_filtro_por_defecto = "<?php echo $this->session->userdata('id_filtro_por_defecto'); ?>";

        /**
         * Si trae algun filtro
         */
        if(id_filtro_por_defecto) {
            //Cargamos la interfaz
            $("#crm_tabla").load("listas/cargar_interfaz", {tipo: 'tabla', id_filtro: id_filtro_por_defecto});

            //Se muestra la barra de carga
            cargando($("#crm_tabla"));
        }


        /**
         * Si se cambia algún dato del formulario
         */
        /*$("[id^='filtro_']").on("change", function(){
            imprimir("Cambiado " + $(this).attr('type'))
        });//change*/

        /**
         * Si el filtro es de selección, deberá cambiar toda la tabla
         */
        $("[id^='filtro_seleccion_']").on("change", function(){
            imprimir("Cargando una nueva tabla... Es el filtro " + $(this).val());

            //Cargamos la interfaz
            $("#crm_tabla").load("listas/cargar_interfaz", {tipo: 'tabla', id_filtro: $(this).val()});

            //Se muestra la barra de carga
            cargando($("#crm_tabla"));
        });//change
        


        /**
         * Si el filtro es de adición, deberá agregar un dato 
         * y actualizar la tabla
         */
    });
</script>