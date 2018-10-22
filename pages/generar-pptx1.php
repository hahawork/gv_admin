<?php
session_start();

$Servidor = 'https://' . $_SERVER['HTTP_HOST'] . "/admin/"; //$_SERVER['PHP_SELF'] . "/admin/";// obtiene la ruta del DNS : http://grupovalor.com.ni/

require_once("../conexion/conexion.php");
//Se crea nuevo objeto de la clase conexion
$cnn = new conexion();
$conn = $cnn->conectar();

$idUsuario = $_SESSION["sIdUsuario"];
$NivelAcceso = $_SESSION["sNivelAcceso"];
$idCliente = $_SESSION["sIdCliente"];


if (!$_SESSION["sUserId"]) {
    $_SESSION["sRedireccionar"] = $_SERVER["SCRIPT_NAME"];
    header('Location: ../login/index.php');
    exit;
}

$admin = 'disabled';


if ($NivelAcceso == 1) {
    $admin = '';
    echo "<a href='" . $Servidor . "pages/posicion-supervisores.php'><i class='fa fa-map'></i> Ultima Ubicación Supervisiones</a>";
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>GV - Generar PowerPoint</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=yes" name="viewport">

        <link rel="icon" type="image/png" href="<?php echo $Servidor; ?>favicon.png">
        <link rel="stylesheet" href="<?php echo $Servidor; ?>bootstrap/css/bootstrap.min.css">        
        <link rel="stylesheet" href="<?php echo $Servidor; ?>dist/css/AdminLTE.css">
        <link rel="stylesheet" href="<?php echo $Servidor; ?>dist/css/skins/_all-skins.min.css">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <title>Grupo Valor sa.</title>        
        <style type="text/css">
            body	{
                margin: 0;
                padding: 0;
                text-align: center;
                vertical-align: middle;
                background-size: cover;
            }		
            .rounded{
                border: 0px;
                align-content: center;
                vertical-align: middle;
                background: #fff;
                width: 100px;
                height: 100px;
            }
            .margenFotos{
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .modal.and.carousel {
                position: fixed; /* Needed because the carousel overrides the position property*/
            }

        </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini" onload="PintarFotos()">

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
                        <div class="col-lg-12 col-md-12 col-xs-12">                                                    
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Supervisores</h3>
                                    <div class="box-tools pull-right">                                    
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body" >
                                    <h1>Por Favor esperar a que se generen las imagenes para el archivo de powerpoint</h1>
                                    <div class="col-xs-12">
                                        <div id="placehere">
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-xs-12">
                                        <div id="botonDescarga" style="display: none;" class="margenFotos input-group">
                                            <label class="input-group-addon label-info">Su archivo está preparado</label>                                            
                                            <ul class="nav nav-pills nav-stacked">
                                                <li><button href="#lightbox" data-toggle="modal" class="btn btn-success">SELECCIONE FORMATO</button></li>
                                                <li><button href="#lightbox" data-toggle="modal" data-slide-to="0">Formato 1</button></li>
                                                <li><button href="#lightbox" data-toggle="modal" data-slide-to="1">Formato 2</button></li>
                                                <li><button href="#lightbox" data-toggle="modal" data-slide-to="15">Formato 3</button></li>
                                            </ul>
                                        </div>

                                        <div class="modal fade and carousel slide" id="lightbox">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body">
                                                        <ol class="carousel-indicators">
                                                            <li data-target="#lightbox" data-slide-to="0" class="active"></li>
                                                            <li data-target="#lightbox" data-slide-to="1"></li>
                                                            <li data-target="#lightbox" data-slide-to="2"></li>
                                                        </ol>
                                                        <div class="carousel-inner">
                                                            
                                                            <div class="item active">                                                               
                                                                <img src="formato-presentaciones/formatogenerico.png" alt="First slide" onclick="GenerarPowerPointFileFormatoGenerico()" data-toggle="modal" data-target="#lightbox">
                                                                <div class="carousel-caption"><p>Formato generico.</p></div>
                                                            </div>
                                                            
                                                            <div class="item">
                                                                <img src="formato-presentaciones/formato1-cssa.png" alt="Second slide" onclick="GenerarPowerPointFileFormatoCSSA()" data-toggle="modal" data-target="#lightbox">
                                                                <div class="carousel-caption"><p>Formato Café Soluble.</p></div>
                                                            </div>  
                                                            
                                                        </div><!-- /.carousel-inner -->
                                                        <a class="left carousel-control" href="#lightbox" role="button" data-slide="prev">
                                                            <span class="glyphicon glyphicon-chevron-left"></span>
                                                        </a>
                                                        <a class="right carousel-control" href="#lightbox" role="button" data-slide="next">
                                                            <span class="glyphicon glyphicon-chevron-right"></span>
                                                        </a>
                                                    </div><!-- /.modal-body -->
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                    </div><!-- /.container -->
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
</div>
</div>
<script src="<?php echo "$Servidor"; ?>plugins/jQuery/jquery-2.2.3.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>        
<script src="<?php echo "$Servidor"; ?>bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo "$Servidor"; ?>dist/js/app.min.js"></script>

<script type="text/javascript" src="../plugins/PptxGenJS/libs/jquery.min.js"></script>
<script type="text/javascript" src="../plugins/PptxGenJS/libs/jszip.min.js"></script>
<script type="text/javascript" src="../plugins/PptxGenJS/dist/pptxgen.js"></script>
<script type="text/javascript" src="../plugins/PptxGenJS/dist/pptxgen.bundle.js"></script>

<script>

        var API_de_compresion = "https://process.filestackapi.com/AhTgLagciQByzXpFGRI0Az/resize=w:1000/compress=metadata:true/";
        var pathImage = "http://www.grupovalor.com.ni/ws/";
        var ElementosPresentacionPPTX = JSON.parse(localStorage.getItem('ElementosPresentacionPPTX'));
        var ElementosPresentacionPDV = JSON.parse(localStorage.getItem('ElementosPresentacionPDV'));
        var ElementosPresentacionComent = JSON.parse(localStorage.getItem('ElementosPresentacionComent'));
        
        var CantidadFotosGeneradas = 0;
        var ImgCurrentHeight;
        var ImgCurrentWidth;
        
        function getImgSize(imgSrc)
        {
            var dimensiones = [];
            var newImg = new Image();
            newImg.src = imgSrc;
            ImgCurrentHeight = newImg.height;
            ImgCurrentWidth = newImg.width;
            if (ImgCurrentHeight > ImgCurrentWidth) {
                dimensiones.push(3);
                dimensiones.push(4);
                return dimensiones;
            } else if (ImgCurrentHeight < ImgCurrentWidth) {
                dimensiones.push(4);
                dimensiones.push(3);
                return dimensiones;
            } else {
                dimensiones.push(4);
                dimensiones.push(4);
                return dimensiones;
            }


        }

        localStorage.removeItem('ElementosPresentacionPPTX');
        if (!ElementosPresentacionPPTX.length == null) {
            window.location.href = '../';
        }

        function PintarFotos() {
            for (var i = 0; i < ElementosPresentacionPPTX.length; i++) {

                $.ajax({
                    type: 'post',
                    dataType: 'json',
                    cache: 'false',
                    data: {imagen: ElementosPresentacionPPTX[i]},
                    url: "ComprimirImagenes.php",
                    beforeSend: function () {
                        console.log("enviando... " + ElementosPresentacionPPTX[i]);
                    },
                    success: function (res) {
                        console.log(res);
                        if (res.success == 1) {
                            console.log("guardado... " + res.pathImage);
                            var elem = document.createElement("img");
                            elem.setAttribute("src", res.pathImage);
                            //console.log(pathImage + ElementosPresentacionPPTX[i]);
                            //elem.setAttribute("height", "100");
                            //elem.setAttribute("width", "100");
                            elem.setAttribute("alt", "image");
                            elem.setAttribute("class", "img-thumbnail col-sm-4 col-md-3 col-lg-2 margenFotos");
                            document.getElementById("placehere").appendChild(elem);
                        } else {
                            console.log("Fallo al guardar. " + res.error);
                        }

                        CantidadFotosGeneradas++;
                        if (CantidadFotosGeneradas == ElementosPresentacionPPTX.length) {
                            document.getElementById("botonDescarga").style.display = "block";
                        }
                    },
                    error: function (res) {},
                    always: function (res) {}
                });
            }
        }


        function GenerarPowerPointFileFormatoGenerico() {

            var pptx = new PptxGenJS();
            pptx.setAuthor('GV Informatica.');
            pptx.setCompany('GrupoValor Nic.');
            pptx.setRevision('1');
            pptx.setSubject('Reporte Solicitado.');
            pptx.setTitle('Presentacion.');

            //UN CICLO DE DOS EN DOS SEGUN LA CANTIDAD DE IMAGENES SELECCIONADAS
            for (var i = 0; i < ElementosPresentacionPPTX.length; i += 2) {
                //CADA DIAPOSITIVA DE DOS IMAGENES CON SU PUNTO D VENTA Y COMENTARIO RESPECTIVO
                var slide = pptx.addNewSlide();
                slide.back = 'F1F1F1';
                slide.color = '696969';
                slide.addText(ElementosPresentacionPDV[i], {x: 0.7, y: 0.5, font_size: 12, color: '363636'});
                slide.addText(ElementosPresentacionPDV[i + 1], {x: 5.1, y: 0.5, font_size: 12, color: '363636'});
                slide.slideNumber({x: 0.5, y: '95%', fontFace: 'Courier', fontSize: 10, color: 'CF0101'});
                //SE ALMACENA EN UNA VARIABLE LA RUTA DE LA IMAGEN
                var img1 = ElementosPresentacionPPTX[i];
                var img2 = ElementosPresentacionPPTX[i + 1];
                //SE OBTIENE UNA ORIENTACION DE LA IMAGEN mXm O nXm O MxN
                var dimen1 = getImgSize(ElementosPresentacionPPTX[i]);
                var dimen2 = getImgSize(ElementosPresentacionPPTX[i + 1]);

                //sE AGREGAN DE DOS EN DOS LAS IMAGENES A CADA DIAPOSITIVA
                slide
                        .addImage({path: img1, x: 0.7, y: 1, w: dimen1[0], h: dimen1[1]})
                        .addImage({path: img2, x: 5.1, y: 1, w: dimen2[0], h: dimen2[1]});
                slide.addText(ElementosPresentacionComent[i], {x: 0.7, y: 5, font_size: 8, color: '363636'});
                slide.addText(ElementosPresentacionComent[i + 1], {x: 5.1, y: 5, font_size: 8, color: '363636'});
            }

            //SE GUARDA EL ARCGHIVO
            pptx.save('PRESENTACION_REPORTE_' + getTimestamp());


            //despues de generar el archivo se borran las imagenes temporales
            for (var i = 0; i < ElementosPresentacionPPTX.length; i++) {
                //BorrarArchivoDelServidor(ElementosPresentacionPPTX[i]);
            }
        }

        function GenerarPowerPointFileFormatoCSSA() {

            var pptx = new PptxGenJS();
            pptx.setAuthor('GV Informatica.');
            pptx.setCompany('GrupoValor Nic.');
            pptx.setRevision('1');
            pptx.setSubject('Reporte Solicitado.');
            pptx.setTitle('Presentacion.');

            /*for (var i = 0; i < ElementosPresentacionPPTX.length; i += 2) {
             var slide = pptx.addNewSlide();
             slide.back = 'F1F1F1';
             slide.color = '696969';
             slide.addText(ElementosPresentacionPDV[i], {x: 0.7, y: 0.5, font_size: 12, color: '363636'});
             slide.addText(ElementosPresentacionPDV[i + 1], {x: 5.1, y: 0.5, font_size: 12, color: '363636'});
             slide.slideNumber({x: 0.5, y: '95%', fontFace: 'Courier', fontSize: 10, color: 'CF0101'});
             var img1 = ElementosPresentacionPPTX[i];
             var img2 = ElementosPresentacionPPTX[i + 1];
             var dimen1 = getImgSize(ElementosPresentacionPPTX[i]);
             var dimen2 = getImgSize(ElementosPresentacionPPTX[i + 1]);
             slide
             .addImage({path: img1, x: 0.7, y: 1, w: dimen1[0], h: dimen1[1]})
             .addImage({path: img2, x: 5.1, y: 1, w: dimen2[0], h: dimen2[1]});
             /*slide.addImage({path: '1.jpg', x: 0.7, y: 1, w: 4, h: 4})
             .addImage({path: '2.jpg', x: 5.1, y: 1, w: 4, h: 4});*
             slide.addText(ElementosPresentacionComent[i], {x: 0.7, y: 5, font_size: 8, color: '363636'});
             slide.addText(ElementosPresentacionComent[i + 1], {x: 5.1, y: 5, font_size: 8, color: '363636'});
             
             //borra la imagen generada temporalmente
             BorrarArchivoDelServidor(ElementosPresentacionPPTX[i]);
             BorrarArchivoDelServidor(ElementosPresentacionPPTX[i + 1]);
             }*/

            /* // 1:
             var slide = pptx.addNewSlide();
             slide.addText('Demo-03: Table', {x: 0.5, y: 0.25, font_size: 18, font_face: 'Arial', color: '0088CC'});
             // TABLE 1: Single-row table
             // --------
             var rows = ['Cell 1', 'Cell 2', 'Cell 3'];
             var tabOpts = {x: 0.5, y: 1.0, w: 9.0, fill: 'F7F7F7', font_size: 14, color: '363636'};
             slide.addTable(rows, tabOpts);
             // TABLE 2: Multi-row table (each rows array element is an array of cells)
             // --------
             var rows = [
             ['A1', 'B1', 'C1'],
             ['A2', 'B2', 'C2']
             ];
             var tabOpts = {x: 0.5, y: 2.0, w: 9.0, fill: 'F7F7F7', font_size: 18, color: '6f9fc9'};
             slide.addTable(rows, tabOpts);
             // TABLE 3: Formatting at a cell level - use this to selectively override table's cell options
             // --------
             var rows = [
             [
             {text: 'Top Lft', options: {valign: 't', align: 'l', font_face: 'Arial'}},
             {text: 'Top Ctr', options: {valign: 't', align: 'c', font_face: 'Verdana'}},
             {text: 'Top Rgt', options: {valign: 't', align: 'r', font_face: 'Courier'}}
             ],
             ];
             var tabOpts = {x: 0.5, y: 4.5, w: 9.0, rowH: 0.6, fill: 'F7F7F7', font_size: 18, color: '6f9fc9', valign: 'm'};
             slide.addTable(rows, tabOpts);
             // Multiline Text / Line Breaks - use either "\r" or "\n"
             slide.addTable(['Line 1\nLine 2\nLine 3'], {x: 2, y: 3, w: 4});
             */

            pptx.setLayout('LAYOUT_WIDE');
            //LA DIAPOSITIVA DE ENTRADA O INICIAL
            pptx.defineSlideMaster({
                title: 'TITLE_SLIDE',
                objects: [
                    {'image': {x: '0%', y: '0%', w: '100%', h: '100%', path: 'formato-presentaciones/cssa/cssa_formato1_inicio1_version1.png'}}
                ]
            });
            var slide1 = pptx.addNewSlide('TITLE_SLIDE');
            slide1.addText('XXXXXXXXXXXX', {x: 1.5, y: '40%', align: 'c', font_size: 65, color: 'ffffff'});
            slide1.addText('XXXXXXXXXXXX', {x: 5, y: '60%', font_size: 24, color: 'ffffff'});

            //UN CICLO DE DOS EN DOS SEGUN LA CANTIDAD DE IMAGENES SELECCIONADAS
            for (var i = 0; i < ElementosPresentacionPPTX.length; i += 2) {
                //CADA DIAPOSITIVA DE DOS IMAGENES CON SU PUNTO D VENTA Y COMENTARIO RESPECTIVO
                var slide = pptx.addNewSlide('MASTER_SLIDE');
                slide.back = 'F1F1F1';
                slide.color = '696969';
                slide.addText(ElementosPresentacionPDV[i], {x: 0.7, y: 0.5, font_size: 12, color: '363636'});
                slide.addText(ElementosPresentacionPDV[i + 1], {x: 5.1, y: 0.5, font_size: 12, color: '363636'});
                slide.slideNumber({x: 0.5, y: '95%', fontFace: 'Courier', fontSize: 10, color: 'CF0101'});
                //SE ALMACENA EN UNA VARIABLE LA RUTA DE LA IMAGEN
                var img1 = ElementosPresentacionPPTX[i];
                var img2 = ElementosPresentacionPPTX[i + 1];
                //SE OBTIENE UNA ORIENTACION DE LA IMAGEN mXm O nXm O MxN
                var dimen1 = getImgSize(ElementosPresentacionPPTX[i]);
                var dimen2 = getImgSize(ElementosPresentacionPPTX[i + 1]);

                //SE AGREGA EL FONDO A LA DIAPOSITIVA
                pptx.defineSlideMaster({
                    title: 'MASTER_SLIDE',
                    bkgd: 'FFFFFF',
                    objects: [
                        {'image': {x: '0%', y: '0%', w: '100%', h: '100%', path: 'formato-presentaciones/cssa/cssa_formato1_cuerpo_version1.png'}},
                    ],
                });
                //sE AGREGAN DE DOS EN DOS LAS IMAGENES A CADA DIAPOSITIVA
                slide
                        .addImage({path: img1, x: 0.7, y: 1, w: dimen1[0], h: dimen1[1]})
                        .addImage({path: img2, x: 5.1, y: 1, w: dimen2[0], h: dimen2[1]});
                slide.addText(ElementosPresentacionComent[i], {x: 0.7, y: 5, font_size: 8, color: '363636'});
                slide.addText(ElementosPresentacionComent[i + 1], {x: 5.1, y: 5, font_size: 8, color: '363636'});
            }
            //SE CREA LA ULTIMA DIAPOSITIVA
            pptx.defineSlideMaster({
                title: 'THANKS_SLIDE',
                bkgd: '36ABFF',
                objects: [
                    {'image': {x: '0%', y: '0%', w: '100%', h: '100%', path: 'formato-presentaciones/cssa/cssa_formato1_final1_version1.png'}}
                ]
            });
            var slide = pptx.addNewSlide('THANKS_SLIDE');
            //SE GUARDA EL ARCGHIVO
            pptx.save('PRESENTACION_REPORTE_' + getTimestamp());


            //despues de generar el archivo se borran las imagenes temporales
            for (var i = 0; i < ElementosPresentacionPPTX.length; i++) {
                //BorrarArchivoDelServidor(ElementosPresentacionPPTX[i]);
            }
        }

        function GenerarPowerPointFileFormato1() {

            var pptx = new PptxGenJS();
            pptx.setAuthor('GV Informatica.');
            pptx.setCompany('GrupoValor Nic.');
            pptx.setRevision('1');
            pptx.setSubject('Reporte Solicitado.');
            pptx.setTitle('Presentacion.');

            /*for (var i = 0; i < ElementosPresentacionPPTX.length; i += 2) {
             var slide = pptx.addNewSlide();
             slide.back = 'F1F1F1';
             slide.color = '696969';
             slide.addText(ElementosPresentacionPDV[i], {x: 0.7, y: 0.5, font_size: 12, color: '363636'});
             slide.addText(ElementosPresentacionPDV[i + 1], {x: 5.1, y: 0.5, font_size: 12, color: '363636'});
             slide.slideNumber({x: 0.5, y: '95%', fontFace: 'Courier', fontSize: 10, color: 'CF0101'});
             var img1 = ElementosPresentacionPPTX[i];
             var img2 = ElementosPresentacionPPTX[i + 1];
             var dimen1 = getImgSize(ElementosPresentacionPPTX[i]);
             var dimen2 = getImgSize(ElementosPresentacionPPTX[i + 1]);
             slide
             .addImage({path: img1, x: 0.7, y: 1, w: dimen1[0], h: dimen1[1]})
             .addImage({path: img2, x: 5.1, y: 1, w: dimen2[0], h: dimen2[1]});
             /*slide.addImage({path: '1.jpg', x: 0.7, y: 1, w: 4, h: 4})
             .addImage({path: '2.jpg', x: 5.1, y: 1, w: 4, h: 4});*
             slide.addText(ElementosPresentacionComent[i], {x: 0.7, y: 5, font_size: 8, color: '363636'});
             slide.addText(ElementosPresentacionComent[i + 1], {x: 5.1, y: 5, font_size: 8, color: '363636'});
             
             //borra la imagen generada temporalmente
             BorrarArchivoDelServidor(ElementosPresentacionPPTX[i]);
             BorrarArchivoDelServidor(ElementosPresentacionPPTX[i + 1]);
             }*/

            /* // 1:
             var slide = pptx.addNewSlide();
             slide.addText('Demo-03: Table', {x: 0.5, y: 0.25, font_size: 18, font_face: 'Arial', color: '0088CC'});
             // TABLE 1: Single-row table
             // --------
             var rows = ['Cell 1', 'Cell 2', 'Cell 3'];
             var tabOpts = {x: 0.5, y: 1.0, w: 9.0, fill: 'F7F7F7', font_size: 14, color: '363636'};
             slide.addTable(rows, tabOpts);
             // TABLE 2: Multi-row table (each rows array element is an array of cells)
             // --------
             var rows = [
             ['A1', 'B1', 'C1'],
             ['A2', 'B2', 'C2']
             ];
             var tabOpts = {x: 0.5, y: 2.0, w: 9.0, fill: 'F7F7F7', font_size: 18, color: '6f9fc9'};
             slide.addTable(rows, tabOpts);
             // TABLE 3: Formatting at a cell level - use this to selectively override table's cell options
             // --------
             var rows = [
             [
             {text: 'Top Lft', options: {valign: 't', align: 'l', font_face: 'Arial'}},
             {text: 'Top Ctr', options: {valign: 't', align: 'c', font_face: 'Verdana'}},
             {text: 'Top Rgt', options: {valign: 't', align: 'r', font_face: 'Courier'}}
             ],
             ];
             var tabOpts = {x: 0.5, y: 4.5, w: 9.0, rowH: 0.6, fill: 'F7F7F7', font_size: 18, color: '6f9fc9', valign: 'm'};
             slide.addTable(rows, tabOpts);
             // Multiline Text / Line Breaks - use either "\r" or "\n"
             slide.addTable(['Line 1\nLine 2\nLine 3'], {x: 2, y: 3, w: 4});
             */

            pptx.setLayout('LAYOUT_WIDE');
            //LA DIAPOSITIVA DE ENTRADA O INICIAL
            pptx.defineSlideMaster({
                title: 'TITLE_SLIDE',
                objects: [
                    {'image': {x: '0%', y: '0%', w: '100%', h: '100%', path: 'formato-presentaciones/cssa/cssa_formato1_inicio1_version1.png'}}
                ]
            });
            var slide1 = pptx.addNewSlide('TITLE_SLIDE');
            slide1.addText('XXXXXXXXXXXX', {x: 1.5, y: '40%', align: 'c', font_size: 65, color: 'ffffff'});
            slide1.addText('XXXXXXXXXXXX', {x: 5, y: '60%', font_size: 24, color: 'ffffff'});

            //UN CICLO DE DOS EN DOS SEGUN LA CANTIDAD DE IMAGENES SELECCIONADAS
            for (var i = 0; i < ElementosPresentacionPPTX.length; i += 2) {
                //CADA DIAPOSITIVA DE DOS IMAGENES CON SU PUNTO D VENTA Y COMENTARIO RESPECTIVO
                var slide = pptx.addNewSlide('MASTER_SLIDE');
                slide.back = 'F1F1F1';
                slide.color = '696969';
                slide.addText(ElementosPresentacionPDV[i], {x: 0.7, y: 0.5, font_size: 12, color: '363636'});
                slide.addText(ElementosPresentacionPDV[i + 1], {x: 5.1, y: 0.5, font_size: 12, color: '363636'});
                slide.slideNumber({x: 0.5, y: '95%', fontFace: 'Courier', fontSize: 10, color: 'CF0101'});
                //SE ALMACENA EN UNA VARIABLE LA RUTA DE LA IMAGEN
                var img1 = ElementosPresentacionPPTX[i];
                var img2 = ElementosPresentacionPPTX[i + 1];
                //SE OBTIENE UNA ORIENTACION DE LA IMAGEN mXm O nXm O MxN
                var dimen1 = getImgSize(ElementosPresentacionPPTX[i]);
                var dimen2 = getImgSize(ElementosPresentacionPPTX[i + 1]);

                //SE AGREGA EL FONDO A LA DIAPOSITIVA
                pptx.defineSlideMaster({
                    title: 'MASTER_SLIDE',
                    bkgd: 'FFFFFF',
                    objects: [
                        {'image': {x: '0%', y: '0%', w: '100%', h: '100%', path: 'formato-presentaciones/cssa/cssa_formato1_cuerpo_version1.png'}},
                    ],
                });
                //sE AGREGAN DE DOS EN DOS LAS IMAGENES A CADA DIAPOSITIVA
                slide
                        .addImage({path: img1, x: 0.7, y: 1, w: dimen1[0], h: dimen1[1]})
                        .addImage({path: img2, x: 5.1, y: 1, w: dimen2[0], h: dimen2[1]});
                slide.addText(ElementosPresentacionComent[i], {x: 0.7, y: 5, font_size: 8, color: '363636'});
                slide.addText(ElementosPresentacionComent[i + 1], {x: 5.1, y: 5, font_size: 8, color: '363636'});
            }
            //SE CREA LA ULTIMA DIAPOSITIVA
            pptx.defineSlideMaster({
                title: 'THANKS_SLIDE',
                bkgd: '36ABFF',
                objects: [
                    {'image': {x: '0%', y: '0%', w: '100%', h: '100%', path: 'formato-presentaciones/cssa/cssa_formato1_final1_version1.png'}}
                ]
            });
            var slide = pptx.addNewSlide('THANKS_SLIDE');
            //SE GUARDA EL ARCGHIVO
            pptx.save('PRESENTACION_REPORTE_' + getTimestamp());


            //despues de generar el archivo se borran las imagenes temporales
            for (var i = 0; i < ElementosPresentacionPPTX.length; i++) {
               // BorrarArchivoDelServidor(ElementosPresentacionPPTX[i]);
            }
        }

        function BorrarArchivoDelServidor(FileName) {
            $.ajax({
                type: 'post',
                dataType: 'json',
                cache: 'false',
                data: {FileName: FileName},
                url: "BorrarImagenes.php",
                success: function (res) {

                    if (res.success == 1) {
                        console.log("borrado... " + res.FileName);
                    } else {
                        console.log("Fallo al borrar. " + res.error);
                    }
                }
            })
        }

        function getTimestamp() {
            var dateNow = new Date();
            var dateMM = dateNow.getMonth() + 1;
            dateDD = dateNow.getDate();
            dateYY = dateNow.getFullYear(), h = dateNow.getHours();
            m = dateNow.getMinutes();
            return dateNow.getFullYear() + '' + (dateMM <= 9 ? '0' + dateMM : dateMM) + '' + (dateDD <= 9 ? '0' + dateDD : dateDD) + (h <= 9 ? '0' + h : h) + (m <= 9 ? '0' + m : m);
        }
</script>
</body>
</html>
