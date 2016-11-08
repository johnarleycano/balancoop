<?php
//Se almacenan los campos como cadena de texto, resultado de la ejecución del modelo
$campos = $this->crm_model->listar_campos($id_filtro);
$condiciones = $this->crm_model->listar_condiciones($id_filtro);
$datos = $this->crm_model->listar_crm($campos, $condiciones);

//Se listan las categorías
$categorias = $this->listas_model->cargar('productos_categorias');
?>
<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="crm" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <?php foreach ($datos as $dato) { ?>
                    
                <?php } //Foreach ?>
            </tr>
        </thead><!-- Cabecera -->
        <!-- Cuerpo -->
        <tbody>
            <?php
            //Contador
            $cont = 1;
            // Recorrido de los datos
            foreach ($datos as $dato) {
            ?>
            <tr>
                <td></td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
            </tr>
            <?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
    </tabla><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#crm').dataTable( {
            "bProcessing": true,
        }); // Tabla
    });//document.rady
</script>