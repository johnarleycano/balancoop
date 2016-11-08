<?php
//Se obtienen los datos que vienen por post
$id_variable = $this->input->post('id_variable');
$anio = $this->input->post('anio');
$anio_anterior = $this->input->post('anio')-1;

//Se consultan las variables
$variables = $this->balance_model->cargar_balances($anio_anterior);

// Si es responsable
if ($this->session->userdata('tipo') == '2') {
	//Activaremos los input para el valor real
	$estado_input_r = '';

	//Desactivaremos los input para el presupuestado
	$estado_input_p = 'disabled';
}else{
	//Desactivaremos los input para el presupuesto real
	$estado_input_r = 'disabled';

	//Activaremos los input para el presupuestado
	$estado_input_p = '';
}
?>

<!-- Si no es administrador, no puede modificar los valores iniciales -->
<?php if($this->session->userdata('tipo') != '2'){ ?>
	<!-- Contenedor de datos de comparación -->
	<div class="container">
		<div class="col-lg-2">
			<label for="select_modo_ingreso<?php echo $id_variable; ?>">Modo de ingreso</label>
			<select id="select_modo_ingreso<?php echo $id_variable; ?>" class="form-control input-sm" autofocus>
				<option value="">Seleccione...</option>
				<option value="1">Manual</option>
				<option value="2">Filtros</option>
		    </select>
		</div>

		<div class="col-lg-2">
			<label for="select_fuente<?php echo $id_variable; ?>">Fuente</label>
			<select id="select_fuente<?php echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Seleccione el modo de ingreso</option>
		    </select>
		</div>

		<div class="col-lg-2">
			<label for="select_balance<?php echo $id_variable; ?>">Balance comparación</label>
			<select id="select_balance<?php echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Seleccione...</option>
		    </select>
		</div>

		<div class="col-lg-2">
			<label for="select_categoria<?php echo $id_variable; ?>">Categoría comparación</label>
			<select id="select_categoria<?php echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Elija primero un balance...</option>
		    </select>
		</div>

		<div class="col-lg-2">
			<label for="select_dimension<?php echo $id_variable; ?>">Dim. comparación</label>
			<select id="select_dimension<?php echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Elija primero una categoría...</option>
		    </select>
		</div>

		<div class="col-lg-2">
			<label for="select_variable<?php echo $id_variable; ?>">Variable comparación</label>
			<select id="select_variable<?php echo $id_variable; ?>" class="form-control input-sm">
				<option value="">Elija primero una dimensión...</option>
		    </select>
		</div>
	</div><!-- Contenedor de datos de comparación -->
<?php } ?>

