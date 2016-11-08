<!-- Se consultan los clientes -->
<?php $asociados = $this->cliente_model->listar_usuarios_actualizados($actualizado, $id_oficina); ?>

<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
    <table id="productos" class="table">
        <!-- Cabecera -->
        <thead>
            <tr>
            	<th>Nro</th>
            	<th>Nombre</th>
            	<th>Cédula</th>
            	<th>Oficina</th>
            	<th>Estado</th>
            	<th>¿Actualizado?</th>
            </tr>
        </thead><!-- Cabecera -->

        <!-- Cuerpo -->
        <tbody>
        	<?php
        	//Contador
            $cont = 1;
            // Recorrido de los productos
            foreach ($asociados	 as $asociado) {
            ?>
        	<tr>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
        		<td><?php echo $asociado->Nombres; ?></td>
        		<td><?php echo $asociado->Identificacion; ?></td>
        		<td><?php echo $asociado->Oficina; ?></td>
        		<td><?php echo $asociado->Estado; ?></td>
        		<td><?php if($asociado->Actualizado == "1"){echo "Si";}else{echo "No";} ?></td>
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
	// Cuando el DOM esté listo
	$(document).ready(function(){
		// Inicialización de la tabla
        $('#productos').dataTable( {
            "bProcessing": true,
        }); // Tabla
	});//document.ready
</script>