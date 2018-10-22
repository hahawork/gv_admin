<?php

function MainDrawer() {

    $Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/";
    $idUsuario = $_SESSION["sIdUsuario"];
    $NivelAcceso = $_SESSION["sNivelAcceso"];
    $idCliente = $_SESSION["sIdCliente"];

    require_once 'funciones_varias.php';

    $admin = 'disabled';


    if ($NivelAcceso == 1) {
        $admin = '';
    }

    echo '<header class="main-header">
                <a href="/admin/index.php" class="logo">
                    <span class="logo-mini"><b>G</b>V</span>
                    <span class="logo-lg"><b>Grupo</b>Valor sa.</span>
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="' . $Servidor . $_SESSION["simgFotoPerfilUrl"] . '" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p>' . $_SESSION["sUserName"] . '</p>
                            <a href="/admin/login/logout.php"><i class="fa fa-circle text-success"></i> Cerrar Sesión</a>
                        </div>
                    </div>

                    <ul class="sidebar-menu">

                        <li class="header">Panel de navegación</li>
                        <li class="active treeview">
                            <a href="#">
                                <i class="fa fa-dashboard"></i> <span>Sitios</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="' . $Servidor . 'index.php"><i class="fa fa-circle-o"></i> Panel de control.</a></li>                                
                                <li><a href="' . $Servidor . 'pages/mis_productos.php"><i class="fa fa-cubes"></i>Mis Productos</a></li>
                                <li><a href="' . $Servidor . 'planpromocional/planpromocional.php"><i class="fa fa-certificate"></i>Plan Promocional</a></li>
                            </ul>			            
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-file-excel-o"></i> <span>Reportes</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>			          	
                            <ul class="treeview-menu">   
                                    <li><a href="' . $Servidor . 'tables/asistenciaoficinaimprimir.php"><i class="glyphicon glyphicon-briefcase"></i> Asistencia de Oficinas</a></li>  
                                    <li><a href="' . $Servidor . 'tables/ReporteAsistenciaPersonal.php"><i class="glyphicon glyphicon-tags"></i>Asistencia de Personal Externo</a></li>
                                    <li><a href="' . $Servidor . 'tables/asistencia-imprimir.php"><i class="glyphicon glyphicon-user"></i> Asistencia de las supervisoras</a></li>
                                <!-- Esto es porque el formato de fechas de vencimiento cambia por marca-->                                
                                <li><a href="' . getURLFechasVencimiento($idCliente) . '"><i class="glyphicon glyphicon-exclamation-sign"></i>Fechas de Vencimiento</a></li>
                                <li><a href="' . getURLPrecios($idCliente) . '"><i class="fa fa-money"></i>Reporte de Precios</a></li>
                                <li><a href="' . $Servidor . 'tables/ReporteInventarioPermanente.php"><i class="glyphicon glyphicon-tags"></i>Inventario Permanente</a></li>
                                <li><a href="/admin/tables/ReporteAppLite.php"><i class="glyphicon glyphicon-tags"></i>Reporte asistencia (Lite)</a></li>
                            </ul>
                        </li>';

    echo $NivelAcceso == 1 ? '   <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-television" aria-hidden="true"></i> <span>Monitores</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>
                                <ul class="treeview-menu">
                                    <li><a href="' . $Servidor . 'pages/verpdv.php"><i class="fa fa-map"></i> Puntos de venta gráfico</a></li>
                                    <li><a href="' . $Servidor . 'pages/verpdvlist.php"><i class="fa fa-map-pin"></i> Puntos de venta listado</a></li>
                                    <li><a href="' . $Servidor . 'tables/ReporteAsistenciaDiaria.php"><i class="fa fa-pie-chart"></i>Asistencia Diaria</a></li>
                                    <li><a href="' . $Servidor . 'config/Supervisor-Display_get_ruta_diaria.php"><i class="fa  fa-check-square"></i>Ver Recorrido por día</a></li>	
                                </ul>
                            </li>
                            <li class="treeview">
                                <a href="#">
                                    <i class="fa fa-cogs" aria-hidden="true"></i> <span>Configuración</span>
                                    <span class="pull-right-container">
                                        <i class="fa fa-angle-left pull-right"></i>
                                    </span>
                                </a>			          	
                                <ul class="treeview-menu">
                                    <li><a href="' . $Servidor . 'config/frmUsuarioPantallas.php"><i class="fa  fa-check-square"></i>Usuario-Formularios</a></li>	
                                    <li><a href="' . $Servidor . 'config/Formato_registro.php"><i class="glyphicon glyphicon-user"></i>Registro-Usuarios</a></li>
                                    <li><a href="' . $Servidor . 'config/respaldar_base_datos.php"><i class="fa fa-database"></i>Respaldar Base De Datos</a></li>
                                    <li><a href="' . $Servidor . 'config/Pedir_numero_celular.php"><i class="fa fa-database"></i>Pedir Número Celular de un Usuario.</a></li>
                                    <li><a href="' . $Servidor . 'config/EnviarMensajeAUsuario.php"><i class="glyphicon glyphicon-phone"></i>Enviar mensaje al usuario</a></li>
                                    <li><a href="' . $Servidor . 'config/configurar_acceso_usuario.php"><i class="glyphicon glyphicon-ban-circle"></i>Parámetros de Seguridad</a></li>                                    
                                </ul>
                            </li>' : '';

    echo '</ul>
                </section>
                <!-- /.sidebar -->
            </aside>';
}

?>