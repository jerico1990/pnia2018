<?php

/** Error reporting */
error_reporting(E_ALL);

/** Include path **/
ini_set('include_path', ini_get('include_path').';../web/PHPExcel/Classes/');
//require(__DIR__ . '/../../web/PHPExcel/Classes/');
/** PHPExcel */
include 'PHPExcel.php';

/** PHPExcel_Writer_Excel2007 */
include 'PHPExcel/Writer/Excel2007.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$sheet = $objPHPExcel->getActiveSheet();

$Meses=[];
$objPHPExcel->setActiveSheetIndex(0);

$sheet->SetCellValue('A1', '');
$sheet->SetCellValue('B1', '');
$sheet->SetCellValue('C1', 'Detalle');
$sheet->SetCellValue('C5', 'Partida');
$sheet->SetCellValue('D5', 'Subpartida');
$sheet->SetCellValue('E5', 'Código Matriz');
$sheet->SetCellValue('F5', 'Específica');
$sheet->SetCellValue('G5', 'Detalle Gasto');
$sheet->SetCellValue('H5', 'Unidad');
$sheet->SetCellValue('I5', 'Cantidad');
$sheet->SetCellValue('J5', 'Costo Unitario');
$sheet->SetCellValue('K5', 'Total (del Proyecto Adjudicado)');


// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="DemoReporte.xls"');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>
