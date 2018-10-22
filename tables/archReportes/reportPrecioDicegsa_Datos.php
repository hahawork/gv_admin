<?php

$reportrange = isset($_POST['reportrange']) ? $_POST['reportrange'] : date("Y-m-d") . "," . date("Y-m-d");
$myArray = explode(',', $reportrange);
$FechaIni = $myArray[0];
$FechaFin = $myArray[1];
$posicion = 0;

$sqlMarcas = "SELECT DISTINCT Precios_MisPrecios.idMiMarca, planpromo_marcas.Descripcion, idClienteMP "
        . "FROM `Precios_MisPrecios` INNER JOIN planpromo_marcas "
        . "on Precios_MisPrecios.idMiMarca = planpromo_marcas.IdMarca "
        . "WHERE idClienteMP = 1 AND idUsuario = 8 AND FechaReg BETWEEN '2018-4-15' AND '2018-4-30' "
        . "ORDER BY planpromo_marcas.Descripcion";

if ($resultMarca = mysqli_query($conn, $sqlMarcas)) {

    if (mysqli_num_rows($resultMarca) > 0) {

        while ($row = mysqli_fetch_assoc($resultMarca)) {

            //columnas a usar en el reporte y celda inicial de los datos
            $col = array('A' => "A4", 'B' => "B4", 'C' => "C4", 'D' => "D4", 'E' => "E4", 'F' => "F4", 'G' => "G4", 'H' => "H4", 'I' => "I4", 'J' => "J4", 'K' => "K4", 'L' => "L4");
            //el encabezado del reporte
            include("../tables/archReportes/encReportPrecioDicegsa.php");

            for ($j = 1; $j <= 10; $j++) {
                try {
                    $objPHPExcel->setActiveSheetIndex($posicion)
                            ->setCellValue($col["A"], ($j * rand(0, $j)))
                            ->setCellValue($col["B"], "PRODUCTO $j " . md5("PRODUCTO" . ($j + 5)))
                            ->setCellValue($col["C"], ($j * rand(0, 1000)))
                            ->setCellValue($col["D"], ($j * rand(0, $j)))
                            ->setCellValue($col["E"], '=(' . $col["C"] . '/' . $col["D"] . ')-1')
                            ->setCellValue($col["F"], ($j * rand(0, 1000)))
                            ->setCellValue($col["G"], '=(' . $col["C"] . '/' . $col["F"] . ')-1')
                            ->setCellValue($col["H"], ($j * rand(0, 1000)))
                            ->setCellValue($col["I"], '=(' . $col["C"] . '/' . $col["H"] . ')-1')
                            ->setCellValue($col["J"], '=(' . $col["F"] . '/' . $col["D"] . ')-1')
                            ->setCellValue($col["K"], ($j * rand(0, 1000)))
                            ->setCellValue($col["L"], '=(' . $col["C"] . '/' . $col["K"] . ')-1');

                    $objPHPExcel->getActiveSheet()->getStyle($col["E"])->getNumberFormat()
                            ->setFormatCode('[Green][>0]C$#,##0;[Red][<0]C$#,##0;C$#,##0');
                    $objPHPExcel->getActiveSheet()->getStyle($col["G"])->getNumberFormat()
                            ->setFormatCode('[Green][>0]C$#,##0;[Red][<0]C$#,##0;C$#,##0');
                    $objPHPExcel->getActiveSheet()->getStyle($col["I"])->getNumberFormat()
                            ->setFormatCode('[Green][>0]C$#,##0;[Red][<0]C$#,##0;C$#,##0');
                    $objPHPExcel->getActiveSheet()->getStyle($col["J"])->getNumberFormat()
                            ->setFormatCode('[Green][>0]C$#,##0;[Red][<0]C$#,##0;C$#,##0');
                    $objPHPExcel->getActiveSheet()->getStyle($col["L"])->getNumberFormat()
                            ->setFormatCode('[Green][>0]C$#,##0;[Red][<0]C$#,##0;C$#,##0');
                    
                } catch (Exception $ex) {
                    
                }
                //incrementa las filas
                $col['A'] = "A" . (4 + $j); //ej: A5
                $col['B'] = "B" . (4 + $j); //ej: B5
                $col['C'] = "C" . (4 + $j);
                $col['D'] = "D" . (4 + $j);
                $col['E'] = "E" . (4 + $j);
                $col['F'] = "F" . (4 + $j);
                $col['G'] = "G" . (4 + $j);
                $col['H'] = "H" . (4 + $j);
                $col['I'] = "I" . (4 + $j);
                $col['J'] = "J" . (4 + $j);
                $col['K'] = "K" . (4 + $j);
                $col['L'] = "L" . (4 + $j);
            }


            // Rename worksheet
            $objPHPExcel->getActiveSheet()->setTitle($row["Descripcion"]);
            // Create a new worksheet
            $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel);
            // Attach the worksheet as the first worksheet in the PHPExcel object
            $objPHPExcel->addSheet($myWorkSheet);
            // siguiente hoja del libro
            $posicion ++;
        }
    }
}