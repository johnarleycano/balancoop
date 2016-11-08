<?php
// Carga de datos necesarios
$productos = $this->listas_model->cargar_productos();
$generos = $this->listas_model->cargar('generos');
?>

<!-- Contenedor Condiciones -->
<div id="cont_condicion">
    <!-- Condición -->
    <div class="form-group">
        <!-- Condiciones -->
        <div class="col-lg-4">
            <label for="select_filtro_condicion" class="control-label">Condición</label>
            <select id="select_filtro_condicion" class="form-control input-sm" autofocus>
                <option value="">Seleccione</option>
                <option value="1">Contiene</option>
                <option value="0">No contiene</option>
            </select>
        </div><!-- Condiciones -->

        <!-- Productos -->
        <div class="col-lg-4">
            <label for="select_filtro_producto" class="control-label">Producto</label>
            <select id="select_filtro_producto" class="form-control input-sm" autofocus>
                <option value="">Seleccione...</option>
                <?php foreach ($productos as $producto) { ?>
                    <option value="<?php echo $producto->intCodigo; ?>"><?php echo $producto->strNombre; ?></option>
                <?php } ?>
            </select>
        </div><!-- Productos -->

        <!-- Género -->
        <div class="col-lg-4">
            <label for="select_filtro_genero" class="control-label">Género</label>
            <select id="select_filtro_genero" class="form-control input-sm" autofocus>
                <option value="">Seleccione...</option>
                <?php foreach ($generos as $genero) { ?>
                    <option value="<?php echo $genero->intCodigo; ?>"><?php echo $genero->strNombre; ?></option>
                <?php } ?>
            </select>
        </div><!-- Género -->
        
        <label for=""></label>
    </div><!-- Condición -->
</div><!-- Contenedor Condiciones -->

<script type="text/javascript">
    //Recolección de datos
    var condicion = $("#select_filtro_condicion");
    var genero = $("#select_filtro_genero");
    var contiene = "<?php echo $datos['contiene']; ?>";
    // imprimir(contiene);

    $('#select_filtro_condicion > option[value="<?php echo $datos["contiene"]; ?>"]').attr('selected', 'selected');
    $('#select_filtro_producto > option[value="<?php echo $datos["id_producto"]; ?>"]').attr('selected', 'selected');
    $('#select_filtro_genero > option[value="<?php echo $datos["id_genero"]; ?>"]').attr('selected', 'selected');
</script>