<?php
session_start();

$Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/
//
//
//Cambiar los valores de estas variables segun servidor
$ServerDB = "localhost";
$UserDB = "grupovalordb";
$PassDB = "xWc97!7s";
//$UserDB = "root";
//$PassDB = "";
$NameDB = "";

// si ocurre un erorr en el campo del nombre de las db
$errorNombreDB = FALSE;

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header("Location: " . $Servidor . "login/index.php");
}


if ($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['backup'])) {
    EXPORT_TABLES("localhost","grupovalordb","$PassDB","22334_grupovalordb" );
//    $NameDB = isset($_POST['selectNombreDB']) ? $_POST['selectNombreDB'] : "";
//    $NewNameSave = (isset($_POST['txtNombreDB']) and strlen($_POST['txtNombreDB']) > 0) ? $_POST['txtNombreDB'] : NULL;
//
//    echo $ServerDB, $UserDB, $PassDB, $NameDB, $NewNameSave;
//    if (strlen($NameDB) > 0) {
//        EXPORT_TABLES($ServerDB, $UserDB, $PassDB, $NameDB, NULL, $NewNameSave);
//    } else {
//        $errorNombreDB = TRUE;
//   }
}

// https://github.com/tazotodua/useful-php-scripts 
//optional: 5th parameter - backup specific tables only: array("mytable1","mytable2",...)   
//optional: 6th parameter - backup filename
// NOTE! to adequatelly replace strings in DB, MUST READ:   goo.gl/nCwWsS

function EXPORT_TABLES($host, $user, $pass, $name, $tables = false, $backup_name = false) {

    global $errorNombreDB;


    try {

        $mysqli = new mysqli($host, $user, $pass, $name);
    } catch (Exception $ex) {
        $errorNombreDB = TRUE;
        echo "error: " . $ex;
        return;
    }
    
    if (!$errorNombreDB){
        $mysqli->select_db($name);
        $mysqli->query("SET NAMES 'utf8'");
        $queryTables = $mysqli->query('SHOW TABLES');
        while ($row = $queryTables->fetch_row()) {
            $target_tables[] = $row[0];
        } if ($tables !== false) {
            $target_tables = array_intersect($target_tables, $tables);
        }
        $content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $name . "`\r\n--\r\n\r\n\r\n";
        foreach ($target_tables as $table) {
            if (empty($table)) {
                continue;
            }
            $result = $mysqli->query('SELECT * FROM `' . $table . '`');
            $fields_amount = $result->field_count;
            $rows_num = $mysqli->affected_rows;
            $res = $mysqli->query('SHOW CREATE TABLE ' . $table);
            $TableMLine = $res->fetch_row();
            $content .= "\n\n" . $TableMLine[1] . ";\n\n";
            for ($i = 0, $st_counter = 0; $i < $fields_amount; $i++, $st_counter = 0) {

                while ($row = $result->fetch_row()) { //when started (and every after 100 command cycle):
                    if ($st_counter % 100 == 0 || $st_counter == 0) {
                        $content .= "\nINSERT INTO " . $table . " VALUES";
                    }
                    $content .= "\n(";
                    for ($j = 0; $j < $fields_amount; $j++) {
                        $row[$j] = str_replace("\n", "\\n", addslashes($row[$j]));
                        if (isset($row[$j])) {
                            $content .= '"' . $row[$j] . '"';
                        } else {
                            $content .= '""';
                        } if ($j < ($fields_amount - 1)) {
                            $content .= ',';
                        }
                    } $content .= ")";
                    //every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
                    if ((($st_counter + 1) % 100 == 0 && $st_counter != 0) || $st_counter + 1 == $rows_num) {
                        $content .= ";";
                    } else {
                        $content .= ",";
                    } $st_counter = $st_counter + 1;
                }
            } $content .= "\n\n\n";
        }

        $content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";

        $fecha = date('d-m-Y') . "_" . date('H-i-s');

        $backup_name = $backup_name ? $backup_name . "_(" . $fecha . ").sql" : $name . "_(" . $fecha . ").sql"; //_rand" . rand(1, 11111111) . ".sql";
        ob_get_clean();
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"" . $backup_name . "\"");
        echo $content;

        set_time_limit(3000);
    }
    exit;
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="<?php echo "$Servidor"; ?>favicon.png">	
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="<?php echo "$Servidor"; ?>bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo "$Servidor"; ?>dist/css/AdminLTE.css">
        <link rel="stylesheet" href="<?php echo "$Servidor"; ?>dist/css/skins/_all-skins.min.css">

        <title></title>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <header class="main-header">
                <a href="<?php echo "$Servidor"; ?>index.php" class="logo">
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
                            <img src="<?php echo $Servidor . $_SESSION['simgFotoPerfilUrl']; ?>" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $_SESSION["sUserName"]; ?></p>
                            <a href="<?php echo "$Servidor"; ?>login/logout.php"><i class="fa fa-circle text-success"></i> Cerrar Sesión</a>
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
                                <li class="active"><a href="<?php echo "$Servidor"; ?>index.php"><i class="fa fa-circle-o"></i> Panel de control.</a></li>
                            </ul>
                        </li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Supervisión<small>Panel de Control</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="<?php echo "$Servidor"; ?>index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Panel de control</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        
                        <div class="col-xs-12">

                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Respaldo de la base de datos</h3>
                                </div>
                                <!-- /.box-header -->
                                <!-- form start -->
                                <form class="form-horizontal" action="respaldar_base_datos.php" method="post">
                                    <div class="box-body">
