<!-- Tabla responsiva -->
<div class="table-responsive">
    <!-- Tabla -->
	<table id="tabla_filtros" class="table">
		<!-- Cabecera -->
		<thead>
            <tr>
                <th class="alinear_centro" width="5%">Opc.</th>
                <th class="alinear_centro" width="5%"></th>
				<th class="alinear_centro" width="5%">Nro.</th>
                <th class="alinear_centro">Nombre</th>
                <th class="alinear_centro">Estado</th>
    		</tr>
        </thead><!-- Cabecera -->
		<!-- Cuerpo -->
        <tbody>
            <?php
            //Contador
            $cont = 1;
            // Recorrido de los filtros
            foreach ($filtros as $filtro) {
            ?>
            <tr>
                <!-- Si es superadministrador -->
                <?php //if($this->session->userdata('tipo') == '3'){ ?>
                    <td onclick="javascript:actualizar_filtro('<?php echo $filtro->intCodigo; ?>', '<?php echo $filtro->strNombre; ?>')"><span class="glyphicon glyphicon-edit"></span></td>

                <td onclick="javascript:actualizar_estado(<?php echo $filtro->intCodigo; ?>, <?php echo $filtro->Estado; ?>)"><span class="glyphicon glyphicon-refresh"></span></td>
                <td class="alinear_derecha"><?php echo $cont; ?></td>
                <td><?php echo $filtro->strNombre; ?></td>
                <td id= "estadofiltro<?php echo $filtro->intCodigo; ?>"><?php if($filtro->Estado == '1'){ echo "Activo"; }else { echo "Inactivo"; }  ?></td>
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
// Cuando den clic sobre editar     
    function actualizar_estado(elemento, estado){     
        //Cargamos la tabla
        //alert(elemento);
        //alert(estado);
            
        if( estado == '1'){
            estado='0';
        }else{
            estado='1';
        }

        //Se realiza la consulta por ajax
        filtros = ajax("<?php echo site_url('filtros/actualizar_estado'); ?>", {'codigo_filtro': elemento, 'estado': estado }, "JSON");
        
        //Se muestra el mensaje de exito
        mostrar_mensaje('Actualización', 'Se actualizó correctamente el estado del filtro');
        
        $("#cont_filtros").load("listas/cargar_interfaz", {tipo: 'tabla_filtros'});

        //Se muestra la barra de carga
        cargando($("#cont_filtros"));

        //Se limpia el formulario
        limpiar("#form_filtro");

    }

    function actualizar_filtro(elemento, titulo){
        //Se pone el título del filtro
        $("#titulo_filtro").html('').text(titulo);
        
        //Cargamos la tabla
        $("#cont_filtros").load("listas/cargar_interfaz", {tipo: 'tabla_filtros'});

        //Se muestra la barra de carga
        cargando($("#cont_filtros"));

        //Se limpia el formulario
        limpiar("#form_filtro");

        ocultar_elemento($("#si_filtro_sistema"));
        ocultar_elemento($("#si_suma"));

        //alert("cargar datos filtro "+ elemento);     
        //Se realiza la consulta por ajax
        filtros = ajax("<?php echo site_url('filtros/cargar_filtros'); ?>", {"tipo": 'filtros', 'codigo_filtro': elemento}, "JSON");
        //imprimir(filtros); 

        $("#input_intCodigo").val(elemento);
        $("#select_busqueda_rapida").val(filtros.busqueda_rapida);
        $("#select_como_reporte").val(filtros.es_reporte);
        $("#select_filtro_cliente").val(filtros.es_cliente);
        $("#select_filtro_sistema").val(filtros.es_sistema);
        $("#input_nombre_filtro").val(filtros.strNombre);
        $("#check_por_defecto").val('');
        //alert(filtros.privado);
        if(filtros.privado != '1'){
            //$("#check_privado").attr('checked', false);
            document.getElementById("check_privado").checked=false;
        }else{
            document.getElementById("check_privado").checked='true';
            //$("#check_privado").attr('checked', true);
        }        
        //alert(filtros.es_sistema);
        if(filtros.es_sistema == "1"){  
            mostrar_elemento($("#si_filtro_sistema")); 
            //alert(filtros.id_Filtro_balance); 
            if(filtros.id_Filtro_balance == 0){
                $("#condicion_filtro_sistema").val('');
            }else{
                $("#condicion_filtro_sistema").val(filtros.id_Filtro_balance);
            }                                     
            

            if (filtros.id_Filtro_balance == "2") {
                //alert("2");
                //alert("se deben mostrar checkbox en los campos");
                $("#condicion_balance").attr('class','col-lg-8');
                mostrar_elemento($("#si_suma"));
                $("#select_campo_balance").val(filtros.id_campo_balance);                                  
            }else{                                   
                $("#condicion_balance").attr('class','col-lg-12');
                ocultar_elemento($("#si_suma"));
            }// if                    
        }
        CargarCondiciones(elemento);
        CargarCampos(elemento);
    }    


    function CargarCondiciones(elemento){        
        $("#cont_condicionales").html('').append("<div id='condicional" + total_condidionales + "'></div>");
        //alert(elemento);
        condiciones = ajax("<?php echo site_url('filtros/cargar_filtros'); ?>", {"tipo": 'condiciones', 'codigo_filtro': elemento}, "JSON");                
        //imprimir(condiciones); 
        //Contador de condicionales
        total_condidionales = 1;
        condicionest = '';
        //alert(condiciones.length);
        //Agregar condicional
        if(condiciones.length > 0){
            $.each(condiciones, function(key, val){
                
                //En el contenedor de condicionales, agregamos un contenedor por cada condición nueva
                $("#cont_condicionales").append("<div id='condicional" + total_condidionales + "'></div>");
                posi = total_condidionales-1;
                condicionest = condiciones[posi];                
                //imprimir(campost);
                //Cargamos la vista en el div
                $("#condicional" + total_condidionales).load("<?php echo site_url('filtros/agregar/condicional'); ?>", {numero: total_condidionales, datos:condicionest });

                //Se muestra la barra de carga
                cargando($("#condicional" + total_condidionales));                

                //Se aumenta el total de condicionales
                total_condidionales++;

            })//Fin each   
        }

    }

    function CargarCampos(elemento){        
        $("#campos").html('').append("<div id='condicional" + total_condidionales + "'></div>");
        //alert(elemento);
        campos='';
        campos = ajax("<?php echo site_url('filtros/cargar_filtros'); ?>", {"tipo": 'campos', 'codigo_filtro': elemento}, "JSON");                
        //imprimir(campos); 
        //Contador de condicionales
        total_campos = 1;
        campost ='';
        //alert(campos.length);
        //Agregar condicional
        if(campos.length > 0){
            $.each(campos, function(key, val){
                
                //En el contenedor de campos, agregamos un contenedor por cada condición nueva
                $("#campos").append("<div id='campo" + total_campos + "'></div>");
                posi = total_campos-1;
                campost = campos[posi];                
                //imprimir(campost);                
                //Cargamos la vista en el div
                $("#campo" + total_campos).load("<?php echo site_url('filtros/agregar/campo'); ?>", {numero: total_campos, datos: campost });               

                //Se aumenta el total de condicionales
                total_campos++;

            })//Fin each   
        }

    }

	$(document).ready(function(){
        // Inicialización de la tabla
        $('#tabla_filtros').dataTable( {
            "bProcessing": true,
        }); // Tabla

    });//document.rady
</script>