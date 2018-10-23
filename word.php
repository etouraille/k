<?php

require_once(__DIR__.'/vendor/autoload.php');

use K\Table;


$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('voiture.docx');
$vars = $templateProcessor->getVariables();

$voiture = ['K_NODE;VOITURE' => ['repre' => '2CV' , 'K_NODE;MOTEUR' => ['repre' => 'Citroën', 'K_NODE;CYLINDRE' => ['repre' => 2 ]]]];

$replace = [];

foreach( $vars as $var ) {
    $tab = explode(':=' , $var );
    $temp = $voiture;
    foreach( $tab as $key ) {
        $temp = isset($temp[$key])?$temp[$key]:['repre' => null];
    }
    $replace[$var] = $temp['repre'];
}

foreach( $replace as $key => $value ) {
    $templateProcessor->setValue($key, $value);

}

$templateProcessor->saveAs('VOITURE.docx');



$pw = \PhpOffice\PhpWord\IOFactory::load('voiture.docx');


// si le header du tableau contient les element hello ou bien word on complete le tableau.
$replaceableTables = [];
foreach( $pw->getSections() as $section ) {
    foreach( $section->getElements() as $elem ) {
        if( $elem instanceof PhpOffice\PhpWord\Element\Table ) {
            $currentTable = $elem;
            foreach($currentTable->getRows() as $row ) {
                $replaceableRows = [];
                foreach( $row->getCells() as $index => $cell ) {
                    $cellValue = $cell->getElements()[0]->getElements()[0]->getText();
                    if( $value =  isReplaceable($cellValue)) {
                        $replaceableRows[] = ['index' => $index, 'value' => $value ];
                    }
                }
                if( count($replaceableRows) > 0 ) {
                    $replaceableTables[] = new Table($currentTable, $replaceableRows);
                }
            }
        }
    }
}

function isReplaceable( $value ) {
    if(preg_match('#\${([^}]*)}$#', $value, $ret )) {
        return $ret[1];
    }
    return false;
}

$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($pw, 'Word2007');
$objWriter->save('VOIT.docx.docx');