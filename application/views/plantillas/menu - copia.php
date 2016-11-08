<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="http://balancoop.com">
        <img id="logo" src="<?php echo base_url().'img/logo_full.png' ?>" class="img-responsive" alt="Balancoop">
    </a>
</div>
<div class="navbar-collapse collapse">
    <ul class="nav navbar-nav">
        <!-- Inicio -->
        <li><a href="<?php echo site_url(''); ?>">Inicio</a></li><!-- Inicio -->

        <!-- Si ya ha iniciado sesión -->
        <?php if($this->session->userdata('id_usuario') > 0){ ?>
            <!-- Cliente -->
            <li><a href="<?php echo site_url('cliente'); ?>">Hoja de vida</a></li><!-- Cliente -->
            
            <!-- CRM -->
            <li><a href="<?php echo site_url('crm'); ?>">Segmentación</a></li><!-- CRM -->

            <!-- Balance social -->
            <li><a href="<?php echo site_url('balance'); ?>">Balance social</a></li><!-- Balance social -->

            <!-- Si el usuario es superadministrador -->
            <?php if($this->session->userdata('tipo') == "3"){ ?>
                <!-- Administración -->
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Administración <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="<?php echo site_url('cliente/actualizados'); ?>">Actualización</a>
                        </li>
                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo site_url('importacion'); ?>">Importar</a>
                        </li>

                        <li>
                            <a href="<?php echo site_url('filtros'); ?>">Filtros</a>
                        </li>
                        
                        <li>
                            <a href="<?php echo site_url('listas'); ?>">Listas</a>
                        </li>
                        
                        <li>
                            <a href="<?php echo site_url('transferencia/index/'.$this->session->userdata('id_empresa').'/0/'.$this->session->userdata('identificacion').'/get/'); ?>">Transferencia Solidaria</a>
                        </li>
                        <li class="divider"></li>

                        <li>
                            <a href="<?php echo site_url('reporte'); ?>">Reporte de campañas</a>
                        </li>
                        <!-- <li class="divider"></li>
                        
                        <li class="dropdown-header">
                            Nav header
                        </li>
                        
                        <li>
                            <a href="#">Separated link</a>
                        </li>
                        
                        <li>
                            <a href="#">One more separated link</a>
                        </li> -->
                    </ul>
                </li><!-- Administración -->
            <?php } // if superadministrador ?>

            <!-- Cerrar sesión -->
            <li class="derecha"><a href="<?php echo site_url('inicio/cerrar_sesion'); ?>"><?php echo "Cerrar sesión"; //echo $this->session->userdata('nombre_usuario'); ?></a></li><!-- Cerrar sesión -->
        <?php } ?>
    </ul>
</div><!--/.navbar-collapse -->