<?php

if (isset($_POST["id"])) {

    $id = $_POST["id"];

    $arreglo = array("success" => 1, "uno" => "elemento $id");
    echo json_encode($arreglo);
}

if (isset($_REQUEST["cantidad"])) {

    $cant = $_REQUEST["cantidad"];
    $titu = $_REQUEST["titulo"];

    $resultado = "<ul>";
    for ($index = 0; $index < $cant; $index++) {
        $resultado.= "<li>$titu$index</li>";
    }
    $resultado.="</ul>";

    echo $resultado;
}
?>