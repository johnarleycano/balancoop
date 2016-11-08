<center>
    <div class="btn-group btn-group-sm">
        <!-- Botón proveedores -->
        <button id="btn_campanas" type="button" class="btn btn-default">Campañas</button>
        <button id="btn_empresas" type="button" class="btn btn-default">Empresas</button>
        <button id="btn_listas_desplegables" type="button" class="btn btn-default">Listas desplegables</button>
        <button id="btn_oficinas" type="button" class="btn btn-default">Oficinas</button>
        <button id="btn_proveedores" type="button" class="btn btn-default">Proveedores</button>
        <button id="btn_productos" type="button" class="btn btn-default">Productos</button>
        <button id="btn_regiones" type="button" class="btn btn-default">Regiones</button>
    </div>
<center> 
<p></p>

<!-- Contenedor donde se cargará la información -->
<div id="cont_listas"></div><br>

<script type="text/javascript">
    $(document).ready(function(){
        // Campañas
        $("#btn_campanas").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'campana'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Campañas

        // Proveedores
        $("#btn_proveedores").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'proveedor'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Proveedores

        // Productos
        $("#btn_productos").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'producto'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Productos

        // Empresas
        $("#btn_empresas").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'empresa_oficina', empresa: '1'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Empresas

        // Oficinas
        $("#btn_oficinas").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'empresa_oficina', empresa: '2'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Oficinas

        // Listas desplegables
        $("#btn_listas_desplegables").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'lista'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Listas desplegables

        // Regiones
        $("#btn_regiones").on("click", function(){
            //Cargamos la interfaz
            $("#cont_listas").load("listas/cargar_interfaz", {tipo: 'region'});

            //Se muestra la barra de carga
            cargando($("#cont_listas"));
        }); // Regiones
    });//document.ready
</script>