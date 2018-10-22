<style> 
    /* Barra Horizontal de Corrimiento */ 
    .barra-panel {overflow:auto; left:10px; top:1%; width:98.5%; right:20; height:auto; z-index:1; } 
    .borde-Panel {border: 1px solid RGB(0,0,0); background: RGB(136,136,136); } 
    .punta-Izq {border-top-left-radius: 8px;} 
    .punta-Der {border-top-right-radius: 8px;} 
    .barra-Scroll {width: 4000px;} /* Aca entran 20 fotos con un incremento de 130px por fotograma +/- */
    .contiene-Item {border: 1px solid RGB(0,0,0); width: 100px; height: 120px; float: left; margin: 3px; overflow: hidden;}
    .user-name {white-space: nowrap; color: white; height: 20px; overflow: hidden; width: 100px;}
</style> 

<script>
    function gid(a_id) {
        return document.getElementById(a_id);
    }

    function close_all() {

        [].forEach.call(document.querySelectorAll('[id^=user_]'), function (div) {
            div.style.display = 'none';
        });

    }


    function find_my_div() {
        close_all();
        var keywords = gid('edit_search').value.trim().toLowerCase().split(/\s+/),
                haystack = document.querySelectorAll('[id^="user_"]'),
                textProp = 'textContent' in document.body ? 'textContent' : 'innerText',
                userWords,
                found = [].filter.call(haystack, function (user) {
            userWords = user[textProp].toLowerCase();
            return keywords.some(function (word) {
                return userWords.indexOf(word) > -1;
            });
        });
        console.log(found);
        [].forEach.call(found, function (user) {
            user.style.display = 'block';
            //$(".barra-Scroll").find("span").css({"color": "red", "border": "2px solid red"});
        });

    }
</script>

<!-- /input-group -->
<h5 class="col-xs-5 pull-righ">Buscar <code>Escriba un nombre.</code></h5>
<div class="input-group input-group-sm col-xs-6">
    <input type="text" class="form-control" id="edit_search" onkeyup="javascript: find_my_div();">
    <span class="input-group-btn">
        <button type="button" class="btn btn-info btn-flat"><i class="fa fa-search"></i></button>
    </span>
</div>
<!-- /input-group -->


<div class="barra-panel borde-Panel punta-Izq punta-Der"> 
    <!--    <div class="barra-Scroll">
            <div class="contiene-Item"><img src='../dist/img/AlexAntonioValleLazo.jpg' width="99px" height="99px"><span class="user-name">Nombre del usuario largo</span></div>
            <div class="contiene-Item"><img src='../dist/img/AlexAntonioValleLazo.jpg' width="99px" height="99px"><span class="user-name">Nombre del usuario largo</span></div>
            <div class="contiene-Item"><img src='../dist/img/AlexAntonioValleLazo.jpg' width="99px" height="99px"><span class="user-name">Nombre del usuario largo</span></div>
            <div class="contiene-Item"><img src='../dist/img/AlexAntonioValleLazo.jpg' width="99px" height="99px"><span class="user-name">Nombre del usuario largo</span></div>
            <div class="contiene-Item"><img src='../dist/img/AlexAntonioValleLazo.jpg' width="99px" height="99px"><span class="user-name">Nombre del usuario largo</span></div>
        </div> -->


    <?php
    $sql = "";
    if ($NivelAcceso == 1) {
        $sql = "SELECT * FROM `clientes`";
    } elseif ($NivelAcceso == 3) {
        $sql = "SELECT * FROM `clientes` WHERE IdCliente = '$idCliente'";
    } elseif ($NivelAcceso == 4) {
        $sql = "SELECT * FROM `clientes` WHERE IdCliente = '$idCliente'";
    }

    if ($result = mysqli_query($conn, $sql)) {
        while ($row = mysqli_fetch_assoc($result)) {
            $index = $row["IdCliente"];
            $nombrecliente = $row["RazonSocial"];


            $consultasql = "";
            if ($NivelAcceso == 1 or $NivelAcceso == 3) {
                $consultasql = "SELECT `idUsuario`, `NombreUsuario`, `Foto_URL` FROM `usuario` WHERE IdCliente = '$index' AND EstadoActivo = 1 AND MarcaAsistenciaGPS = 1 ORDER BY NombreUsuario";
            } elseif ($NivelAcceso == 4) {
                $consultasql = "SELECT `idUsuario`, `NombreUsuario`, `Foto_URL` FROM `usuario` WHERE IdCliente = '$index' AND (idUsuario = '$idUsuario' OR idSupervisor = '$idUsuario') AND EstadoActivo = 1 AND MarcaAsistenciaGPS = 1 ORDER BY NombreUsuario";
            }

            if ($resusuarios = mysqli_query($conn, $consultasql)) {
                if (mysqli_num_rows($resusuarios) > 0) {
                    ?>
                    <div class="barra-Scroll">

                        <?php
                        while ($row1 = mysqli_fetch_assoc($resusuarios)) {
                            ?>
                            <div class="contiene-Item" id="user_<?= $row1["idUsuario"] ?>">
                                <a href="pages/asistencia-detalles.php?idSupervisor=<?= $row1["idUsuario"] ?>&NombreSupervisor=<?= $row1["NombreUsuario"] ?>">
                                    <img src='<?= $row1["Foto_URL"] ?>' width="99px" height="99px">
                                    <span class="user-name"><?= $row1["NombreUsuario"] ?></span>
                                </a>
                            </div>                                                 
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            }
        }
    }
    ?>
</div> 