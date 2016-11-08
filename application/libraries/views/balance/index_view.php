<!-- Se listan los años -->
<?php $anios = $this->balance_model->listar_anios(); ?>

<!-- Contenedor del balance -->
<div id="cont_balance">
    <!-- Contenedor selects -->
    <div class="well container">
        <!--  -->
        <div class="col-lg-2"></div>
        
        <!-- Año -->
        <div class="col-lg-4">
            <select id="select_anio" class="form-control input-sm">
                <?php foreach ($anios as $anio) { ?>
                    <option value="<?php echo $anio->ano; ?>"><?php echo $anio->ano; ?></option>
                <?php } ?>
            </select>
        </div><!-- Año -->

       <!-- Oficina -->
        <div class="col-lg-4">
            <select id="select_oficina" class="form-control input-sm" autofocus>
                <!-- <option value="0">Todas las oficinas</option> -->
                <option value="">Seleccione la oficina...</option>
            </select>  
        </div><!-- Oficina -->
    </div><!-- Contenedor selects -->

    <!-- Este es el cuadro de alertas que se verá con cada acción realizada por la aplicación -->
    <div id="modal_peso" class="modal fade">
        <input id="input_id_variable" type="hidden">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Modificar peso de la variable</h4>
                </div>
                <div class="modal-body">
                    <label for="input_peso">Definir nuevo peso</label>
                    <input id="input_peso" class="form-control input-sm" type="text" maxlength="3">
                </div>
                <div class="modal-footer">
                    <button id="btn_actualizar_peso" type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Este modal crea las diferentes tipos de estructuras -->
    <div id="modal_crear" class="modal fade">
        <!-- Tipo de estructura a crear -->
        <input id="input_tipo_crear" type="hidden">
        <input id="input_id_balance" type="hidden">
        <input id="input_id_conector" type="hidden">
        
        <!-- modal-content -->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 id="titulo_mensaje" class="modal-title">Crear</h4>
                </div>
                <div class="modal-body">
                    <div class="col-lg-9">
                        <label for="nombre_estructura">Nombre</label>
                        <input id="nombre_estructura" class="form-control input-sm" type="text" placeholder="Obligatorio" autofocus>
                    </div>

                    <div class="col-lg-3">
                        <label for="peso_estructura">Peso</label>
                        <input id="peso_estructura" class="form-control input-sm" type="text" placeholder="Obligatorio">
                    </div>

                    <div class="clear"></div>
                    <div class="col-lg-12">
                        <label for="descripcion_estructura">Descripción</label>
                        <textarea id="descripcion_estructura" class="form-control" rows="3"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button id="btn_crear_esctructura" type="button" class="btn btn-success" data-dismiss="modal">Guardar</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- Botón de creación de balance -->
    <button id="btn_crear_balance" type="button" class="btn btn-info btn-block btn-xs">Crear nuevo balance</button>
    <p></p>

    <!-- Contenedor de categorias -->
    <div id="cont_categorias"></div><!-- Contenedor de categorias -->
</div><!-- Contenedor del balance -->

