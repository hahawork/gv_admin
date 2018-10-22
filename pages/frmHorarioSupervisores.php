<?php
session_start();

$Servidor = 'http://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/


require_once ($_SERVER["DOCUMENT_ROOT"] . '/admin/customMainDrawer.php');

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];

$admin = 'disabled';
if ($NivelAcceso == 1) {

    $admin = '';
    echo "<a href='" . $Servidor . "pages/posicion-supervisores.php'><i class='fa fa-map'></i> Ultima Ubicación Supervisiones</a>";
}

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="icon" type="image/png" href="../favicon.png">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="../dist/css/AdminLTE.css">
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

        <!-- fullCalendar 2.2.5-->
        <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.min.css">
        <link rel="stylesheet" href="../plugins/fullcalendar/fullcalendar.print.css" media="print">

        <!--        Esto es para el selector con busqueda-->
        <link href="../plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
        <!--********************************************************-->

        <title>Horario</title>

        <style type="text/css">
            .disabled {
                pointer-events:none; /*This makes it not clickable*/
                opacity:0.6;         /*This grays it out to look disabled*/
            }
        </style>

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php
            MainDrawer();
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>Cliente<small>Mis Productos</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="../index.php"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Mis Productos</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

<!--                    scroll en cuando esta en lg para canbiar la dimension de los paneles-->
                    <div class="row hidden-xs hidden-sm hidden-md">
                        <input id="skbColumnas" type="range" name="range" value="4" max="12" step="1">
                    </div>
                    <!--***************************************************************-->
                    
                    <div class="row ">
                        <div class="col-lg-4" id="boxCrear">
                            <div class="box box-solid">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Crear</h3>
                                </div>
                                <div class="box-body">
                                    <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                      <!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
                                        <ul class="fc-color-picker" id="color-chooser">
                                            <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
                                            <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
                                        </ul>
                                    </div>
                                    <!-- /btn-group -->
                                    <div class="form form-horizontal">
                                        <div class="form-group">
                                            <label for="selectUsuario" class="control-label col-sm-2">Supervisor</label>
                                            <div class="col-sm-4">
                                                <select id="selectUsuario" type="text" class="form-control select2"  style="width: 100%;">
                                                    <option value="0" disabled="" selected="">Seleccione...</option>
                                                    <?php
                                                    if ($NivelAcceso == 1) {
                                                        $sql = "select * from usuario where EstadoActivo = 1 order by NombreUsuario";
                                                    } elseif ($NivelAcceso == 3) {
                                                        $sql = "select * from usuario where IdCliente = '$idCliente' and EstadoActivo = 1 order by NombreUsuario";
                                                    }
                                                    $resultado = mysqli_query($conn, $sql);
                                                    if ($resultado) {
                                                        if (mysqli_num_rows($resultado) > 0) {
                                                            while ($rowTipo = mysqli_fetch_array($resultado)) :
                                                                ?>
                                                                <option value="<?php echo $rowTipo['idUsuario']; ?>"><?php echo ($rowTipo['NombreUsuario']); ?></option>
                                                                <?php
                                                            endwhile;
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <label for="txt-pdv" class="control-label col-sm-2">Punto de venta</label>
                                            <div class="col-sm-4">
                                                <input id="txt-pdv" class="form-control" list="pdv">
                                                <datalist id="pdv">
                                                    <option data-value="0" disabled="" selected="" value="Seleccione....">
                                                        <?php
                                                        $sql = "SELECT `IdPdV`, `NombrePdV` FROM `puntosdeventa` WHERE EsPdV = '1'";
                                                        $resultado = mysqli_query($conn, $sql);
                                                        if ($resultado) {
                                                            if (mysqli_num_rows($resultado) > 0) {
                                                                while ($rowTipo = mysqli_fetch_array($resultado)) :
                                                                    ?>
                                                                <option data-value="<?php echo $rowTipo['IdPdV']; ?>" value="<?php echo ($rowTipo['NombrePdV']); ?>">
                                                                    <?php
                                                                endwhile;
                                                            }
                                                        }
                                                        ?>
                                                </datalist>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="sel-dias-semana" class="control-label col-sm-2">Día</label>
                                            <div class="col-sm-4">
                                                <select id="sel-dias-semana" type="text" class="form-control" >
                                                    <option value="0" selected="" disabled="">Seleccione el día</option>
                                                    <option value="1">Lunes</option>
                                                    <option value="2">Martes</option>
                                                    <option value="3">Miércoles</option>
                                                    <option value="4">Jueves</option>
                                                    <option value="5">Viernes</option>
                                                    <option value="6">Sábado</option>
                                                    <option value="7">Domingo</option>
                                                </select>
                                            </div>

                                            <label for="chktodoeldia" class="control-label col-sm-2">Todo el dia</label>
                                            <div class="col-sm-4">
                                                <input type="checkbox" id="chktodoeldia" class="">
                                            </div>

                                        </div>

                                        <div class="form-group">
                                            <label for="txt-entrada" class="control-label col-sm-2">Hora de Entrada</label>
                                            <div class="col-sm-4">
                                                <input type="time" id="txt-entrada" class="form-control">
                                            </div>

                                            <label for="txt-salida" class="control-label col-sm-2">Hora de Salida</label>
                                            <div class="col-sm-4">
                                                <input type="time" id="txt-salida" class="form-control">
                                            </div>
                                        </div>

                                        <button id="add-new-event" type="button" class="pull-right btn btn-primary"><span class="fa fa-save"> Guardar</span></button>

                                    </div>
                                    <!-- /input-group -->
                                </div>
                            </div>
                        </div>

                        <!-- /.col -->
                        <div class="col-lg-8" id="boxCalendario">
                            <div class="box box-primary">
                                <div class="box-body no-padding">
                                    <!-- THE CALENDAR -->
                                    <div id="calendar"></div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /. box -->
                        </div>
                        <!-- /.col -->
                    </div> <!-- /.row (main row) -->
                </section> <!-- /.content -->
            </div> <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>.</b>
                </div>
                <strong>&copy; 2017 <a href="#">Grupo Valor sa.</a>.</strong> Todos los derechos reservados.
            </footer>
        </div>
        <!-- ./wrapper -->

        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script>
            $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../dist/js/app.min.js"></script>

        <!-- fullCalendar 2.2.5 -->
        <script src="../plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
        <!--        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>-->
        <script src="../plugins/fullcalendar/fullcalendar.js" type="text/javascript"></script>
        <!--        esto es para el selector con busqueda-->
        <script src="../plugins/select2/select2.full.min.js" type="text/javascript"></script>

        <script src="../plugins/datepicker/date.js" type="text/javascript"></script>
        <!-- Page specific script -->
        <script>
            $(function () {

                //Initialize Select2 Elements para buscar dentro de un selectbox
                $("#new-event").select2();
                /* initialize the external events
                 -----------------------------------------------------------------*/
                function ini_events(ele) {
                    ele.each(function () {

                        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
                        // it doesn't need to have a start or end
                        var eventObject = {
                            title: $.trim($(this).text()) // use the element's text as the event title
                        };
                        // store the Event Object in the DOM element so we can get to it later
                        $(this).data('eventObject', eventObject);
                        // make the event draggable using jQuery UI
                        $(this).draggable({
                            zIndex: 1070,
                            revert: true, // will cause the event to go back to its
                            revertDuration: 0  //  original position after the drag
                        });
                    });
                }

                ini_events($('#external-events div.external-event'));
                /* initialize the calendar
                 -----------------------------------------------------------------*/
                //Date for the calendar events (dummy data)
                var date = new Date();
                var d = date.getDate(),
                        m = date.getMonth(),
                        y = date.getFullYear();
                $('#calendar').fullCalendar({
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'month,agendaWeek,agendaDay'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        day: 'Diario'
                    },
                    firstDay: 1,
                    //Random default events
                    events: [
<?php
if ($NivelAcceso == 1) {
    $sqlEventos = "SELECT * FROM vw_eventos_horario_calendario";
} elseif ($NivelAcceso == 3) {
    $sqlEventos = "SELECT * FROM vw_eventos_horario_calendario WHERE IdCliente = $idCliente";
}

if ($result = mysqli_query($conn, $sqlEventos)) {
    while ($row = mysqli_fetch_assoc($result)) {

        $arrFecha = explode("-", $row["fechaReg"]);
        $arrHoraI = explode(":", $row["date_start"]);
        $arrHoraF = explode(":", $row["date_end"]);
        $allday = $row["diaSemana"] == 1 ? "true" : "false";

        echo '{';
        echo "title: '" . $row["title"] . "',";
        echo "start: new Date($arrFecha[0], $arrFecha[1], $arrFecha[2], $arrHoraI[0], $arrHoraI[1]),";
        echo "end: new Date($arrFecha[0], $arrFecha[1], $arrFecha[2], $arrHoraF[0], $arrHoraF[1]),";
        echo "allDay: $allday,";
        echo "dow: [" . $row["diaSemana"] . "],";
        echo "backgroundColor: '" . $row["backgroundcolor"] . "',";
        echo "borderColor: '" . $row["bordercolor"] . "',";
        echo "url: '" . $row["url"] . "'";
        echo '},';
    }
}
?>
//                        {
//                            title: 'All Day Event',
//                            start: new Date(y, m, 1),
//                            allDay: true,
//                            dow: [1], //monday
//                            backgroundColor: "#f56954", //red
//                            borderColor: "#f56954" //red
//                        },
//                        {
//                            title: 'Long Event',
//                            start: new Date(y, m, d, 8, 0),
//                            end: new Date(12, 0),
//                            dow: [1],
//                            backgroundColor: "#f39c12", //yellow
//                            borderColor: "#f39c12" //yellow
//                        },
//                        {
//                            title: 'Meeting',
//                            start: new Date(y, m, d, 10, 30),
//                            allDay: false,
//                            dow: [2, 3], //tuesday and wednesday
//                            backgroundColor: "#0073b7", //Blue
//                            borderColor: "#0073b7" //Blue
//                        },
//                        {
//                            title: 'Lunch',
//                            start: new Date(y, m, d, 12, 0),
//                            end: new Date(y, m, d, 14, 0),
//                            allDay: false,
//                            backgroundColor: "#00c0ef", //Info (aqua)
//                            borderColor: "#00c0ef" //Info (aqua)
//                        },
//                        {
//                            title: 'Birthday Party',
//                            start: new Date(y, m, d + 1, 19, 0),
//                            end: new Date(y, m, d + 1, 22, 30),
//                            allDay: false,
//                            backgroundColor: "#00a65a", //Success (green)
//                            borderColor: "#00a65a" //Success (green)
//                        },
//                        {
//                            title: 'Click for Google',
//                            start: new Date(y, m, 28),
//                            end: new Date(y, m, 29),
//                            url: '',
//                            backgroundColor: "#3c8dbc", //Primary (light-blue)
//                            borderColor: "#3c8dbc" //Primary (light-blue)
//                        }
                    ],
                    eventClick: function (event) {
                        if (event.title) {
                            // change the border color just for fun
                            $(this).css('border-color', 'red');
                            alert(event.title);
                            return false;
                        }
                    }
                });
                /* ADDING EVENTS */
                var currColor = "#3c8dbc"; //Red by default
                //Color chooser button
                var colorChooser = $("#color-chooser-btn");
                $("#color-chooser > li > a").click(function (e) {
                    e.preventDefault();
                    //Save color
                    currColor = $(this).css("color");
                    //Add color effect to button
                    $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
                });
                //para el punto de venta datalist
                var data = {};
                $("#pdv option").each(function (i, el) {
                    data[$(el).data("value")] = $(el).val();
                });
                $("#add-new-event").click(function (e) {
                    e.preventDefault();
                    //Get value and make sure it is not null
                    //estos son del encabezado
                    var idUsuario = $("#selectUsuario").val();
                    var Usuario = $("#selectUsuario :selected").text();
                    var diaSemana = $("#sel-dias-semana").val();
                    var backgroundcolor = currColor;
                    var bordercolor = currColor;
                    var fechaReg = y + "-" + m + "-" + d;
                    var PdV = $("#txt-pdv").val();
                    var idPdV = $('#pdv [value="' + PdV + '"]').data('value');
                    var title = Usuario + " - " + PdV;
                    var date_start = $("#txt-entrada").val();
                    var date_end = $("#txt-salida").val();
                    var TodoElDia = $('#chktodoeldia').is(":checked") ? 1 : 0;
                    var url = "";
                    var estadoActivo = "1";

                    if (Usuario.length > 0 &&
                            diaSemana > 0 &&
                            PdV.length > 0 &&
                            date_start.length > 0 &&
                            date_end.length > 0) {

                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            url: '../funciones/guardar_eventohorario.php',
                            cache: false,
                            data: {
                                idUsuario: idUsuario,
                                Usuario: Usuario,
                                diaSemana: diaSemana,
                                backgroundcolor: backgroundcolor,
                                bordercolor: bordercolor,
                                fechaReg: fechaReg,
                                idPdV: idPdV,
                                PdV: PdV,
                                title: title,
                                date_start: date_start,
                                date_end: date_end,
                                TodoElDia: TodoElDia,
                                url: url,
                                estadoActivo: estadoActivo
                            },
                            beforeSend: function (xhr) {

                            },
                            success: function (data) {
                                console.log(data);
                                if (data.success == 1) {

                                    //Remove event from text input
                                    $("#new-event").val("0");
            
                                    alert(data.message);
                                } else {
                                    alert(data.error);
                                }
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alert(textStatus + ", " + errorThrown);
                            }
                        });
                    } else {
                        alert("Por favor llene los campos necesarios.");
                    }
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $("#skbColumnas").change(function (e) {
                    var value = e.target.value;
                    $("#boxCrear").attr('class', '');
                    $("#boxCrear").addClass("col-lg-" + value);
                    $("#boxCalendario").attr('class', '');
                    $("#boxCalendario").addClass("col-lg-" + (12 - value));
                });
            });
        </script>
    </body>
</html>