<center>
    <div class="btn-group btn-group-sm">
        <button id="btn_cedula" type="button" class="btn btn-default">Buscar por cédula</button>
        <button id="btn_producto" type="button" class="btn btn-default">Buscar por producto</button>
        <button id="btn_filtros" type="button" class="btn btn-default">Usar filtros</button>
    </div>
<center> 
<p></p>

<!-- Contenedor -->
<div id="cont_crm"></div>

<script type="text/javascript">
    $(document).ready(function(){
        // Búsqueda por cédula
        $("#btn_cedula").on("click", function(){
            //Cargamos la interfaz
            $("#cont_crm").load("listas/cargar_interfaz", {tipo: 'crm_cedula'});

            //Se muestra la barra de carga
            cargando($("#cont_crm"));
        }); // Búsqueda por cédula

        // Búsqueda por producto
        $("#btn_producto").on("click", function(){
            //Cargamos la interfaz
            $("#cont_crm").load("listas/cargar_interfaz", {tipo: 'crm_producto'});

            //Se muestra la barra de carga
            cargando($("#cont_crm"));
        }); // Búsqueda por producto

        // Búsqueda por filtros
        $("#btn_filtros").on("click", function(){
            //Cargamos la interfaz
            $("#cont_crm").load("listas/cargar_interfaz", {tipo: 'crm_filtro'});

            //Se muestra la barra de carga
            cargando($("#cont_crm"));
        }); // Búsqueda por filtros
    });//document.ready
</script>