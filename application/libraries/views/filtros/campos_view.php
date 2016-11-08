<!-- Cargamos los datos necesarios -->
<?php 
$campos = $this->listas_model->cargar('filtro_campos'); 
//print_r($datos);
//$datosc = "";
//$datos = $datos;
?>
<!-- Contenedor Campos -->
<div id="cont_campo<?php echo $numero; ?>">
    <legend>
        <!-- Borrar registro -->
        <a href="javascript:eliminar('cont_campo<?php echo $numero ?>','guardar_campo<?php echo $numero ?>')" title="Eliminar este cargo">
            <span class="glyphicon glyphicon-remove"></span>                
        </a><!-- Borrar registro -->
    </legend>

	<!-- Campos -->
    <div class="form-group">
        <!-- Campos -->
        <div class="col-lg-7">
            <label for="select_nombre_campo<?php echo $numero; ?>" class="control-label">Campo <?php echo $numero; ?></label>
            <select id="select_campo<?php echo $numero; ?>" class="form-control input-sm" autofocus>
                <option value="">Seleccione el campo...</option>
                <?php foreach ($campos as $campo) { ?>
                    <option value="<?php echo $campo->intCodigo; ?>" ><?php echo $campo->strNombre; ?></option>
                <?php } ?>
            </select>        
        <label for=""></label>        
	</div> <!-- campos -->    	
</div><!-- contenedor campos -->
    

<!-- Si el estado es Guardar, se guardara el registro -->
<div id="cont_campo_guardar" class="oculto">
    <div class="form-group">
        <!-- Estado Guardado -->
        <div class="col-lg-12">
            <select id="guardar_campo<?php echo $numero ?>" class="form-control input-sm">
                <option value="true">Guardar</option>
                <option value="">Seleccione...</option>
                <option value="false">Inactivo</option>                    
            </select>
        </div><!-- Estado Guardado -->                
    </div>
</div><!-- cont_cargos_guardar -->

<script type="text/javascript"> 
    $('#select_campo' + "<?php echo $numero ?>" + ' > option[value="<?php echo $datos["id_filtro_campo"]; ?>"]').attr('selected', 'selected');        

</script>