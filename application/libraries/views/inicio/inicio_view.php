<?php
//Si ya existe empresa (o sea, sesión iniciada)
if ($this->session->userdata('id_empresa')) {
    //Se declara el id de la empresa
    $id_empresa = $this->session->userdata('id_empresa');
}
?>

<!-- Contenedor principal -->
<div id="cont_inicio" class="col-lg-12">
    <!-- Contenedor del banner e información de eventos -->
    <div id="cont_inicio" class="col-lg-8">
        <!-- Banner -->
        <img src="<?php echo base_url().'img/cabezote_inicio.png' ?>" class="img-responsive" alt="Balancoop"><!-- Banner -->

        <!-- Información de la empresa usuaria -->
        <div class="col-lg-6">
            <!-- Nombre de la empresa -->
            <h2><?php if (isset($id_empresa)) { echo "Empresa ".$id_empresa; } ?></h2>
            
            <!-- Logo -->
            <figure>
                <center>
                    <!-- Si existe empresa -->
                    <?php if (isset($id_empresa)) { $imagen = base_url()."img/logos/".$this->session->userdata('id_empresa').".png"; ?>
                        <!-- Carga imagen -->
                        <img id="logo_empresa" src="<?php echo $imagen; ?>" alt="" align="center">    
                    <?php } ?>
                </center>
            </figure><!-- Logo -->

            <h2>CRM</h2>
            <p>Nuestro sistema, le permite administrar toda la relación comercial, con sus clientes, asociados, prospectos. Oportunidades, Citas, Llamadas, Reuniones, Campañas, Agenda, Productos, Etc.</p>
            <p><a class="btn btn-default" href="http://balancoop.com/como-funciona.html" target="_blank">Más detalles &raquo;</a></p>
        </div><!-- Información de la empresa usuaria -->

        <div class="col-lg-6">
            <h2>BALANCE SOCIAL</h2>
            <p>Conforme va registrando sus actuaciones con los asociados, el sistema de CRM, le va alimentando automáticamente el balance social cooperativo por indicadores.</p>
            <p><a class="btn btn-default" href="http://balancoop.com/compa-ia.html" target="_blank">Más detalles &raquo;</a></p>
        </div>
    </div><!-- Contenedor del banner e información de eventos -->

    <!-- Contenedor de Inicio de sesión -->
    <div class="col-lg-4">
        <!-- Si no ha iniciado sesión -->
        <?php if(!$this->session->userdata('id_usuario')){ ?>
            <!-- Sesión para los asociados -->
            <div class="well row">
                <form id="sesion_asociado">
                    <h3>Asociados <small>Genere su transferencia solidaria.</small></h3>
                    
                    <!-- Empresa -->
                    <div class="col-sm-6">
                        <select id="select_empresa" class="col-sm-6 form-control input-sm">
                            <option value="">Empresa</option>
                            <?php foreach ($empresas as $empresa) { ?>
                                <option value="<?php echo $empresa->intCodigo; ?>"><?php echo $empresa->strNombre; ?></option>
                            <?php } ?>
                        </select>
                    </div><!-- Empresa -->

                    <!-- Oficina -->
                    <div class="col-sm-6">
                        <select id="select_oficina" class="col-sm-6 form-control input-sm">
                            <option value="">Oficina</option>
                        </select>
                    </div><br><br> <!-- Oficina -->
                    
                    <!-- Usuario -->
                    <div class="col-sm-9">
                        <input id="input_documento" type="text" placeholder="Digite su número de cédula" class="form-control input-md" >
                    </div><!-- Usuario -->

                    <!-- Clave -->
                    <div class="col-sm-3">
                        <button type="submit" class="btn btn-primary btn-block btn-md">Entrar</button>
                    </div><!-- Clave -->
                </form>
            </div><!-- Sesión para los asociados -->

            <!-- Sesión para los usuarios -->
            <div class="well row">
                <form id="sesion_usuario">
                    <h3>Usuarios del sistema <small>Ingrese si posee datos de registro en nuestro sistema.</small></h3>

                    <div class="col-sm-12">
                        <input id="input_nit" type="text" placeholder="Digite el NIT de la empresa" class="form-control input-md" autofocus ><br>

                        <input id="input_usuario" type="text" placeholder="Digite su nombre de usuario" class="form-control input-md" ><br>
                        <input id="input_password" type="password" placeholder="Digite su contraseña" class="form-control input-md" ><br>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block btn-md">Iniciar sesión</button>
                </form>
            </div><!-- Sesión para los usuarios -->
        </div><!-- Contenedor de Inicio de sesión -->
    <?php } else { ?>
        <div class="jumbotron">
            <h1>Sesión iniciada</h1>
            <p>...</p>
            <p><a href="<?php echo site_url('inicio/cerrar_sesion'); ?>" class="btn btn-primary btn-lg" role="button">Cerrar sesión</a></p>
        </div>
    <?php } ?>
