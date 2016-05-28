<?php

require('TipologiaDocumento.php');

class Documento {

    public $anno;
    public $tipologia;

    public function __construct($tipo, $anno) {
        $this->tipologia = new TipologiaDocumento($tipo);
        $this->anno = $anno;
    }
    
    public function GetAnno(){
        return $this->anno;
    }
    
    public function GetTipologia(){
        return $this->tipologia;
    }
    
}