<script type="text/javascript">
    // Cuando el documento esté listo
    $(document).ready(function(){
    	//Declaración de variables
    	var id_variable = "<?php echo $id_variable; ?>";
    	var balance = $("#select_balance" + id_variable);
    	var categoria = $("#select_categoria" + id_variable);
    	var dimension = $("#select_dimension" + id_variable);
    	var fuente = $("#select_fuente" + id_variable);
    	var modo_ingreso = $("#select_modo_ingreso" + id_variable);
    	var variable = $("#select_variable" + id_variable);

    	//Presupuestado
    	var enero_p = $("#input_enero" + id_variable);
    	var febrero_p = $("#input_febrero" + id_variable);
    	var marzo_p = $("#input_marzo" + id_variable);
    	var abril_p = $("#input_abril" + id_variable);
    	var mayo_p = $("#input_mayo" + id_variable);
    	var junio_p = $("#input_junio" + id_variable);
    	var julio_p = $("#input_julio" + id_variable);
    	var agosto_p = $("#input_agosto" + id_variable);
    	var septiembre_p = $("#input_septiembre" + id_variable);
    	var octubre_p = $("#input_octubre" + id_variable);
    	var noviembre_p = $("#input_noviembre" + id_variable);
    	var diciembre_p = $("#input_diciembre" + id_variable);

    	//Real
    	var enero_r = $("#input_enero_real" + id_variable);
    	var febrero_r = $("#input_febrero_real" + id_variable);
    	var marzo_r = $("#input_marzo_real" + id_variable);
    	var abril_r = $("#input_abril_real" + id_variable);
    	var mayo_r = $("#input_mayo_real" + id_variable);
    	var junio_r = $("#input_junio_real" + id_variable);
    	var julio_r = $("#input_julio_real" + id_variable);
    	var agosto_r = $("#input_agosto_real" + id_variable);
    	var septiembre_r = $("#input_septiembre_real" + id_variable);
    	var octubre_r = $("#input_octubre_real" + id_variable);
    	var noviembre_r = $("#input_noviembre_real" + id_variable);
    	var diciembre_r = $("#input_diciembre_real" + id_variable);

    	/**
		 * Si existen balances en otras oficinas, los cargaremos de entrada
		 */
		//Cargaremos las categorías
        balances = ajax("<?php echo site_url('balance/cargar_balances_comparacion'); ?>", {'anio': "<?php echo $anio; ?>"}, "JSON");

        //Si se encontraron balances
        if (balances.length != 0) {
        	//Se resetea el select
	        balance.html('').append("<option value=''>Elija un balance...</option>");
			
	        //Se recorren las categorías
			$.each(balances, function(key, val){
	            //Se agrega cada categoría al select
	            balance.append("<option value='" + val.id_balance + "'>" + val.ano + " - " + val.strNombre + "</option>");
	        });//Fin each
        }else{
        	//Option de no encontrados
	        balance.html('').append("<option value=''>No hay balances del año anterior...</option>");
        } // if

        /**
    	 * Si modo de ingreso ya está seleccionado
    	 */
    	if (modo_ingreso.val() == "1") {
    		imprimir('ok')
    		//Cargaremos los usuarios
            usuarios = ajax("<?php echo site_url('listas/cargar'); ?>", {'tabla': 'usuarios_sistema'}, "JSON");

            //Se resetea el select
            fuente.html('').append("<option value=''>Elija un usuario...</option>");

            //Se recorren los usuarios
    		$.each(usuarios, function(key, val){
	            //Se agrega cada usuario al select
	            fuente.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
	        });//Fin each
    	} else if(modo_ingreso.val() == "2"){
    		//Cargaremos los filtros
            filtros = ajax("<?php echo site_url('balance/cargar_filtros'); ?>", {dato: 'null'}, "JSON");

            //Se resetea el select
            fuente.html('').append("<option value=''>Elija un filtro...</option>");

            //Se recorren los filtros
    		$.each(filtros, function(key, val){
	            //Se agrega cada filtro al select
	            fuente.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
	        });//Fin each
    	} // if

    	/**
    	 * Dependiendo del modo de ingreso que seleccione, cargará los datos
    	 */
    	modo_ingreso.on("change", function(){
    		//Si es 1
    		if($(this).val() == "1"){
    			//Cargaremos los usuarios
                usuarios = ajax("<?php echo site_url('listas/cargar'); ?>", {'tabla': 'usuarios_sistema'}, "JSON");

                //Se resetea el select
                fuente.html('').append("<option value=''>Elija un usuario...</option>");

                //Se recorren los usuarios
        		$.each(usuarios, function(key, val){
		            //Se agrega cada usuario al select
		            fuente.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
		        });//Fin each
    		}else if($(this).val() == "2"){
    			//Cargaremos los filtros
                filtros = ajax("<?php echo site_url('balance/cargar_filtros'); ?>", {dato: 'null'}, "JSON");

                //Se resetea el select
                fuente.html('').append("<option value=''>Elija un filtro...</option>");

                //Se recorren los filtros
        		$.each(filtros, function(key, val){
		            //Se agrega cada filtro al select
		            fuente.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
		        });//Fin each
    		}// if
    	}); // modo ingreso change
	
		/**
    	 * Dependiendo del balance seleccionado, cargará las categorías
    	 */
    	balance.on("change", function(){
    		//Si se selecciona un balance
    		if($(this).val() != ""){
    			//Cargaremos las categorías
                categorias = ajax("<?php echo site_url('balance/cargar_estructuras'); ?>", {'tipo': 'C', 'id_balance': $(this).val(), 'id_variable': null}, "JSON");

                //Se resetea el select
                categoria.html('').append("<option value=''>Elija una categoría...</option>");

                //Se recorren las categorías
        		$.each(categorias, function(key, val){
		            //Se agrega cada categoría al select
		            categoria.append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
		        });//Fin each
    		}else{
    			// Se resetean los selects anteriores
    			categoria.html('').append("<option value=''>Elija primero una categoría...</option>");
    			dimension.html('').append("<option value=''>Elija primero una dimensión...</option>");
    			variable.html('').append("<option value=''>Elija primero una variable...</option>");
    		} // if
    	}); // balance change
		
		




































	}); // document.ready
</script>