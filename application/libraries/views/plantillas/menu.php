<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="http://balancoop.com">
        <img id="logo" src="<?php echo base_url().'img/logo_full.png' ?>" class="img-responsive" alt="Balancoop">
        <!-- Balancoop -->
    </a>
</div>
<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <!-- Inicio -->
        <li><a href="<?php echo site_url(''); ?>">Inicio</a></li><!-- Inicio -->
        
        <!-- Si no ha iniciado sesión -->
        <?php if($this->session->userdata('id_usuario')){ ?>
            <!-- Ingresar -->
            <li><a href="<?php echo site_url('listas'); ?>">Listas</a></li><!-- Ingresar -->
            <!-- <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ingresar <b class="caret"></b></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php //echo site_url('ingresar/proveedor'); ?>">Proveedores</a></li>
                    <li><a href="#">Another action</a></li>
                    <li><a href="#">Something else here</a></li>
                    <li class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                </ul>
            </li> -->
            <!-- Ingresar -->
            
            <!-- Cliente -->
            <li><a href="<?php echo site_url('cliente'); ?>">Cliente</a></li><!-- Cliente -->

            <!-- Filtros -->
            <li><a href="<?php echo site_url('filtros'); ?>">Filtros</a></li><!-- Filtros -->
            
            <!-- CRM -->
            <li><a href="<?php echo site_url('crm'); ?>">CRM</a></li><!-- CRM -->

            <!-- Balance social -->
            <li><a href="<?php echo site_url('balance'); ?>">Balance social</a></li><!-- Balance social -->
            
            <!-- Transferencia solidaria -->
            <li><a href="<?php echo site_url('transferencia/index/'.$this->session->userdata('id_empresa').'/0/'.$this->session->userdata('identificacion').'/get/'); ?>">Transferencia Solidaria</a></li><!-- Transferencia solidaria -->

            <!-- Nombre de usuario -->
            <li class="derecha"><a href="<?php echo site_url('inicio/cerrar_sesion'); ?>"><?php echo "Cerrar sesión"; //echo $this->session->userdata('nombre_usuario'); ?></a></li><!-- Nombre de usuario -->
        <?php } ?>
    </ul>
</div><!--/.navbar-collapse -->