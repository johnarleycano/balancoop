<?php
//Se cargan los elementos de base de datos
$categorias = $this->listas_model->cargar('productos_categorias');
$lineas = $this->listas_model->cargar('productos_lineas');
$productos = $this->listas_model->cargar_empresa('productos', $this->session->userdata('id_empresa'));
$proveedores = $this->listas_model->cargar('proveedores');
?>

<!-- Si el usuario no es responsable -->
<?php if ($this->session->userdata('tipo') != "2") { ?>
    <!-- Botón agregar producto -->
    <button id="btn_agregar_producto" type="button" class="btn btn-info btn-block">Agregar producto</button>
<?php } ?>
<br>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="productos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <th class="alinear_centro">Nombre</th>
                <th class="oculto">valor</th>
                <th class="oculto">proveedor</th>
                <th class="oculto">tipo</th>
                <th class="oculto">requiere matricula</th>
                <th class="oculto">linea</th>
                <th class="oculto">categoria</th>
            </tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <?php
            //Contador
            $cont = 1;
            // Recorrido de los productos
            foreach ($productos as $producto) {
            ?>
            <tr>
                <td>
                    <!-- Todos menos los asignados pueden modificar -->
                    <?php if ($this->session->userdata('tipo') != "2") { ?>
                        <span onclick="javascript:editar_dato(<?php echo $producto->intCodigo; ?>)" class="glyphicon glyphicon-edit"></span>
                    <?php } ?>   
                </td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
                <td id="input_nombre<?php echo $producto->intCodigo; ?>" ><?php echo $producto->strNombre; ?></td>
                <td id="input_valor<?php echo $producto->intCodigo; ?>" class="oculto"><?php echo $producto->valor; ?></td>
                <td id="select_proveedor<?php echo $producto->intCodigo; ?>" class="oculto"><?php echo $producto->id_proveedor; ?></td>
                <td id="input_tipo<?php echo $producto->intCodigo; ?>" class="oculto"><?php echo $producto->Tipo; ?></td>
                <td id="select_requiere_matricula<?php echo $producto->intCodigo; ?>" class="oculto"><?php echo $producto->requiere_matricula; ?></td>
                <td id="select_linea<?php echo $producto->intCodigo; ?>" class="oculto"><?php echo $producto->id_linea; ?></td>
                <td id="select_categoria<?php echo $producto->intCodigo; ?>" class="oculto"><?php echo $producto->id_categoria; ?></td>
            </tr>
            <?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
    </tabla><!-- Tabla -->
</div><!-- Tabla responsiva -->

<!-- Modal nuevo producto -->
<div id="modal_nuevo_producto" class="modal fade">
    <form id="form_producto">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Cabecera -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Agregar nuevo producto</h4>
                </div><!-- Cabecera -->

                <!-- Cuerpo -->
                <div class="modal-body">
                    <!-- Container -->
                    <div class="container">
                        <div class="col-lg-6">
                            <!-- Nombre del producto -->
                            <input type="hidden" id="input_id_dato" value="">
                            <label for="input_nombre" class="control-label">Nombre del producto</label>
                            <input id="input_nombre" class="form-control input-sm" type="text" autofocus ><!-- Nombre del producto -->

                            <!-- Proveedor del producto -->
                            <label for="select_proveedor" class="control-label">Proveedor</label>
                            <select id="select_proveedor" class="form-control input-sm">
                                <option value="">Seleccione...</option>
                                <?php foreach ($proveedores as $proveedor) { ?>
                                    <option value="<?php echo $proveedor->intCodigo; ?>"><?php echo $proveedor->strNombre; ?></option>
                                <?php } ?>
                            </select><!-- Proveedor del producto -->
                            
                            <!-- Categoría del producto -->
                            <label for="select_categoria" class="control-label">Categoría</label>
                            <select id="select_categoria" class="form-control input-sm">
                                <option value="">Seleccione...</option>
                                <?php foreach ($categorias as $categoria) { ?>
                                    <option value="<?php echo $categoria->intCodigo; ?>"><?php echo $categoria->strNombre; ?></option>
                                <?php } ?>
                            </select><!-- Categoría del producto -->                            
                        </div>

                        <div class="col-lg-6">
                            <!-- Valor del producto -->
                            <label for="input_valor" class="control-label">Valor</label>
                            <input id="input_valor" class="form-control input-sm" type="text" ><!-- Valor del producto -->

                            <!-- ¿Requiere matrícula? -->
                            <label for="select_requiere_matricula" class="control-label">¿Requiere matrícula?</label>
                            <select id="select_requiere_matricula" class="form-control input-sm">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select><!-- ¿Requiere matrícula? -->

                            <!-- Línea del producto -->
                            <label for="select_linea" class="control-label">Línea</label>
                            <select id="select_linea" class="form-control input-sm">
                                <option value="">Seleccione...</option>
                                <?php foreach ($lineas as $linea) { ?>
                                    <option value="<?php echo $linea->intCodigo; ?>"><?php echo $linea->strNombre; ?></option>
                                <?php } ?>
                            </select><!-- Línea del producto -->
                        </div>
                    </div><!-- Container -->
                    
                    <!-- Container -->
                    <div class="container">
                        <!-- Tipo de producto -->
                        <div class="col-lg-12">
                            <label for="input_tipo" class="control-label">Tipo</label>
                            <select id="input_tipo" class="form-control input-sm">
                                <option value="1">Social</option>
                                <option value="2">Comercial</option>
                            </select>
                        </div><!-- Tipo de producto -->
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
</div><!-- Modal nuevo producto -->

<script type="text/javascript">

    // Borrar formulario    
    function borrar_formulario(){        
        $('#input_id_dato').val('');            
        $('#input_nombre').val('');            
        $("#select_requiere_matricula").val('');
        $("#select_proveedor").val('');
        $("#select_categoria").val('');
        $("#select_linea").val('');
        $("#input_tipo").val('');
        $("#input_valor").val('');
    }

    // Cuando den clic sobre editar     
    function editar_dato(elemento){     
        borrar_formulario();
        
        //mostrar_elemento($("#" + elemento));     
        var input_nombre = document.getElementById('input_nombre'+elemento).innerHTML
        var select_requiere_matricula = document.getElementById('select_requiere_matricula'+elemento).innerHTML
        var select_proveedor = document.getElementById('select_proveedor'+elemento).innerHTML
        var select_categoria = document.getElementById('select_categoria'+elemento).innerHTML
        var select_linea = document.getElementById('select_linea'+elemento).innerHTML
        var input_tipo = document.getElementById('input_tipo'+elemento).innerHTML
        var input_valor = document.getElementById('input_valor'+elemento).innerHTML
        
        //alert("id_variable"+elemento); 
        $('#modal_nuevo_producto').modal('show');        
        $("#input_id_dato").val(elemento);        
        $("#input_nombre").val(input_nombre);        
        $("#select_requiere_matricula").val(select_requiere_matricula);
        $("#select_proveedor").val(select_proveedor);
        $("#select_categoria").val(select_categoria);
        $("#select_linea").val(select_linea);
        $("#input_tipo").val(input_tipo);
        $("#input_valor").val(input_valor);
        
    }

    $(document).ready(function(){
        // Inicialización de la tabla
        $('#productos').dataTable( {
            "bProcessing": true,
        }); // Tabla

        //Agregar producto
        $("#btn_agregar_producto").on("click", function(){
            //Se abre la ventana
            $('#modal_nuevo_producto').modal('show');
            borrar_formulario();
        });//Agregar producto

        //Recolección de datos
        var id_dato = $("#input_id_dato");
        var id_proveedor = $("#select_proveedor");
        var id_categoria = $("#select_categoria");
        var id_linea = $("#select_linea");
        var nombre = $("#input_nombre");
        var requiere_matricula = $("#select_requiere_matricula");
        var tipo = $("#input_tipo");
        var valor = $("#input_valor");

        //Guardar producto
        $("#form_producto").on("submit", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                tipo.val(),
                id_proveedor.val(),
                id_categoria.val(),
                id_linea.val(),
                nombre.val(),
                requiere_matricula.val(),
                valor.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se ha completado el registro del producto', 'Por favor complete toda la información para guardar los productos.');
            } else {
                //Arreglo JSON de datos a enviar posteriormente
                datos_formulario = {
                    'strNombre': nombre.val(),
                    'valor': valor.val(),
                    'id_proveedor': id_proveedor.val(),
                    'Tipo': tipo.val(),
                    'requiere_matricula': requiere_matricula.val(),
                    'id_categoria': id_categoria.val(),
                    'id_linea': id_linea.val()
                };
                // imprimir(datos_formulario)
                if(id_dato.val()!=''){
                    //Se invoca la petición ajax que guardará el registro
                    producto = ajax("<?php echo site_url('listas/actualizar'); ?>", {"datos": datos_formulario, "tabla": "productos", "campo": "intCodigo", "id_campo": id_dato.val() }, "html"); 
                    
                    // Si se guardó correctamente
                    if(producto){
                        //Se cierra la ventana
                        $('#modal_nuevo_producto').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_producto').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'producto'});
                        });
                    }//if
                }else{   
                    //Se invoca la petición ajax que guardará el registro
                    producto = ajax("<?php echo site_url('listas/guardar'); ?>", {"datos": datos_formulario, "tabla": "productos"}, "html");
                    
                    // Si se guardó correctamente
                    if(producto){
                        //Se cierra la ventana
                        $('#modal_nuevo_producto').modal('hide');

                        //Cuando se termine de cerrar
                        $('#modal_nuevo_producto').on('hidden.bs.modal', function (e) {
                            //Se recarga la tabla para que muestre los datos
                            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'producto'});
                        });
                    }//if
                }    
            }//if validacion

            //Se detiene el formulario
            return false;
        });//Guardar producto
    });//document.rady
</script>