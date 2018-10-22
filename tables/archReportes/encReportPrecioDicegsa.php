<?php

$rowArrayEncabColumns = array('CODIGO', 'PRODUCTO', 'LA COLONIA', 'LA UNION', 'VARIACION UNION VRS COLONIA', 'MAXIPALI',
    'VARIACION MAXI PALI VRS COLONIA', 'PALI', 'VARIACION PALI VRS COLONIA', 'VARIACION MAXI/PALI VRS UNION', 'PRICE SMART', 'VARIACION PRICE SMART VRS COLONIA');
$objPHPExcel->setActiveSheetIndex($posicion)
        ->setCellValue('B1', 'ANALISIS DE VARIACION DE PRECIOS')
        ->setCellValue('B2', '=TODAY()')
        ->fromArray($rowArrayEncabColumns, NULL, 'A3')
        ->getStyle('B2')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX15);
//color de fuente
$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
//tipo relleno de celda
$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
//relleno de celda
$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->getFill()->getStartColor()->setARGB('366092');
$objPHPExcel->getActiveSheet()->getStyle('E1:E3')->getFill()->getStartColor()->setARGB('FF00000');
$objPHPExcel->getActiveSheet()->getStyle('G1:G3')->getFill()->getStartColor()->setARGB('FF00000');
$objPHPExcel->getActiveSheet()->getStyle('I1:I3')->getFill()->getStartColor()->setARGB('FF00000');
$objPHPExcel->getActiveSheet()->getStyle('J1:J3')->getFill()->getStartColor()->setARGB('FF00000');
$objPHPExcel->getActiveSheet()->getStyle('L1:L3')->getFill()->getStartColor()->setARGB('FF00000');
//unir celdas
//$objPHPExcel->getActiveSheet()->mergeCells('A1:A3');
//$objPHPExcel->getActiveSheet()->mergeCells('C1:C3');

//alineacion del texto
$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$styleArray = array(
    'font' => array(
        'bold' => true,
    ),
    'borders' => array(
        'top' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
        ),
    )
);
$objPHPExcel->getActiveSheet()->getStyle('A1:L3')->applyFromArray($styleArray);
//Setting a column’s width
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(TRUE);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(TRUE);
?>