</div><!-- Contenedor principal -->
<div class="clear"></div>

<script type="text/javascript">
    // Cuando el documento esté listo
    $(document).ready(function(){
        //Recolección de datos de sesión
        var documento = $("#input_documento").numericInput();
        var empresa = $("#select_empresa");
        var nit = $("#input_nit");
        var oficina = $("#select_oficina");
        var usuario = $("#input_usuario");
        var password = $("#input_password");

        /**
         * Cuando se seleccione una empresa
         */
        empresa.on("change", function(){
            //Si se selecciona alguna empresa
            if ($(this).val() != "") {
                //Por ajax se consultan las oficinas
                oficinas = ajax("<?php echo site_url('inicio/cargar_oficinas'); ?>", {'id_empresa': $(this).val()}, "JSON");
                
                // Si trae oficinas
                if (oficinas.length > 0) {
                    //Se resetea el select y se agrega una option vacia
                    $(oficina).html('').append("<option value='0'>Todas las oficinas</option>");
                } else {
                    //Se resetea el select y se agrega una option de no encontrado
                    $(oficina).html('').append("<option value=''>Ninguna oficina encontrada...</option>");
                } //if

                //Se recorren las oficinas
                $.each(oficinas, function(key, val){
                    //Se agrega cada oficina al select
                    $(oficina).append("<option value='" + val.intCodigo + "'>" + val.strNombre + "</option>");
                })//Fin each
            };
        });

        //submit asociado
        $("#sesion_asociado").on("submit", function(){
            //Datos a validar
            datos_obligatorios = new Array(
                documento.val(),
                oficina.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Documento no digitado', 'Por favor digite su número de documento de identificación y seleccione la empresa y la oficina.');
            } else {
                //Validaremos la información mediante ajax
                encontrado = ajax("<?php echo site_url('transferencia/buscar_asociado'); ?>", {"documento": documento.val(), id_empresa: empresa.val()}, 'JSON');

                //Si no
                if(encontrado) {
                    //Se redirecciona
                    redireccionar("<?php echo site_url('transferencia/index'); ?>" + "/" + empresa.val()+ "/" + oficina.val() + "/" + documento.val() + "/get/");
                } else {
                    //Se muestra el mensaje de error
                    mostrar_mensaje('No se ha podido entrar', 'El número que ingresó no ha sido encontrado en nuestra base de datos. Por favor verifíquelo e intente nuevamente');
                } //if
            }// if

            //Se detiene el formulario
            return false;
        });//submit asociado

        //submit usuario
        $("#sesion_usuario").on("submit", function(){
            imprimir("Validando usuario del sistema...");

            //Datos a validar
            datos_obligatorios = new Array(
                nit.val(),
                usuario.val(),
                password.val()
            );

            //Se ejecuta la validación de los campos obligatorios
            validacion = validar_campos_vacios(datos_obligatorios);

            //Si no supera la validacíón
            if (!validacion) {
                //Se muestra el mensaje de error
                mostrar_mensaje('Faltan datos', 'Por favor digite el NIT o documento, nombre de usuario y la contraseña.');
            } else {
                //Primero, verificaremos el id de la empresa, según el nit
                empresa = ajax("<?php echo site_url('inicio/obtener_id_empresa'); ?>", {'documento': nit.val()}, 'JSON');

                sesion_usuario = ajax("<?php echo site_url('inicio/validar_sesion'); ?>", {'nit': nit.val(), 'usuario': usuario.val(), 'password': password.val(), 'id_empresa': empresa.intCodigo}, 'html');

                //Si la sesion no es exitosa
                if(!sesion_usuario) {
                    mostrar_mensaje('No se ha podido iniciar sesión', 'El usuario y la contraseña no coinciden en la base de datos. Verifique que los haya digitado bien, al igual que el número del NIT.');
                } else {
                    //Se redirecciona
                    redireccionar("<?php echo site_url(''); ?>");
                } //if

            } // if

            //Se detiene el formulario
            return false;
        });//submit usuario
    });//document.ready
</script>