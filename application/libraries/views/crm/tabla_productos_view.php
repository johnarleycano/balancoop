<!-- Nombre del asociado -->
<div class="well">
	<p>
		Productos de <b><?php echo $asociado['Nombre']." ".$asociado['PrimerApellido']." ".$asociado['SegundoApellido']; ?>
	</p>
</div><!-- Nombre del asociado -->

<!-- Tabla responsiva -->
<div class="table-responsive">
	<!-- Tabla -->
    <table id="tabla_productos" class="table">
    	<!-- Cabecera -->
        <thead>
            <tr>
            	<th class="alinear_centro" width="10%">Opc.</th>
                <th class="alinear_centro" width="5%">Nro.</th>
                <th>Producto</th>
                <th>Línea</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Valor</th>
                <th>Año</th>
                <th>Mes</th>
        	</tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
        	<?php
            //Contador
            $cont = 1;
            // Recorrido de los datos
            foreach ($productos as $producto) {
            ?>
        	<tr>
        		<td></td>
        		<td><?php echo $cont; ?></td>
        		<td><?php echo $producto['strNombre']; ?></td>
        		<td><?php echo $producto['Linea']; ?></td>
        		<td><?php echo $producto['Categoria']; ?></td>
        		<td><?php echo $producto['Cantidad']; ?></td>
                <td><?php echo $producto['Valor']; ?></td>
        		<td><?php echo $producto['Anio']; ?></td>
                <td><?php echo $producto['Mes']; ?></td>
        	</tr>
        	<!-- Aumento de contador -->
            <?php $cont++; } //Foreach ?>
    	</tbody><!-- Cuerpo -->
    </table><!-- Tabla -->
</div><!-- Tabla responsiva -->

<script type="text/javascript">
    $(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_productos').dataTable( {
            "bProcessing": true,
        }); // Tabla
        
        //valor = ajax("<?php echo site_url('crm/actualizar') ?>", {"tipo": "condicional"}, 'JSON');
        //imprimir(valor);        
    });//document.rady
</script>