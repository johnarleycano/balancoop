<!-- Título -->
<center><h3>Filtros de asociado</h3></center>

<button onClick="javascript:crear('asociados')" type="button" class="btn btn-success btn-block btn-xs">Crear filtro de asociado</button>

<!-- Tipo de filtro para diferenciar a la hora de guardar -->
<input type="hidden" value="asociado" id="tipo_filtro">

<?php if (false){ ?>
<!-- Columna 2 (Campos) -->
<div class="col-lg-6">
    <div class="panel panel-primary">
        <!-- Título -->
        <div class="panel-heading">
            <h3 class="panel-title"></span> Campos</h3>
        </div>
        <div class="panel-body">
            <div id="cont_campos"></div>

            <!-- Contador de campos seleccionados -->
            <input type="hidden" id="contador_campos" value="0">
            
            <!-- Botón agregar campo -->
            <button type="button" class="btn btn-info btn-block btn-xs" onClick="agregar('campo')">Agregar nuevo campo</button>
        </div><!-- panel-body -->
    </div><!-- panel panel-primary -->
</div><!-- Columna 2 (Campos) -->

<!-- Columna 1 (Condicionales) -->
<div class="col-lg-6">
	<div class="panel panel-primary">
        <!-- Título -->
        <div class="panel-heading">
            <h3 class="panel-title"></span>Condiciones</h3>
        </div>

        <div class="panel-body">
			<!-- Contenedor para agregar los condicionales -->
            <div id="cont_condicionales"></div>
            
            <!-- Botón agregar condicional -->
            <button type="button" class="btn btn-info btn-block btn-xs" onClick="agregar('condicional')">Nueva condición</button>
    	</div><!-- panel-body -->
    </div><!-- panel panel-primary -->
</div><!-- Columna 1 (Condicionales) -->

<p>
    <!-- Botón de guardado del filtro -->
    <input type="submit" class="btn btn-success btn-block" value="Guardar"></input>
</p>
<?php } ?>
<p>
    <!-- Contenedor donde se cargará la información -->
    <div id="cont_tabla"></div><br>
</p>

<script type="text/javascript">
    // Cuando el documento esté listo
    $(document).ready(function(){
    	//Se muestra la barra de carga
		cargando($("#cont_tabla"));

		//Cargamos la tabla
        $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'filtros_asociados_lista'});













    });//document.ready
</script>