<?php
$id_empresa = $this->uri->segment(3);
$id_oficina = $this->uri->segment(4);
$identificacion = $this->uri->segment(5);
$anios = $this->transferencia_model->listar_anios();
$oficinas = $this->listas_model->cargar_empresa('din_agencias', $this->session->userdata('id_empresa'));
?>
<!-- Contenedor principal -->
<div class="col-lg-12">
	<!-- Contenedor del banner -->
    <div class="col-lg-8">
        <!-- Banner -->
        <img src="<?php echo base_url().'img/cabezote_transferencia.png' ?>" class="img-responsive" alt="Transferencia solidaria"><!-- Banner -->
    	
    </div><!-- Contenedor del banner -->

    <!-- Contenedor con los datos filtrados (año, oficina y usuario) -->
    <div class="col-lg-4">
    	<br>
    	<!-- Año -->
		<div class="col-lg-6">
			<select id="select_anio" class="form-control input-sm" autofocus>
                <option value="">Año</option>
                <?php foreach ($anios as $anio) { ?>
	                <option value="<?php echo $anio->ano; ?>"><?php echo $anio->ano; ?></option>
                <?php } ?>
            </select>
		</div><!-- Año -->
		
		<!-- Oficina -->
		<div class="col-lg-6">
			<select id="select_oficina" class="form-control input-sm">
                <option value="0">Todas las oficinas</option>
                <?php foreach ($oficinas as $oficina) { ?>
	                <option value="<?php echo $oficina->intCodigo; ?>"><?php echo $oficina->strNombre; ?></option>
                <?php } ?>
            </select>
		</div><br><br><!-- Oficina -->
	
		<!-- Identificación -->
		<div class="col-lg-6">
            <input id="input_identificacion" class="form-control input-sm" type="text" placeholder="Identificación">
		</div><!-- Identificación -->
		
		<!-- Generar transferencia -->
		<div class="col-lg-6">
                <button id="btn_generar_transferencia" type="button" class="btn btn-info btn-block btn-xs">Generar transferencia</button>
		</div><!-- Generar transferencia -->
    </div><!-- Contenedor con los datos filtrados (año, oficina y usuario) -->
</div><!-- Contenedor principal -->
<div class="clear"></div>
<br>

<!-- Contenedor de transferencia solidaria -->
<center><div id="cont_transferencia"></div></center><!-- Contenedor de transferencia solidaria -->

<script type="text/javascript">
    $(document).ready(function(){ 
        var anio = $("#select_anio");
        var id_oficina = $("#select_oficina");
        var identificacion = $("#input_identificacion");

        /*//Almacenamos los datos por defecto
        datos_defecto = {
            anio: "<?php echo date('Y') - 1; ?>",
            // id_oficina: id_oficina.val(),
            // identificacion: identificacion.val()
        } // datos
        imprimir(datos_defecto)*/

        //Cargamos la interfaz por defecto
        // $("#cont_transferencia").load("listas/cargar_interfaz", {tipo: 'transferencia', datos_asociado: encontrado, datos_transferencia: datos_transferencia});

        // Generar transferencia
        $("#btn_generar_transferencia").on("click", function(){
        	// Se seleccionan los datos obligatorios
        	datos_obligatorios = new Array(
        		anio.val(),
        		id_oficina.val(),
        		identificacion.val()
    		);

        	//Se ejecuta la validación del nombre
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón del nombre
            // if (false) {
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Aun no se puede generar la transferencia', 'Por favor elija un año, una oficina y un número de identificación.');

                // Se detiene el formulario
                return false;
            } else {
            	//Almacenamos los datos en un arreglo
            	datos = {
            		anio: anio.val(),
					id_oficina: id_oficina.val(),
					identificacion: identificacion.val()
            	} // datos

            	// Ahora via ajax buscaremos el asociado
                encontrado = ajax("<?php echo site_url('cliente/buscar'); ?>", {'documento': identificacion.val()}, 'JSON');

                //Si se encuentra el asociado
                if (encontrado) {
                    //Por ajax consultamos las compras del año seleccionado
                    anio_seleccionado = ajax("<?php echo site_url('transferencia/calcular_compras'); ?>", {'tipo': 'anio_seleccionado', datos: datos}, 'JSON');

                    //Por ajax consultamos las compras del año actual
                    anio_actual = ajax("<?php echo site_url('transferencia/calcular_compras'); ?>", {'tipo': 'anio_actual', datos: datos}, 'JSON');

                    //Por ajax consultamos las compras de los últimos tres meses
                    ultimos_meses = ajax("<?php echo site_url('transferencia/calcular_compras'); ?>", {'tipo': 'ultimos_meses', datos: datos}, 'JSON');

                    datos_transferencia = {
                        compras_anio_seleccionado: anio_seleccionado.Total_Compras,
                        compras_anio_actual: anio_actual.Total_Compras,
                        compras_ultimos_meses: ultimos_meses.Total_Compras
                    };
                    

                    //Cargamos la interfaz
                    $("#cont_transferencia").load("listas/cargar_interfaz", {tipo: 'transferencia', datos: datos, datos_asociado: encontrado, datos_transferencia: datos_transferencia});
                } else {
                    // Se muestra mensaje donde se especifica que no se encuentra
                    mostrar_mensaje('Asociado no encontrado', 'El asociado que está especificando no existe o no ha sido registrado en esta empresa.');
                    
                    // Se detiene el formulario
                    return false;
                }; // if

		        //Se muestra la barra de carga
		        cargando($("#cont_transferencia"));
            }
        });// click
	});
</script>

<?php if ($id_empresa) { ?>
    <script type="text/javascript">
        $(document).ready(function(){
            var oficina = $("#select_oficina");
            var identificacion = $("#input_identificacion");

            //Almacenamos los datos en un arreglo
            datos = {
                id_oficina: oficina.val(),
                identificacion: identificacion.val()
            } //datos

            // Ahora via ajax buscaremos el asociado
            encontrado = ajax("<?php echo site_url('cliente/buscar'); ?>", {'documento': identificacion.val()}, 'JSON');

            //
            anio_actual = ajax("<?php echo site_url('transferencia/calcular_compras'); ?>", {'tipo': 'anio_actual', datos: datos}, 'JSON');
            
            ultimos_meses = ajax("<?php echo site_url('transferencia/calcular_compras'); ?>", {'tipo': 'ultimos_meses', datos: datos}, 'JSON');


            datos_transferencia = {
                compras_anio_actual: anio_actual.Total_Compras,
                compras_ultimos_meses: ultimos_meses.Total_Compras
            };

            //Cargamos la interfaz
            $("#cont_transferencia").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'transferencia', datos: datos, datos_asociado: encontrado, datos_transferencia: datos_transferencia});
        });
    </script>
<?php } ?>