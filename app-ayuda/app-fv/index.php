<?php
//se conecta a la base de datos
require_once '../../conexion/conexion.php';
$cnn = new conexion();
$conn = $cnn->conectar();

//se reciben los parametros
$id_user = isset($_REQUEST["iduser"]) ? $_REQUEST["iduser"] : 0;

//Valida si el usuario es enviado
if ($id_user > 0) {

    //se hace la consulta a ala db paa obtener los datos del usuario enviado
    $sql = "SELECT * FROM `usuario` WHERE idUsuario = '$id_user'";
    if ($result = mysqli_query($conn, $sql)) {
        //verifica si hay una fila al menos
        if (mysqli_num_rows($result) > 0) {
            //se mueve al primer registro
            $fila = mysqli_fetch_assoc($result);
        }
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes" />

        <link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link href="../../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css"/>


        <title></title>

    </head>

    <body class="fixed skin-blue">
        <div class="wrapper">
            <nav class="navbar navbar-custom-menu navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span> 
                        </button>
                        <div class="navbar-brand">
                            <i class="fa fa-arrow-left" onClick="sendDataToAndroid('0,Atrás')"></i>
                            Ayuda
                        </div>
                    </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">Inicio</a></li>
                            <li><a href="#">Videos</a></li>
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Ir a (Opciones)
                                    <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li onclick="sendDataToAndroid('1,configuracion')"><a href="#"><i class="fa fa-cog"></i> Configuración</a></li>
                                    <li onclick="sendDataToAndroid('2,actualizar')"><a href="#"><i class="fa fa-refresh"></i> Actualizar info.</a></li>
                                    <li onclick="sendDataToAndroid('3,enviar fechas')"><a href="#"><i class="fa  fa-hourglass-2"></i> Enviar Fechas</a></li>
                                    <li onclick="sendDataToAndroid('4,enviar precios')"><a href="#"><i class="fa fa-money"></i> Enviar Precios</a></li>
                                </ul>
                            </li>
                        </ul>

                    </div>
                </div>
            </nav>

            <div class="content-wrapper">

                <div class="col-lg-12">
                    <div class="box box-solid">
                        <div class="box-header with-border">
                            <h3 class="box-title">Menú de ayuda</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            
                            <div class="box-group" id="accordion">
                                
                                <!-- esto es para .... Configuración -->
                                <div class="panel box box-primary">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                                Configuración
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse1" class="panel-collapse collapse">
                                        
                                        <div class="box-body">

                                            Esta opción permite adecuar la aplicación según convenga.<br>

                                            <ul>
                                                <li><b>Mostrar nombre del:</b> 
                                                    <ol type="1">
                                                        <li>Punto de venta</li>
                                                        <li>Propietario</li>
                                                    </ol>
                                                </li>
                                                <li><b>Filtrar tipo de pdv:</b> Si está activado Sirve para filtrar la lista de productos segun.
                                                    <ol type="1">
                                                        <li>La colonia</li>
                                                        <li>La union</li>
                                                        <li>Maxi Pali</li>
                                                        <li>Pali</li>
                                                    </ol>
                                                    Nota: Si sus productos no estan categorizados o no requieren este tipo de filtro por favor dejar desactivado.
                                                </li>
                                                <li><b>Departamentos:</b> Muestra la lista de los departamentos del país de Nicaragua y filtra los puntos de venta según el depto. seleccionado.</li>
                                                <li><b>Canal:</b> Sirve de filtro para los puntos de venta y tambien para los productos. Si estos últimos no le aparecen en su lista puede alternar entre los canales disponibles.</li>
                                                <li><b>Punto de venta:</b> En el campo de texto deberá ingresar el nombre del punto de venta previamente registrado, si el punto de venta existe le aparecerá en una lista de la cual deberá seleccionar el pdv deseado. Luego presionar el botón 
                                                    <img src="img/ic-agregar-pdv.PNG" alt="" width="20" height="20"/> para agregar
                                                </li>
                                                <li>Nota: 
                                                    <ol type="1">
                                                        <li>Puede editar la lista de los puntos de venta asignados, presione un elemento y luego "ACEPTAR" para quitar.</li>
                                                        <li>Si el punto de venta no le aparece, comuníquese con su supervisor inmediato o área de informática.</li>
                                                    </ol>
                                                        
                                                </li>
                                            </ul>
                                            <div>Ir a <button onclick="sendDataToAndroid('1,configuracion')"> Configuración</button></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- fin Configuración-->
                                
                                <!-- Esta parte es para...Actualizar/Descargar la información -->
                                <div class="panel box box-danger">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                                Actualizar/Descargar la información
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse2" class="panel-collapse collapse">
                                        <div class="box-body">
                                            Botones para descargar:
                                            <ol type="1">
                                                <li><b>Marcas</b> - (Lista).</li>
                                                <li><b>Presentaciones</b> - (Lista).</li>
                                                <li><b>Puntos de venta</b> - (Lista)</li>
                                                <li><b>Productos de la competencia</b> - (Lista) Si hay disponibles.</li>
                                                <li><b>Aplicación</b> - Archivo de instalación. Ruta descarga: en la memoria->carpeta grupovalor->fechavencimiento.apk</li>
                                            </ol>

                                        </div>
                                    </div>
                                </div>
                                <!-- fin Actualizar/Descargar la información -->
                                
                                <div class="panel box box-warning">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                                Ingresar las fechas de vencimiento
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse3" class="panel-collapse collapse in">
                                        <div class="box-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="panel box box-info">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4">
                                                Ingresar los precios
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse4" class="panel-collapse collapse">
                                        <div class="box-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="panel box box-success">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5">
                                                Pendientes de envio (Fechas de Vencimiento)
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse5" class="panel-collapse collapse">
                                        <div class="box-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="panel box box-default">
                                    <div class="box-header with-border">
                                        <h4 class="box-title">
                                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse6">
                                                Pendientes de envio (Precios)
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse6" class="panel-collapse collapse">
                                        <div class="box-body">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <style type="text/css">
                /*______ esto es para el boton para ir al top ___________________*/
                #myBtn {
                    display: none; /* Hidden by default */
                    position: fixed; /* Fixed/sticky position */
                    bottom: 20px; /* Place the button at the bottom of the page */
                    right: 30px; /* Place the button 30px from the right */
                    z-index: 99; /* Make sure it does not overlap */
                    border: none; /* Remove borders */
                    outline: none; /* Remove outline */
                    background-color: red; /* Set a background color */
                    color: white; /* Text color */
                    cursor: pointer; /* Add a mouse pointer on hover */
                    padding: 15px; /* Some padding */
                    border-radius: 10px; /* Rounded corners */
                    font-size: 18px; /* Increase font size */
                }

                #myBtn:hover {
                    background-color: #555; /* Add a dark-grey background on hover */
                }
                /*__________________________________________________________________*/
            </style>
            <!--_____________________ esto es para el boton para ir al top ________________________________-->            
            <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-chevron-up white"></i></button>            
            <!--_____________________________________________________-->           

            <!--fin content-wrapper            -->          
        </div>
        <!--fin wrapper        -->
        <script src="../../plugins/jQuery/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="../../bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <script src="../../dist/js/app.min.js" type="text/javascript"></script>



        <script>
                // When the user scrolls down 20px from the top of the document, show the button
                window.onscroll = function () {
                    scrollFunction()
                };

                function scrollFunction() {
                    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                        document.getElementById("myBtn").style.display = "block";
                    } else {
                        document.getElementById("myBtn").style.display = "none";
                    }
                }

                // When the user clicks on the button, scroll to the top of the document
                function topFunction() {
                    document.body.scrollTop = 0; // For Safari
                    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                }


                //esto es para el accordion
                (function ($) {
                    "use strict";
                    $(".item").on("click", function () {
                        $(this).next().slideToggle(100);
                        $(".div-cont").not($(this).next()).slideUp("fast");
                    });
                })(jQuery);



                function sendDataToAndroid(toast) {
                    MyFunction.onButtonClick(toast);
                }
        </script>
    </body>
</html>
