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
                        <input id="check_responsable" type="checkbox" value="">
                        Responsable
                    </label>
                </div><!-- Responsable -->

                <!-- Asignado -->
                <div class="form-group col-sm-6">
                    <label>
                        <input id="check_asignado" type="checkbox" value="">
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
                <label for="select_campana" class="control-label">Campaña</label>
                <select type="select" id="select_campana" class="form-control input-sm col-sm" autofocus>
                    <option value="">Seleccione...</option>
                    <?php foreach ($campanas as $campana) { ?>
                        <option value="<?php echo $campana->intCodigo; ?>"><?php echo $campana->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Campaña -->

            <!-- Oportunidad -->
            <div class="form-group col-sm-2">
                <label for="select_oportunidad" class="control-label">Oportunidad</label>
                <select type="select" id="select_oportunidad" class="form-control input-sm" >
                    <option value="">Seleccione</option>
                    <option value="1">Con oportunidad</option>
                    <option value="2">Sin oportunidad</option>                    
                </select>
            </div><!-- Oportunidad -->

            <!-- Producto -->
            <div class="form-group col-sm-2">
                <label for="filtro_producto" class="control-label">Producto</label>
                <input id="input_producto" type="text" class="form-control input-sm" >
            </div><!-- Producto -->

            <!-- Usuario responsable -->
            <div class="form-group col-sm-2">
                <label for="select_responsable" class="control-label">Responsable</label>
                <select type="select" id="select_responsable" class="form-control input-sm">
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <option value="<?php echo $usuario->intCodigo; ?>"><?php echo $usuario->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Usuario responsable -->

            <!-- Usuario asignado -->
            <div class="form-group col-sm-2">
                <label for="select_asignado" class="control-label">Asignado</label>
                <select type="select" id="select_asignado" class="form-control input-sm">
                    <option value="">Seleccione...</option>
                    <?php foreach ($usuarios as $usuario) { ?>
                        <option value="<?php echo $usuario->intCodigo; ?>"><?php echo $usuario->strNombre; ?></option>
                    <?php } ?>
                </select>
            </div><!-- Usuario asignado -->
        </div><!-- Row -->
    </div><!-- Filtrar por (2) -->

    <!-- Botón de generar filtros -->
    <button id="btn_generar_filtro" type="button" class="btn btn-info btn-block btn-xs">Generar CRM con los nuevos filtros</button>

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

            <!-- Importar a -->
            <div class="form-group col-sm-2">
                <label for="filtro_importar" class="control-label">Importar a</label>
                <select id="filtro_importar" class="form-control input-sm col-sm">
                    <option value="">Seleccione</option>
                    <option value="1">campaña</option>                    
                    <option value="2">Hoja de vida</option>
                    <option value="3">Productos</option>
                    <option value="4">Oportunidades</option>
                </select>
            </div><!-- Importar a -->

            <!-- Botón exportar -->
            <div class="form-group col-sm-2">
                <label class="control-label">Exportar filtro</label>
                
                <!-- Botón agregar condicional -->
                <button id="btn_exportar" type="button" class="btn btn-success btn-block btn-xs">Exportar</button>
            </div><!-- Botón exportar -->

            <!-- Ir a filtros -->
            <div class="form-group col-sm-2">
                <!-- <label class="control-label">Gestión de filtros</label>
                               
               Botón agregar condicional
               <button id="btn_filtros" type="button" class="btn btn-info btn-block btn-xs">Ir</button> 
                -->               
            </div><!-- Ir a filtros -->
        </div><!-- Row -->
    </div><!-- Filtrar por (4) -->
</div><!-- Opciones de filtrado -->

<!-- SQLs -->
<div id="cont_sql"></div>

<!-- Tabla -->
<div id="tabla"></div>

<script type="text/javascript">
    //Cuando el DOM esté listo
    $(document).ready(function() {
        // //Verificamos si el usuario tiene filtro port defecto
        // id_filtro_por_defecto = "<?php echo $this->session->userdata('id_filtro_por_defecto'); ?>";

        // /**
        //  * Si trae algun filtro
        //  */
        // if(id_filtro_por_defecto) {
        //     imprimir('El filtro por defecto es ' + id_filtro_por_defecto)

        //     //Cargamos la interfaz
        //     $("#crm_tabla").load("listas/cargar_interfaz", {tipo: 'tabla', id_filtro: id_filtro_por_defecto});
            
        //     //Se muestra la barra de carga
        //     cargando($("#crm_tabla"));
        // }// if

        /**
         * Si el filtro es de selección, deberá cambiar toda la tabla
         */
        $("[id^='filtro_seleccion_']").on("change", function(){
            if ($(this).val() != "") {
                imprimir("Cargando una nueva tabla... Es el filtro " + $(this).val());

                //Cargamos la interfaz
                $("#tabla").load("listas/cargar_interfaz", {tipo: 'tabla', id_filtro: $(this).val()});

                //Se muestra la barra de carga
                cargando($("#tabla"));
            };
        });//change 

        // /**
        //  * Cuando se dé clic en generar filtros aplicados
        //  */
        // $("#btn_generar_filtro").on('click', function(){
        //     //Declaración de variables
        //     if ($("#check_responsable").is(':checked')) {logueado_responsable = " AND asociados.id_Responsable = "+"<?php echo $this->session->userdata('id_usuario'); ?>"}else{logueado_responsable = ''}; //Si es responsable, mandaremos el id del usuario logueado
        //     if ($("#check_asignado").is(':checked')) {asignado = " AND asociados.id_Asignado = "+"<?php echo $this->session->userdata('id_usuario'); ?>"}else{asignado = ''}; //Si es asignado, mandaremos el id del usuario logueado
        //     if ($("#select_campana").val() == "") {campana = ""}else{campana = " AND campana_cliente.strNombre LIKE '%" + $("#select_campana option:selected").text() + "%'"}; //Si selecciona una campaña, mandaremos texto
        //     //if($("#select_oportunidad").val() == ""){oportunidad = "";}else{oportunidad = " AND campana_cliente.strNombre = '" + $("#select_campana option:selected").text() + "'";}; // Para las oportunidades, también usamos texto
        //     if($.trim($("#input_producto").val()) == ""){producto = "";}else{producto = " AND productos.strNombre LIKE '%" + $("#input_producto").val() + "%'";}; // Para los productos, texto con LIKE
        //     if ($("#select_responsable").val() == "") {usuario_responsable = ""}else{usuario_responsable = " AND asociados.id_Responsable = '" + $("#select_responsable").val() + "'"}; //Si selecciona un usuario responsable
        //     if ($("#select_asignado").val() == "") {usuario_asignado = ""}else{usuario_asignado = " AND asociados.id_Asignado = '" + $("#select_asignado").val() + "'"}; //Si selecciona un usuario asignado

        //     //Se recogen los datos en un arreglo
        //     datos_filtro = {
        //         'asignado': asignado,
        //         'campana': campana,
        //         'logueado_responsable': logueado_responsable,
        //         // 'oportunidad': oportunidad,
        //         'producto': producto,
        //         'usuario_asignado': usuario_asignado,
        //         'usuario_responsable': usuario_responsable,
        //     }
        //     // imprimir(datos_filtro)
            
        //     // Imprimimos en pantalla 
        //     $("#cont_sql").html('');
        //     $("#cont_sql").append(datos_filtro.asignado);
        //     $("#cont_sql").append(datos_filtro.campana);
        //     $("#cont_sql").append(datos_filtro.logueado_responsable);
        //     $("#cont_sql").append(datos_filtro.oportunidad);
        //     $("#cont_sql").append(datos_filtro.producto);
        //     $("#cont_sql").append(datos_filtro.usuario_asignado);
        //     $("#cont_sql").append(datos_filtro.usuario_responsable);

            
        // }); // click generar filtros

        // //ir a filtros
        // $("#btn_filtros").on("click", function(){
        //     //Cargamos la vista en el div
        //     location.href="<?php echo site_url('filtros'); ?>";
        // });//ir a filtros


    }); // document.ready
</script>
