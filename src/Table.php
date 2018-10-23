<?php

namespace K;

class Table {

    public $table;
    public $columns;
    private $ret = [];

    public function __construct( \PhpOffice\PhpWord\Element\Table $phpWordTable, $replaceableRows ) {
        $this->table = $phpWordTable;
        $this->columns = $replaceableRows;
        $this->setRet();
        $this->addTable();
    }

    private function setRet() {

        $ret = [];
        $tab = [];
        foreach( $this->columns as $col ) {
            $values = K::get( $col['value']);
            $tab[$col['index']] = $values;
        }
        foreach( $tab as $j => $values ) {
            foreach( $values as $i => $value ) {
                if(!isset($ret[$i])) $ret[$i] = [];
                $ret[$i][$j] = $value;
            }
        }
        $this->ret = $ret;

    }

    private function addTable() {
        foreach($this->ret as $i => $row ) {
            $this->table->addRow();
            foreach($row as  $j => $value ) {
                $this->table->addCell()->addText($value);
            }
        }
    }
}