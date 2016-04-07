<?php

require_once 'PHPExcel.php';

$pExcel = PHPExcel_IOFactory::load('country list for uploads.xlsx');

// Cycle through Excel-file worksheets
foreach ($pExcel->getWorksheetIterator() as $worksheet) {
    // load data from object into an array
    $tables[] = $worksheet->toArray();
}

// choosing the worksheet
$pExcel->setActiveSheetIndex(0);
$aSheet = $pExcel->getActiveSheet();

$highestRow = $worksheet->getHighestRow(); //amount of rows in a file

for ($row = 3; $row <= $highestRow; $row++) {
    // get access to the cell by the row number (count starts from 1) 
    // and the column number (count start from 0) 
    $cell_1 = $aSheet->getCellByColumnAndRow(1, $row); //country ID 
    $cell_2 = $aSheet->getCellByColumnAndRow(2, $row); //country name 
    
    //geting the cell values
    $id = $cell_1->getValue();
    $name = $cell_2->getValue();

    echo '<option value="'.$id.'">'.$name.'</option>';
}