<script type="text/javascript">
	/**
     * Función que carga las dimensiones
     * @param  {[type]} id_categoria [description]
     * @return {[type]}              [description]
     */
	function cargar_dimensiones(id_categoria, id_balance){
		//Declaración del contenedor
        var contenedor = $('#cont_dimension' + id_categoria);
        var anio = $('#select_anio');
        var id_oficina = $('#select_oficina');

		//Se despliega la vista de esa categoría
		contenedor.slideToggle();

        //Cargamos la interfaz
        contenedor.load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_dimensiones', id_categoria: id_categoria, anio: anio.val(), id_oficina: $("#select_oficina").val(), id_balance: id_balance});

        //Se muestra la barra de carga
        cargando(contenedor);

        return false;
	} //cargar_dimensiones

    /**
     * Función que carga las variables
     * @param  {[type]} id_dimension [description]
     * @return {[type]}              [description]
     */
    function cargar_variables(id_dimension, id_balance){
        //Declaración del contenedor
        var contenedor = $('#cont_variable' + id_dimension);
        var anio = $('#select_anio');

        //Se despliega la vista de esa categoría
        contenedor.slideToggle();

        //Cargamos la interfaz
        contenedor.load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_variables', id_dimension: id_dimension, anio: anio.val(), id_oficina: $("#select_oficina").val(), id_balance: id_balance});

        //Se muestra la barra de carga
        cargando(contenedor);
    } //cargar_variables

    /**
     * Función que carga las configuraciones de una variable
     * @param  {[type]} id_dimension [description]
     * @return {[type]}              [description]
     */
    function cargar_configuracion(id_variable){
        //Declaración del contenedor
        var contenedor = $('#cont_configuracion' + id_variable);
        var anio = $('#select_anio');

        //Se despliega la vista de esa categoría
        contenedor.slideToggle();

        //Cargamos la interfaz
        contenedor.load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_configuracion', id_variable: id_variable, anio: anio.val()});

        //Se muestra la barra de carga
        cargando(contenedor);
    } //cargar_configuracion

    function crear(tipo, id_balance, id_conector){
        //le mandamos el tipo de estructura al modal
        $("#input_tipo_crear").val(tipo);
        $("#input_id_balance").val(id_balance);
        $("#input_id_conector").val(id_conector);
        
        // Se abre la ventana
        $('#modal_crear').modal('show');
    }

    /**
     * Peso
     * @param  {[type]} id [description]
     * @return {[type]}    [description]
     */
    function cambiar_peso(id, valor){          
        var peso = $('#input_peso').numericInput();        

        //Se establece el peso que trae
        peso.val(valor);

        //El id se guarda oculto
        $('#input_id_variable').val('');
        $('#input_id_variable').val(id);
        
        
        $('#modal_peso').modal('show');

        //Comando para que la ventana aparezca sobre otras
     // $("#modal_mensaje").css("z-index", "1500");
    }

    $(document).ready(function(){
    	//Declaración de variables
        var anio = $("#select_anio");
    	var oficina = $("#select_oficina");

    	//De entrada ponemos el año por defecto
    	anio.val("<?php echo date('Y') -1; ?>");

        /*
         * Por ajax se consultan las oficinas
         */
        oficinas = ajax("<?php echo site_url('inicio/cargar_oficinas'); ?>", {'id_empresa': "<?php echo $this->session->userdata('id_empresa'); ?>"}, "JSON");
        
        // Si trae oficinas
        if (oficinas.length > 0) {
        } else {
            //Se resetea el select y se agrega una option de no encontrado
            $($("#select_oficina")).html('').append("<option value=''>Ninguna oficina encontrada...</option>");
        } //if

        //Se recorren las oficinas
        $.each(oficinas, function(key, val){
            //Se agrega cada oficina al select
            $("#select_oficina").append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
        })//Fin each

        /**
         * Cuando se seleccione un año u oficina diferentes
         */
        $("#select_anio, #select_oficina").on("change", function(){
            //Si no hay oficina
            if(oficina.val() == ""){
                //Se muestra el mensaje de advertencia
                mostrar_mensaje('No se puede cargar aún.', 'Seleccione primero una oficina.');

                // no hará la consulta, porque es necesaria la oficina
                return false;
            }
            
        	//Cargamos las categorías del año seleccionado
			$("#cont_categorias").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: "balance_categorias", anio: anio.val(), id_oficina: oficina.val()});

			//Se muestra la barra de carga
	        cargando($("#cont_categorias"));
        });

        /**
         * Crear estructura
         */
        $("#btn_crear_esctructura").on("click", function(){
            var id_balance = $("#input_id_balance");
            var id_conector = $("#input_id_conector");
            var tipo = $("#input_tipo_crear");
            var nombre = $("#nombre_estructura");
            var peso = $("#peso_estructura").numericInput();
            var descripcion = $("#descripcion_estructura");

            //Campos obligatorios
            var datos_obligatorios = new Array(
                nombre.val(),
                peso.val()
            );

            //Se ejecuta la validación
            validacion = validar_campos_vacios(datos_obligatorios);

            // Si no se supera la validación
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se puede crear', 'Por favor digite los camposobligatorios.');

                // Se detiene el formulario
                return false;
            }else{
                //Almacenamos los datos en un arreglo
                datos = {
                    'id_conector': id_conector.val(),
                    'descripcion': descripcion.val(),
                    'peso': peso.val(),
                    'strNombre': nombre.val(),
                    'id_balance': id_balance.val(),
                    'tipo': tipo.val()
                }
                // imprimir(datos)

                //Vía ajax se guarda
                guardar = ajax("<?php echo site_url('balance/crear'); ?>", {tipo: 'estructura', datos: datos}, "html");

                //Dependiendo del tipo, se recargará la interfaz
                if(tipo.val() == 'C'){
                    //Cargamos las categorías del año seleccionado
                    $("#cont_categorias").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: "balance_categorias", anio: anio.val(), id_oficina: oficina.val()});

                    //Se muestra la barra de carga
                    cargando($("#cont_categorias"));
                }else if(tipo.val() == 'D'){
                    //Cargamos la interfaz
                    $("#cont_dimension" + id_conector.val()).load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_dimensiones', id_categoria: id_conector.val(), anio: $("#select_anio").val(), id_oficina: $("#select_oficina").val(), id_balance: id_balance.val()});

                    //Se muestra la barra de carga
                    cargando($("#cont_dimension" + id_conector.val()));
                }else if(tipo.val() == 'V'){
                    //Cargamos la interfaz
                     $("#cont_variable" + id_conector.val()).load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_variables', id_dimension: id_conector.val(), anio: $("#select_anio").val(), id_oficina: $("#select_oficina").val(), id_balance: id_balance.val()});

                    //Se muestra la barra de carga
                    cargando($("#cont_variable" + id_conector.val()));
                }//if
            } // if validacion
        }); // btn crear estructura

        /**
         * Actualizar peso
         */
        $("#btn_actualizar_peso").on("click", function(){
            var id = $("#input_id_variable");
            var peso = $("#input_peso").numericInput();

            //Vía ajax se actualiza el peso
            actualizar = ajax("<?php echo site_url('balance/actualizar_peso'); ?>", {'id': id.val(), 'peso': peso.val()}, "html");

            $("#peso_categoria" + id.val()).text(peso.val());
        });

        /**
         * Crear un nuevo balance
         */
        $("#btn_crear_balance").on("click", function(){
            // Se carga la interfaz
            $("#cont_balance").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'balance_creacion'});
            
            //Se muestra la barra de carga
            cargando($("#cont_balance"));
        });// Crear balance
    });
</script>