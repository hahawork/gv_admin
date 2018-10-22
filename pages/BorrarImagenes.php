<?php

try {

    if (isset($_POST['FileName'])) {

        $FileName = $_POST['FileName'];

        if (is_file($FileName)) {
            if (unlink($FileName)) {
                $arrayName = array('success' => 1, 'error' => "", 'mensaje' => "Se ha descaergado con exito", 'FileName' => $FileName);
                echo json_encode($arrayName);
            } else {
                $arrayName = array('success' => 0, 'error' => "no se ha podido borrar", 'mensaje' => "", 'FileName' => $FileName);
                echo json_encode($arrayName);
                exit();
            }
        } else {
            $arrayName = array('success' => 0, 'error' => "no es un archivo", 'mensaje' => "", 'FileName' => $FileName);
            echo json_encode($arrayName);
            exit();
        }
    } else {
        $arrayName = array('success' => 0, 'error' => "no parametros", 'mensaje' => "", 'FileName' => "nofilename");
        echo json_encode($arrayName);
        exit();
    }
} catch (Exception $exc) {

    $arrayName = array('success' => 0, 'error' => $exc->getTraceAsString(), 'mensaje' => "");
    echo json_encode($arrayName);
}
?>