<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Distribuzione
 *
 * @author ARCHI
 */
class Distribuzione {

    public function CreaDB(){
        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');
        //create the database
        $db->exec("CREATE TABLE Distribuzione (Id INTEGER PRIMARY KEY, Tipologia INTEGER, Numero INTEGER, Anno INTEGER)"); 
    }

    public function Aggiungi($documento) {
        try {
            //open the database
            $db = new PDO('sqlite:helpbook.sqlite');
            
            //Cerca il numero più alto della distribuzione dello stesso anno e stesso tipo
            $result = $db->query('SELECT MAX(Numero) AS Ultimo FROM Distribuzione WHERE Anno = '.$documento->GetAnno().' AND Tipologia = '.$documento->tipologia->GetTipologiaNumero());
            $row = $result->fetch(PDO::FETCH_ASSOC);
            $numero = $row['Ultimo'] + 1;
            
            //insert some data...
            $db->exec("INSERT INTO Distribuzione (Tipologia, Numero, Anno) VALUES ( " . $documento->tipologia->GetTipologiaNumero() . " , " .$numero." , " . $documento->GetAnno() .");");
            
            // close the database connection
            $db = NULL;
        } catch (PDOException $e) {

            print 'Exception : ' . $e->getMessage();
        }
    }

}
