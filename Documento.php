<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/05/16
 * Time: 16.55
 */

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
