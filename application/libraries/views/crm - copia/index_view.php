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
                    <option value="1">Con oportunidad</option>
                    <option value="2">Sin oportunidad</option>                    
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
            <!-- Importar a -->
            <div class="form-group col-sm-2">
                <label for="filtro_importar" class="control-label">Importar a</label>
                <select id="filtro_importar" class="form-control input-sm col-sm" autofocus>
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

            <!-- Ir a filtros -->
            <div class="form-group col-sm-2">
                <label class="control-label">Gestión de filtros</label>
                
                <!-- Botón agregar condicional -->
                <button id="btn_filtros" type="button" class="btn btn-info btn-block btn-xs">Ir</button>                
            </div><!-- Ir a filtros -->
        </div><!-- Row -->
    </div><!-- Filtrar por (4) -->
</div><!-- Opciones de filtrado -->

<!-- Modal nuevo dato a una lista -->
<div id="modal_importar_dato" class="modal fade">
    <form id="form_dato">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Seleccionar el archivo csv a importar</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div>
                        <?php
                            $campo_IdEvento = array('name' => 'IdEvento', 'id' => 'IdEvento', 'value' => set_value('IdEvento',''), 'hidden' => '', 'style' => 'display:none');

                            $imagencertificado = "";
                            $campo_certificado = array ("name" => "certificado",  "multiple"=>"multiple" , "id"=>"certificado", "onchange"=>"displayResultcertificado()",);
                            $submit = array(    'name'      => 'submit',    'id'        => 'submit',    'value'     => 'Importar',);                            

                            $url = base_url().'crm';

                            echo form_open_multipart('crm/importar_archivo');
                        ?>

                        <div id="form" class="container_12">
                            <div class="grid_11" id="registro_view">                            
                                <div class="contenedor_inicio">
                                    <table width="100%">
                                        <tr>
                                            <td style="vertical-align: middle"><?php echo form_upload($campo_certificado); ?></td>
                                            <?php
                                            echo form_input($campo_IdEvento);                   
                                            ?>                                           
                                        </tr>                                        
                                    </table>
                                </div>                                
                                <table width="100%">
                                    <tr>
                                        <td>
                                            <?php
                                            echo form_submit($submit);
                                            echo form_close();
                                            ?>
                                        </td>                                        
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div><!-- Container -->

                </div><!-- Cuerpo -->                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </form>
</div><!-- Modal nuevo dato a una lista -->


<!-- Tabla -->
<div id="crm_tabla"></div>
<br>

<script type="text/javascript" charset="utf-8">
    //funcion que asigna imagen  certificado
    function displayResultcertificado()
    {
        var yi=document.getElementById("certificado").value;
        var separador = "\\";
        var yf = yi.split(separador);
        var y = yf[yf.length-1];
        var separador = ".";
        var extension = y.split(separador);        
        if (extension[extension.length-1] != "csv" && extension[extension.length-1] != "CSV" ){
            //Mensaje de error
            alert("El archivo seleccionado es invalido");
            document.getElementById("certificado").value = "";            
            return false;
        }
    }

    //Cuando el DOM esté listo
	$(document).ready(function() {

        //ir a filtros
        $("#btn_filtros").on("click", function(){
            //Cargamos la vista en el div
            location.href="<?php echo site_url('filtros'); ?>";
            
        });//ir a filtros

        //exportar a csv 
        $("#btn_exportar").on("click", function(){
            //Cargamos la vista en el div
            alert('imprimir csv');
            
        });//imprimir csv


        //Verificamos si el usuario tiene filtro port defecto
        id_filtro_por_defecto = "<?php echo $this->session->userdata('id_filtro_por_defecto'); ?>";

        /**
         * Si trae algun filtro
         */
        if(id_filtro_por_defecto) {
            imprimir('El filtro por defecto es ' + id_filtro_por_defecto)

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
            if ($(this).val() != "") {
                imprimir("Cargando una nueva tabla... Es el filtro " + $(this).val());

                //Cargamos la interfaz
                $("#crm_tabla").load("listas/cargar_interfaz", {tipo: 'tabla', id_filtro: $(this).val()});

                //Se muestra la barra de carga
                cargando($("#crm_tabla"));
            };

            
        });//change        
        
        /**
         * Si se cambia el filtro de importar a
         */
         $("#filtro_importar").on("change", function(){
            if ($(this).val() != "") {
                //imprimir("Cargando cuadro de texto para leer archivo a importar " + $(this).val());
                alert('prueba');
                //se abre formulario para subir archivos y importar a la bd
                $('#modal_importar_dato').modal('show');    

            };

            
        });//change           

    });
</script>