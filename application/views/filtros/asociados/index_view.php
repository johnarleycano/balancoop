<!-- Título -->
<center><h3>Filtros de asociado</h3></center>

<!-- Tipo de filtro para diferenciar a la hora de guardar -->
<input type="hidden" value="asociado" id="tipo_filtro">

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
            <button id="btn_agregar_condicional" type="button" class="btn btn-info btn-block btn-xs">Nueva condición</button>
        </div><!-- panel-body -->
    </div><!-- panel panel-primary -->
</div><!-- Columna 1 (Condicionales) -->

<!-- Columna 2 (Campos) -->
<div class="col-lg-6">
    <div class="panel panel-primary">
        <!-- Título -->
        <div class="panel-heading">
            <h3 class="panel-title"></span> Campos</h3>
        </div>
        <div class="panel-body">
            <div id="campos"></div>
            
            <!-- Botón agregar campo -->
            <button id="btn_agregar_campo" type="button" class="btn btn-info btn-block btn-xs">Agregar nuevo campo</button>
        </div><!-- panel-body -->
    </div><!-- panel panel-primary -->
</div><!-- Columna 2 (Campos) -->

<p>
    <!-- Botón de guardado del filtro -->
    <input type="submit" class="btn btn-success btn-block" value="Guardar"></input>
</p>

<p>
    <!-- Contenedor donde se cargará la información -->
    <div id="cont_tabla"></div><br>
</p>

<script type="text/javascript">
    $(document).ready(function(){
        //Cargamos la tabla
        $("#cont_tabla").load("<?php echo site_url('listas/cargar_interfaz'); ?>", {tipo: 'tabla_filtros_asociados'});

        //Se muestra la barra de carga
        cargando($("#cont_tabla"));

        /********************************************************************
        *************************** Condicionales ***************************
        ********************************************************************/
        //Contador de condicionales
        total_condidionales = 1;

        //Agregar condicional
        $("#btn_agregar_condicional").on("click", function(){
            //En el contenedor de condicionales, agregamos un contenedor por cada condición nueva
            $("#cont_condicionales").append("<div id='condicional" + total_condidionales + "'></div>");

            //Cargamos la vista en el div
            $("#condicional" + total_condidionales).load("<?php echo site_url('filtros/agregar/condicional'); ?>", {"numero": total_condidionales, "tipo": 1});

            //Se muestra la barra de carga
            cargando($("#condicional" + total_condidionales));

            //Se aumenta el total de condicionales
            total_condidionales++;
        });//Agregar condicional

        /********************************************************************
        ******************************* Campos ******************************
        ********************************************************************/
        //Contador de campos
        total_campos = 1;

        //Agregar campo
        $("#btn_agregar_campo").on("click", function(){
            // Si el total de campos no supera los 14 permitidos
            if(total_campos < 15) {
                //En el contenedor de campos, agregamos un contenedor por cada condición nueva
                $("#campos").append("<div id='campo" + total_campos + "'></div>");

                //Cargamos la vista en el div
                $("#campo" + total_campos).load("<?php echo site_url('filtros/agregar/campo'); ?>", {numero: total_campos, "tipo": 1});                

            } else {
                //Se muestra el mensaje de exito
                mostrar_mensaje('Advertencia', 'No se pueden agregar más campos a este filtro');
            }// if

            //Se aumenta el total de campos
            total_campos++;
        });//Agregar campo
    });//document.ready
</script>