<?php

require('Opera.php');

class DistribuzioneDettaglio {
    
    public $fkDistribuzione;
    public $fkOpera;
    public $quantita;
    public $sconto;
    
    public function __construct($fkDistribuzione, $fkOpera, $quantita, $sconto) {
        $this->fkDistribuzione = $fkDistribuzione;
        $this->fkOpera = $fkOpera;
        $this->quantita = $quantita;
        $this->sconto = $sconto;
    }
    
    public function GetQuantita(){
        return $this->quantita;
    }
    
    public function GetSconto(){
        return $this->sconto;
    }    
    
    public function GetOpera(){
        return $this->fkOpera->titolo;
    }
    
    public function CreaDB(){
        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');
        //create the database
        $db->exec("CREATE TABLE DistribuzioneDettaglio (Id INTEGER PRIMARY KEY, fkDistribuzione INTEGER, fkOpera INTEGER, quantita INTEGER, sconto REAL)"); 
    }

    public function Aggiungi() {
        try {
            //open the database
            $db = new PDO('sqlite:helpbook.sqlite');
            
            //insert some data...
            $db->exec("INSERT INTO DistribuzioneDettaglio (fkDistribuzione, fkOpera, quantita, sconto) VALUES ( " . $this->fkDistribuzione . " , " .$this->fkOpera." , " . $this->quantita." , " . $this->sconto .");");
            
            // close the database connection
            $db = NULL;
        } catch (PDOException $e) {

            print 'Exception : ' . $e->getMessage();
        }
        return true;
    }
}
