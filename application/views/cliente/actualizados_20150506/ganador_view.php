<!-- Se consulta el usuario ganador -->
<?php $ganador = $this->cliente_model->usuario_ganador(); ?>

<!-- Modal ganador -->
<div id="modal_ganador" class="modal fade" style="text-align: left;">
    <form id="form_ganador">
    	<div class="modal-dialog">
    		<div class="modal-content">
	    		<!-- Cabecera -->
	            <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	                <h4 id="titulo_mensaje" class="modal-title">Ganador</h4>
	            </div><!-- Cabecera -->

	            <!-- Cuerpo -->
	            <div class="modal-body">
					<!-- Container -->
						<blockquote>
							<p>El ganador es <b><?php echo $ganador->Nombres; ?></b></p>
							<small><b>Cédula: </b><?php echo $ganador->Identificacion; ?></small>
							<small><b>Fecha de actualización: </b><?php echo date('Y-m-d', strtotime($ganador->Fecha_Actualizacion)); ?></small>
							<small><b>Oficina: </b></b><?php echo $ganador->Oficina; ?></small>
							<small><b>Celular: </b></b><?php echo $ganador->Celular_cliente; ?></small>
							<small><b>Email: </b></b><?php echo $ganador->CorreoElectronico; ?></small>
						</blockquote>
	        	</div><!-- Cuerpo -->

                <!-- Pie -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="btn_guardar" class="btn btn-success">Guardar</button>
                </div><!-- Pie -->
            </div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</form>
</div><!-- Modal ganador -->

<script type="text/javascript">
	// Cuando el DOM esté listo
	$(document).ready(function(){
		//Se abre la ventana
        $('#modal_ganador').modal('show');
    });//document.ready
</script>