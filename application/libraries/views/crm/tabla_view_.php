<?php
$campos = $this->crm_model->listar_campos($id_filtro);
$nombres_campos = $this->crm_model->listar_nombres_campos($id_filtro);
$condiciones = $this->crm_model->listar_condiciones($id_filtro);
// $condiciones .= " LIMIT 0, 10000";
$datos = $this->crm_model->listar_crm($campos, $condiciones);
//$datos = $this->crm_model->listar_crm_productos($campos, $condiciones);


// /**
//  * Prueba de datos que llegan
//  */

// echo "<b>Campos:</b> " . $campos . "<br>";
// echo "<b>Condiciones:</b> " . $condiciones . "<br>";
// echo "Los registros obtenidos son ". number_format(count($datos), 0, '', '.');



// $total = count($datos);
// 
if(true){
?>
<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="tabla_filtros" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
                <th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <?php  // foreach ($nombres_campos as $campo) { ?>
                    <th><?php // echo $campo->Nombre; ?></th>
                <?php  // } //Foreach ?>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Línea</th>
                <th>Id</th>
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
                <?php // foreach ($nombres_campos as $campo) { ?>
                    <td>
                        <?php
                        /*
                        //print_r($dato);                                                         
                        $datos_nom = explode(".", $campo->Nombre_Campo);                            
                        $nombre_dato =  $datos_nom[1];
                        echo $dato->$nombre_dato;
                        */
                        ?>
                    </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <?php // } //Foreach ?>
            </tr>
            <!-- Aumento de contador -->
            <?php $cont++; } //Foreach ?>
        </tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_filtros').dataTable( {
            "bProcessing": true,
        }); // Tabla
        
        //valor = ajax("<?php echo site_url('crm/actualizar') ?>", {"tipo": "condicional"}, 'JSON');
        //imprimir(valor);        
    });//document.rady
</script>
<?php } ?>
