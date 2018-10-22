<?php
require_once '../../conexion/conexion.php';
$cnn = new conexion();
$conn = $cnn->conectar();
//variable de salida.
$output = "";

//para guardar los productos propios
if (!empty($_POST["opcion"]) and ( $_POST["opcion"] == 'guardarpropios') and ! empty($_POST["IdCliente"]) and ! empty($_POST["IdMarca"])) {

    $IdCliente = $_POST["IdCliente"];
    $IdMarca = $_POST["IdMarca"];
    $CodCafeSoluble = $_POST["CodCafeSoluble"];
    $CodCasaMantica = $_POST["CodCasaMantica"];
    $CodigoWalmart = $_POST["CodigoWalmart"];
    $CodigoBarras = $_POST["CodigoBarras"];
    $Descripcion = $_POST["Descripcion"];
    $FechaRegistro = $_POST["FechaRegistro"];
    $IdCanal = $_POST["IdCanal"];
    $categoria = $_POST["categoria"];
    $EstadoActivo = $_POST["EstadoActivo"];
    $Aplica_FV = $_POST["Aplica_FV"];
    $Division_Disegsa = $_POST["Division_Disegsa"];
    $TipoPDV_disponible = $_POST["TipoPDV_disponible"];
    $cod_dep_disegsa = $_POST["cod_dep_disegsa"];

    $sql = "INSERT INTO `planpromo_presentaciones` "
            . "(`IdCliente`, `IdMarca`, `CodCafeSoluble`, `CodCasaMantica`, `CodigoWalmart`, `"
            . "CodigoBarras`, `Descripcion`, `FechaRegistro`, `IdCanal`, `categoria`, `EstadoActivo`, `Aplica_FV`, `Division_Disegsa`, `TipoPDV_disponible`, `cod_dep_disegsa`) "
            . "VALUES ('$IdCliente', '$IdMarca', '$CodCafeSoluble', '$CodCasaMantica', '$CodigoWalmart', "
            . "'$CodigoBarras', '$Descripcion', '$FechaRegistro', '$IdCanal', '$categoria', '$EstadoActivo', '$Aplica_FV', '$Division_Disegsa', '$TipoPDV_disponible', '$cod_dep_disegsa');";


    if (mysqli_query($conn, $sql)) {

        $last_id = $conn->insert_id;

        echo json_encode(array("success" => 1, "Mensaje" => "Se ha guardado con éxito. Last inserted ID is: " . $last_id));
    } else {
        echo json_encode(array("success" => 0, "Mensaje" => "Error: " . $sql . "<br>" . $conn->error));
    }
}

//idMarcaCompete
//NombreMarcaCompete
//idMarcaCompetePadre
//NombrePresentCompete
//FechaReg
//Categoria
//Cliente
//idCanalCompete
//para guardar los productos competencia
if (!empty($_POST["opcion"]) and ( $_POST["opcion"] == 'guardarcompetencia') and ! empty($_POST["idMarcaCompetePadre"]) and ! empty($_POST["Categoria"])) {

    $idMarcaCompete = $_POST["idMarcaCompete"];
    $NombreMarcaCompete = $_POST["NombreMarcaCompete"];
    $idMarcaCompetePadre = $_POST["idMarcaCompetePadre"];
    $NombrePresentCompete = $_POST["NombrePresentCompete"];
    $FechaReg = $_POST["FechaReg"];
    $Categoria = $_POST["Categoria"];
    $Cliente = "c".$_POST["Cliente"]."c";
    $idCanalCompete = $_POST["idCanalCompete"];

    $sql = "INSERT INTO `precios_competenciapresentacion` "
            . "(`idPresentComp`, `idMarcaCompete`, `NombreMarcaCompete`, `idMarcaCompetePadre`, `NombrePresentCompete`, `FechaReg`, `Categoria`, `Cliente`, `idCanalCompete`) "
            . "VALUES (NULL, '$idMarcaCompete', '$NombreMarcaCompete', '$idMarcaCompetePadre', '$NombrePresentCompete', '$FechaReg', '$Categoria', '$Cliente', '$idCanalCompete');";


    if (mysqli_query($conn, $sql)) {

        $last_id = $conn->insert_id;

        echo json_encode(array("success" => 1, "Mensaje" => "Se ha guardado con éxito. Last inserted ID is: " . $last_id));
    } else {
        echo json_encode(array("success" => 0, "Mensaje" => "Error: " . $sql . "<br>" . $conn->error));
    }
}


//obtiene los datos
if (!empty($_POST["opcion"]) and ! empty($_POST["idCliente"]) and ! empty($_POST["NivelAcceso"])) {

    $NivelAcceso = $_POST["NivelAcceso"];
    $idCliente = $_POST["idCliente"];

    $sql = "";

    switch ($_POST["opcion"]) {
        case 'clientes':
            if ($NivelAcceso == 1) {
                $sql = "SELECT IdCliente, RazonSocial FROM `clientes` ORDER BY RazonSocial";
            } else {
                $sql = "SELECT IdCliente, RazonSocial FROM `clientes` WHERE IdCliente = $idCliente ORDER BY RazonSocial";
            }
            break;

        case 'canales':
            $sql = "SELECT IdCanal, NombreCanal FROM  CatCanales ORDER BY NombreCanal";
            break;

        case 'marcas':
            $sql = "SELECT IdMarca, Descripcion FROM `planpromo_marcas` WHERE IdCliente = $idCliente ORDER BY Descripcion";
            break;
        case 'categorias':
            $sql = "SELECT idCategoria, DescCategoria FROM `Precios_CatCategorias` WHERE IdCliente like '%c" . $idCliente . "c%' ORDER BY DescCategoria";
            break;

        case 'marcascompetencias':
            $sql = "SELECT DISTINCT `idMarcaCompete`,`NombreMarcaCompete` FROM `precios_competenciapresentacion` WHERE Cliente LIKE '%c".$idCliente."c%' ORDER BY `NombreMarcaCompete`";
            break;
        
        default:
            break;
    }

    echo LlenarSelectHtml($sql);
}

function LlenarSelectHtml($sql) {

    global $conn;
    $result = mysqli_query($conn, $sql);
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $output .= "  <option value='0' disabled='' selected=''>Seleccione.. </option>";
            while ($row = mysqli_fetch_array($result)) {
                $val = $row[0];
                $txt = $row[1];
                ?>
                <option value="<?= $val ?>"><?= $txt ?></option>
                <?php
            }
        } else {
            $output .= "  <option value='0' disabled='' selected=''>No hay disponibles.</option>";
        }
    } else {
        $output = "<option value='0' disabled=''>Error... " . $sql . "</option>";
    }

    return $output;
}
?>