<!--                                        <div class="form-group <?php //echo $errorNombreDB ? 'has-error' : ''; ?> ">
                                            <label for="selectNombreDB" class="col-sm-4 control-label">Seleccione DB:</label>
                                            <div class="col-sm-8">
                                                <select class="form-control" name="selectNombreDB" id="selectNombreDB" onchange="changeSelect(this)">
                                                    <option value="0" disabled="disabled" selected="">Nombre base de datos</option>
                                                    <?php
//                                                    $enlace = mysql_connect($ServerDB, $UserDB, $PassDB);
//                                                    $resultado = mysql_query("SHOW DATABASES");
//
//                                                    while ($fila = mysql_fetch_assoc($resultado)) {
//                                                        echo '<option value="' . $fila['Database'] . '">' . $fila['Database'] . '</option>';
//                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-8 col-sm-offset-4">
                                                <?php
                                                //Verifica si ocurrio algun error
                                                echo $errorNombreDB ? '<span class="help-block">Por favor seleccionar una base de datos o revise las variables de conexion.</span>' : '';
                                                ?>
                                            </div>
                                        </div>
                                        <div class="form-group" action="respaldar_base_datos.php" method="post">
                                            <label for="txtNombreDB" class="col-sm-4 control-label">Nombre a respaldar:</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" name="txtNombreDB" id="txtNombreDB" placeholder="Nombre base de datos">
                                            </div>
                                        </div>                                       -->
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer">
                                        <input type="submit" class="btn btn-info pull-right" name="backup" value="backup" />
                                    </div>
                                    <!-- /.box-footer -->
                                </form>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div> <!-- /.row (main row) -->
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>.</b>
                </div>
                <strong>&copy; 2017 <a href="<?php echo "$Servidor"; ?>index.php">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>
        <!-- ./wrapper -->

        <script src="<?php echo "$Servidor"; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script>
                                                    $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="<?php echo "$Servidor"; ?>bootstrap/js/bootstrap.min.js"></script>
        <script src="<?php echo "$Servidor"; ?>dist/js/app.min.js"></script>

        <script>
                                                    function changeSelect(select) {
                                                        var baseseleccionada = select.value;
                                                        document.getElementById("txtNombreDB").value = baseseleccionada
                                                    }
        </script>
    </body>
</html>
