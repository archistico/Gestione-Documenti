<?php

require('DistribuzioneTipologia.php');

class Distribuzione {
    
    public $anno;
    public $tipologia;
    public $id;
    
    public function __construct($tipo, $anno) {
        $this->tipologia = new DistribuzioneTipologia($tipo);
        $this->anno = $anno;
    }
    
    public function GetAnno(){
        return $this->anno;
    }
    
    public function GetTipologia(){
        return $this->tipologia;
    }
    
    public function CreaDB(){
        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');
        //create the database
        $db->exec("CREATE TABLE Distribuzione (Id INTEGER PRIMARY KEY, Tipologia INTEGER, Numero INTEGER, Anno INTEGER)"); 
    }

    public function Aggiungi() {
        try {
            //open the database
            $db = new PDO('sqlite:helpbook.sqlite');
            
            //Cerca il numero più alto della distribuzione dello stesso anno e stesso tipo
            $result = $db->query('SELECT MAX(Numero) AS Ultimo FROM Distribuzione WHERE Anno = '.$this->GetAnno().' AND Tipologia = '.$this->tipologia->GetTipologiaNumero());
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $numero = $row['Ultimo'] + 1;
            $this->id = $numero;
            
            //insert some data...
            $db->exec("INSERT INTO Distribuzione (Tipologia, Numero, Anno) VALUES ( " . $this->tipologia->GetTipologiaNumero() . " , " .$numero." , " . $this->GetAnno() .");");
            
            // close the database connection
            $db = NULL;
        } catch (PDOException $e) {

            print 'Exception : ' . $e->getMessage();
        }
    }
    
    public function GetID() {
        return $this->id;
    }
    
    
    // USO $dis->GetIDbyDistribuzione(Tipologia::ContoDeposito, 2, 2016);
    public function GetIDbyDistribuzione($tipologia, $numero, $anno){
        try {
            //open the database
            $db = new PDO('sqlite:helpbook.sqlite');
            
            //Cerca il numero più alto della distribuzione dello stesso anno e stesso tipo
            $result = $db->query('SELECT Id FROM Distribuzione WHERE Anno = '.$anno.' AND Tipologia = '.$tipologia .' AND numero = '.$numero);
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $risultato = $row['Id'];
            $this->id = $risultato;

            // close the database connection
            $db = NULL;
            
            return $this->id;
            
        } catch (PDOException $e) {

            print 'Exception : ' . $e->getMessage();
        }
    }

}
