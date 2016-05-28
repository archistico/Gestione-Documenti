<?php

class Opera {
    
    public $titolo;
    public $prezzo;
    public $id;
    
    public function __construct($titolo, $prezzo) {
        $this->titolo = $titolo;
        $this->prezzo = $prezzo;
    }
    
    public function GetPrezzo(){
        return $this->prezzo;
    }
    
    public function GetTitolo(){
        return $this->titolo;
    }
    
    public function CreaDB(){
        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');
        //create the database
        $db->exec("CREATE TABLE Opera (Id INTEGER PRIMARY KEY, Titolo TEXT, Prezzo REAL)"); 
    }

    public function Aggiungi() {
        try {
            //open the database
            $db = new PDO('sqlite:helpbook.sqlite');
            
            //insert some data...
            $db->exec("INSERT INTO Opera (Titolo, Prezzo) VALUES ( '" . $this->titolo . "' , " .$this->prezzo.");");
            
            // close the database connection
            $db = NULL;
        } catch (PDOException $e) {

            print 'Exception : ' . $e->getMessage();
        }
    }
    
    public function GetID() {
        $db = new PDO('sqlite:helpbook.sqlite');
        $result = $db->query("SELECT Id FROM Opera WHERE Titolo = '" . $this->titolo."'" );
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $id = $row['Id'];
        return $id;
    }

}
