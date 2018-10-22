<style>
    article.accordion
    {
        display: block;
        width: 100%;
        /*width: 43em;*/
        margin: 0 auto;
        background-color: #0782C1;
        overflow: auto;
        border-radius: 5px;
        box-shadow: 0 3px 3px rgba(0,0,0,0.3);
    }
    article.accordion section
    {
        position: relative;
        display: block;
        float: left;
        /*width: 4.65%;*/
        width: 2em;
        height: 12em;
        margin: 0.5em 0 0.5em 0.5em;
        color: #333;
        background-color: #333;
        overflow: hidden;
        border-radius: 3px;
    }
    article.accordion section h2
    {
        position: absolute;
        font-size: 1em;
        font-weight: bold;
        width: 12em;
        height: 2em;
        top: 12em;
        left: 0;
        text-indent: 1em;
        padding: 0;
        margin: 0;
        color: #ddd;
        -webkit-transform-origin: 0 0;
        -moz-transform-origin: 0 0;
        -ms-transform-origin: 0 0;
        -o-transform-origin: 0 0;
        transform-origin: 0 0;
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    article.accordion section h2 a
    {
        display: block;
        width: 100%;
        line-height: 2em;
        text-decoration: none;
        color: inherit;
        outline: 0 none;
    }
    article.accordion section div
    {
        display: none;
    }
    .usuario
    {
        display: inline-block;                
        width: 70px;
        height: 70px;
        -webkit-transform-origin: 0 0;
        -moz-transform-origin: 0 0;
        -ms-transform-origin: 0 0;
        -o-transform-origin: 0 0;
        transform-origin: 0 0;
    }
    article.accordion section:target
    {
        max-height: 260px;
        width: auto;
        /*width: 30em;*/
        padding: 0 1em;
        overflow: auto;
        color: #333;
        background-color: #333;
    }

    article.accordion section:target h2
    {
        position: static;
        font-size: 1.3em;
        text-indent: 0;
        color: #fff;
        -webkit-transform: rotate(0deg);
        -moz-transform: rotate(0deg);
        -ms-transform: rotate(0deg);
        -o-transform: rotate(0deg);
        transform: rotate(0deg);
    } 
    article.accordion section:target div
    {
        display: inline-block;
    }            
    article.accordion section,
    article.accordion section h2
    {
        -webkit-transition: all 1s ease;
        -moz-transition: all 1s ease;
        -ms-transition: all 1s ease;
        -o-transition: all 1s ease;
        transition: all 1s ease;
    }

</style>

<article class="accordion">
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
                $consultasql = "SELECT `idUsuario`, `NombreUsuario`, `Foto_URL` FROM `usuario` WHERE IdCliente = '$index' AND EstadoActivo = 1 AND MarcaAsistenciaGPS = 1";
            } elseif ($NivelAcceso == 4) {
                $consultasql = "SELECT `idUsuario`, `NombreUsuario`, `Foto_URL` FROM `usuario` WHERE IdCliente = '$index' AND (idUsuario = '$idUsuario' OR idSupervisor = '$idUsuario') AND EstadoActivo = 1 AND MarcaAsistenciaGPS = 1";
            }
            
            if ($resusuarios = mysqli_query($conn, $consultasql)) {
                if (mysqli_num_rows($resusuarios) > 0) {
                    ?>
                    <section id="acc<?= $index ?>">
                        <h2><a href="#acc<?= $index ?>"><?= $nombrecliente ?></a></h2>

                        <?php
                        while ($row1 = mysqli_fetch_assoc($resusuarios)) {
                            ?>
                            <div style="width: 100px; text-align: center; border: #FF7E00 solid 1px;">
                                <a href="pages/asistencia-detalles.php?idSupervisor=<?= $row1["idUsuario"] ?>&NombreSupervisor=<?= $row1["NombreUsuario"] ?>">
                                    <img class="usuario" src="<?= $row1["Foto_URL"] ?>" alt=""/>
                                    <label style="white-space: nowrap; height: 20px; overflow: hidden;"><?= $row1["NombreUsuario"] ?></label>
                                </a>
                            </div>                        
                            <?php
                        }
                        ?>
                    </section>
                    <?php
                }
            }
        }
    }
    ?>

</article>