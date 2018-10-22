<?php
function MainDrawer() {

    $Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/";
    $idUsuario = $_SESSION["sUserId"];
    $NivelAcceso = $_SESSION["sNivelAcceso"];
    $idCliente = $_SESSION["sIdCliente"];

    require_once 'funciones_varias.php';

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

                        <li class="header">Panel de navegación</li>';


    require_once("conexion/sw_conexion.php");
    //Se crea nuevo objeto de la clase conexion para la base de datos del sist web
    $sw_cnn = new sw_conexion();
    $sw_conn = $sw_cnn->sw_conectar();

    //inicia la consulta para obtener los accesos permidos
    $sql = "SELECT DISTINCT b.idMenuSecciones, b.NombreSeccion, b.ClaseParaIcono FROM `tbl_sistemaweb_usuario_seccion_item` AS a INNER JOIN tbl_sistemaweb_menu_secciones AS b ON a.idMenuSeccion = b.idMenuSecciones WHERE idUsuario = $idUsuario AND a.EstadoActivo = 1 ORDER BY b.PosicionSeccion";
    
    $resultAccesos = mysqli_query($sw_conn, $sql);

    if ($resultAccesos and mysqli_num_rows($resultAccesos) > 0) {
        while ($row = mysqli_fetch_assoc($resultAccesos)) {
            echo ' <li class="active treeview">
                            <a href="#">
                                <i class="' . $row["ClaseParaIcono"] . '"></i> <span>' .($row["NombreSeccion"]) . '</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">';


            //esto es para los items dentro de las secciones
            $sqlitems = "SELECT b.idMenuItem, b.NombreMenuItem, b.ClaseIconoItem, b.ClicRedirec FROM `tbl_sistemaweb_usuario_seccion_item` AS a INNER JOIN tbl_sistemaweb_menu_items AS b ON a.idMenuItem = b.idMenuItem WHERE a.idUsuario = $idUsuario AND a.idMenuSeccion = '" . $row["idMenuSecciones"] . "' AND a.EstadoActivo = 1 ORDER BY b.PosicionItem";
            $resultItems = mysqli_query($sw_conn, $sqlitems);
            if ($resultItems and mysqli_num_rows($resultItems) > 0) {
                while ($row1 = mysqli_fetch_assoc($resultItems)) {
                    echo '<li><a href="' . $row1["ClicRedirec"] . '"><i class="' . $row1["ClaseIconoItem"] . '"></i>' . ($row1["NombreMenuItem"]) . '</a></li>';
                }
            }
            echo '</ul> </li>';
        }
        echo '</ul>
                </section>
                <!-- /.sidebar -->
            </aside>';
    }
 else { // si ocurre error en la base de datos o no hay nada registrado
     echo '</ul>
                </section>
                <!-- /.sidebar -->
            </aside>';
    }
}

?>