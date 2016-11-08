<!-- Contenedor principal -->
<div class="col-lg-12">
    <!-- Contenedor del banner -->
    <div class="col-lg-8">
        <!-- Banner -->
        <img src="<?php echo base_url().'img/cabezote_transferencia.png' ?>" class="img-responsive" alt="Transferencia solidaria"><!-- Banner -->
    </div><!-- Contenedor del banner -->

    <!-- Si es asociado y no usuario logueado -->
    <?php if(!isset($es_asociado)){ ?>
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
    <?php } // if ?>
</div><!-- Contenedor principal -->
<div class="clear"></div>
<br>

<!-- Contenedor de transferencia solidaria -->
<center><div id="cont_transferencia"></div></center><!-- Contenedor de transferencia solidaria -->

<script type="text/javascript">
    $(document).ready(function(){
        //Una variable que nos indique si es asociado y no usuario logueado
        var es_usuario = "<?php if(isset($es_asociado)){echo $es_asociado;} ?>";
        
        //Declaración de variales
        var oficina = $("#select_oficina");
        var empresa = $("#select_empresa");
        var identificacion = $("#input_documento");

        //Si es usuario
        if (es_usuario) {
            //Almacenamos los datos de filtro en un arreglo
            datos = {
                anio: "<?php echo date('Y') ?>",
                id_oficina: oficina.val(),
                identificacion: identificacion.val()
            };
            // imprimir(datos)
             
            //Validaremos la información mediante ajax
            encontrado = ajax("<?php echo site_url('transferencia/buscar_asociado'); ?>", {"documento": identificacion.val(), id_empresa: empresa.val()}, 'JSON');
    
            //Cargaremos la vista de transferencia directamente con los datos generados
            $("#cont_transferencia").load("<?php echo site_url('inicio/cargar_interfaz'); ?>", {tipo: 'transferencia_vista', datos_filtro: datos, datos_asociado: encontrado});
        } else {
            imprimir("Es logueado");
        };

        //Se muestra la barra de carga
        $("#cont_transferencia").append('<div><img src="<?php echo base_url()."img/cargando.gif"; ?>"/></div>');
    });
</script>