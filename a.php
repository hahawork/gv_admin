<?php
session_start();

if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: login/index.php');
    exit;
}

require_once ('customMainDrawer.php');

include_once ("conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();
?>
<!doctype html>
<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">        
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">
        <link rel="icon" type="image/png" href="favicon.png">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="dist/css/AdminLTE.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">

        <title>Guarda asistencias</title>
    </head>
    <!-- hijacking: on/off - animation: none/scaleDown/rotate/gallery/catch/opacity/fixed/parallax -->
    <body class="hold-transition skin-blue sidebar-mini">

        <div class="wrapper">
            <?php
// funcion se encuentra en MainDrawer.php
            MainDrawer();
            ?>
            <div class="content-wrapper">
                <section class="content-header">
                    <h1>Supervisión<small>Panel de Control</small></h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-sitemap"></i> Home</a></li>
                        <li class="active">Panel de control</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Tabla de datos</h3>

                                </div><!-- /.box-header -->
                                <div class="box-body">

                                    <div class="form-group col-sm-6">
                                        <span class="label-warning input-group-addon">Usuario:</span>
                                        <select id="selListMarcas" class="form-control" onchange="selListMarcas_change()">
                                            <option value="0" selected="selected" disabled="disabled">0- Seleccione un usuario</option>
                                            <?php
                                            $sql = "SELECT `idUsuario`, `NombreUsuario`, Rol FROM `usuario` WHERE EstadoActivo = 1 AND MarcaAsistenciaGPS = 1 ORDER BY `NombreUsuario`";
                                            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                            while ($row2 = mysqli_fetch_array($result)) {
                                                echo "<option value='" . ($row2['idUsuario']) . "'>" . $row2['NombreUsuario'] . " - " . ($row2['Rol']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>


                                    <div class="form-group col-sm-6">
                                        <span class="label-warning input-group-addon">Punto:</span>
                                        <input type="text" class="form-control" id="txtPuntoVenta" list="listPuntosVenta" placeholder="Escriba o Seleccione">			                
                                        <datalist id="listPuntosVenta">
                                            <?php
                                            $sql = "SELECT `IdPdV`, `NombrePdV`, `Ciudad` FROM `puntosdeventa` WHERE EsPdV = 1  ORDER BY `NombrePdV`";
                                            $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
                                            while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                <option value="<?= $row['IdPdV'] ?>"><?= $row['NombrePdV'] . " - " . ($row['Ciudad']) ?></option>";
                                                <?php
                                            }
                                            ?>
                                        </datalist>

                                    </div>

                                    <!--Gastos de bus y taxi-->
                                    <div class="form-group col-sm-6">
                                        <label for="txtbus" class="label-warning input-group-addon">Gastos Bus:</label>
                                        <input type="number" value="0" id="txtbus" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="txttaxi" class="label-warning input-group-addon">Gastos Taxi:</label>                                        
                                        <input type="number" value="0" id="txttaxi" class="form-control">
                                    </div>

                                    <!--hospedaje y alimentos-->
                                    <div class="form-group col-sm-6">
                                        <label for="txtalimento" class="label-warning input-group-addon">Gastos Alimento:</label>                                        
                                        <input type="number" value="0" id="txtalimento" class="form-control">                                   
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="txthospedaje" class="label-warning input-group-addon">Gastos Hospedaje:</label>                                        
                                        <input type="number" value="0" id="txthospedaje" class="form-control">
                                    </div>

                                    <!--otros gastos y kilometraje actual-->
                                    <div class="form-group col-sm-6">
                                        <label for="txtotros" class="label-warning input-group-addon">Gastos Varios:</label>                                        
                                        <input type="number" value="0" id="txtotros" class="form-control">
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="txtkilometraje" class="label-warning input-group-addon">KM Actual:</label>                                        
                                        <input type="number" id="txtkilometraje" class="form-control">
                                    </div>

                                    <!--fecha y comentario-->
                                    <div class="form-group col-sm-6">
                                        <label for="txtfecha" class="label-warning input-group-addon">Fecha:</label>                                        
                                        <input type="datetime" id="txtfecha" class="form-control" value="<?= date("Y-m-d H:i:s") ?>">
                                    </div>
                                    <!--fecha de salida-->
                                    <div class="form-group col-sm-6">
                                        <label for="txtfechaSalida" class="label-warning input-group-addon">Fecha:</label>                                        
                                        <input type="datetime" id="txtfechaSalida" class="form-control" value="<?= date("Y-m-d H:i:s") ?>">
                                    </div>
                                    <div class="form-group ">
                                        <label for="txtcomentario" class="label-warning input-group-addon">Comentarios:</label>                                        
                                        <input type="text" id="txtcomentario" class="form-control">
                                    </div>

                                </div>
                                <!--fin del box body                                -->
                                <div class="box-footer">
                                    <button class="btn btn-success" onclick="guardarasistencia();">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div> 
        </div>

        <style type="text/css">
            .popup {
                position: fixed;
                text-align: center;
                display: none;
                top: 50%;
                left: 50%;
                -webkit-transform: translate(-50%, -50%);
                transform: translate(-50%, -50%);
                border: 1px solid black;
            }
        </style>
        <div class="popup" id="popup">
            <span class="label-info" style="width: 100%;">Espere... guardando</span>
            <br />
            <img src="dist/images/Preloader_664.gif" />
        </div>

        <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
        <script>
                                        $.widget.bridge('uibutton', $.ui.button);
        </script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="dist/js/app.min.js"></script>

        <script>

                                        function guardarasistencia() {
                                            var idUsuario = $("#selListMarcas").val();
                                            var idPdV = $("#txtPuntoVenta").val();
                                            var cantBus = $("#txtbus").val();
                                            var cantTaxi = $("#txttaxi").val();
                                            var cantAlimento = $("#txtalimento").val();
                                            var cantHospedaje = $("#txthospedaje").val();
                                            var cantVarios = $("#txtotros").val();
                                            var cantKMActual = $("#txtkilometraje").val();
                                            var FechaEntrada = $("#txtfecha").val();
                                            var FechaSalida = $("#txtfechaSalida").val();
                                            var Comentario = $("#txtcomentario").val();

                                            if (idPdV > 0) {
                                                $.ajax({
                                                    dataType: 'json',
                                                    type: 'POST',
                                                    url: "aphp.php",
                                                    cache: false,
                                                    data: {
                                                        idUsuario: idUsuario,
                                                        IdPdV: idPdV,
                                                        CantGastosMovim: cantBus,
                                                        CantGastosMovimTaxi: cantTaxi,
                                                        CantGastosAlim: cantAlimento,
                                                        CantGastosHosped: cantHospedaje,
                                                        CantGastosVario: cantVarios,
                                                        FechaRegistro: FechaEntrada,
                                                        FechaSalida: FechaSalida,
                                                        Observacion: Comentario,
                                                        kmactual: cantKMActual
                                                    },
                                                    beforeSend: function (xhr) {
                                                        $("#popup").show();
                                                    },
                                                    success: function (data) {

                                                        console.log(data);
                                                        if (data.Guardado == 1) {
                                                            $("#txtPuntoVenta").val("");
                                                            $("#txtbus").val("0");
                                                            $("#txttaxi").val("0");
                                                            $("#txtalimento").val("0");
                                                            $("#txthospedaje").val("0");
                                                            $("#txtotros").val("0");
                                                            $("#txtkilometraje").val("0");
                                                            $("#txtfecha").val();
                                                            $("#txtfechaSalida").val();
                                                            $("#txtcomentario").val("");

                                                            $("#popup").hide();
                                                        } else {
                                                            $("#popup").hide();
                                                            alert("No se ha podido guardar.! " + data);
                                                        }
                                                    }
                                                    ,
                                                    error: function (jqXHR, textStatus, errorThrown) {
                                                        $("#popup").hide();
                                                        alert(textStatus + ", error: " + errorThrown);
                                                    }
                                                }
                                                );
                                            } else {
                                                alert("Favor seleccione punto de venta");
                                            }
                                        }
        </script>
    </body>
</html>