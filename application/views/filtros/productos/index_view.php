<!-- Título -->
<center><h3>Filtros de productos</h3></center>

<!-- Tipo de filtro para diferenciar a la hora de guardar -->
<input type="hidden" value="producto" id="tipo_filtro">

<div class="col-lg-1"></div>

<!-- Columna 1 (Condicionales) -->
<div class="col-lg-10">
    <div class="panel panel-primary">
        <!-- Título -->
        <div class="panel-heading">
            <h3 class="panel-title"></span>Condiciones</h3>
        </div>

        <div class="panel-body">
            <!-- Contenedor para agregar los condicionales -->
            <div id="cont_condicionales"></div>
        </div><!-- panel-body -->
    </div><!-- panel panel-primary -->

    <p>
        <!-- Botón de guardado del filtro -->
        <input type="submit" class="btn btn-success btn-block" value="Guardar"></input>
    </p>
</div><!-- Columna 1 (Condicionales) -->
<div class="clear"></div>

<p>
    <!-- Contenedor donde se cargará la información -->
    <div id="cont_tabla"></div><br>
</p>

<script type="text/javascript">
    $(document).ready(function(){
        imprimir("entra")
        //Cargamos la tabla
        $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'tabla_filtros_productos'});

        //Se muestra la barra de carga
        cargando($("#cont_tabla"));

        //Cargamos la vista en el div
        $("#cont_condicionales").load("<?php echo site_url('filtros/agregar/condicional_producto'); ?>", {"numero": "1", "tipo": 0});
    });//document.ready
</script>