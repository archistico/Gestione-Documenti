

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 *
 * @author ARCHI
 */
abstract class Database {

    public static function SelectDistribuzioneTipologia() {
        print "<select name='idTipologia'>";
        
            /*
            const NonDefinito = 0;
            const Fattura = 1;
            const ContoDeposito = 2;
            const Ricevuta = 3;
             */
        
            print "<option value='1'>";
            print "Fattura";
            print "</option>\n";
            
            print "<option value='2'>";
            print "Conto Deposito";
            print "</option>\n";
            
            print "<option value='3'>";
            print "Ricevuta";
            print "</option>\n";
        

        print "</select>";
    }
    
    public static function SelectOpere() {

        try {
            //open the database
            $db = new PDO('sqlite:helpbook.sqlite');

            print "<select name='idOpera'>";
            
            $result = $db->query('SELECT * FROM Opera ORDER BY Titolo');
            foreach ($result as $row) {
                print "<option value='" . $row['Id'] . "'>";
                print "" . $row['Titolo'] . "";
                print " - &euro; " . $row['Prezzo'] . "";
                print "</option>";
            }
            
            print "</select>";
            
            // close the database connection
            $db = NULL;
        } catch (PDOException $e) {
            print 'Exception : ' . $e->getMessage();
        }
    }
    
    public static function AnnoInCorso($anno)
    {
        $date = new DateTime();
        $dateStr = $date->format('m-d-Y');
        $dateArray = date_parse_from_format('m-d-Y', $dateStr);
        return $dateArray['year']==$anno?'selected':'';
    }
    
    public static function ListaAnni() {

        print "<select name='Anno'>";

        for ($anno = 2010; $anno <= 2030; $anno++) {
            print "<option value='" . $anno . "' ". self::AnnoInCorso($anno). ">";
            print "" . $anno . "";
            print "</option>\n";
        }

        print "</select>";
    }

    // Fine classe Database
}

