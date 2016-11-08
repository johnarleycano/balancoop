<?php
$campos = $this->crm_model->listar_campos($id_filtro);
$nombres_campos = $this->crm_model->listar_nombres_campos($id_filtro);
$condiciones = $this->crm_model->listar_condiciones($id_filtro);
$datos = $this->crm_model->listar_crm($campos, $condiciones);
//echo $datos;
//echo "<b>Select</b> " . $campos."<br> from asociados <br>";
//echo "  ". $condiciones."<br>";
//exit();

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
                <?php foreach ($nombres_campos as $campo) { ?>
                    <th><?php echo $campo->Nombre; ?></th>
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
                <?php foreach ($nombres_campos as $campo) { ?>
                    <td>
                        <?php
                            //print_r($dato);                                                         
                            $datos_nom = explode(".", $campo->Nombre_Campo);                            
                            $nombre_dato =  $datos_nom[1];
                            //$dato->$nombre_dato;
                            echo $dato->$nombre_dato;
                        ?>
                    </td>
                <?php } //Foreach ?>
            </tr>
            <?php
            //Aumento de contador
            $cont++;
            } //Foreach
            ?>
        </tbody><!-- Cuerpo -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#crm').dataTable( {
            "bProcessing": true,
        }); // Tabla
        
        valor = ajax("<?php echo site_url('crm/actualizar') ?>", {"tipo": "condicional"}, 'JSON');
        //imprimir(valor);        
    });//document.rady
</script>