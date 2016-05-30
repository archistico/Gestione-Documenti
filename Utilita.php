<?php

// Converti le lettere accentate
function html($string) {
    return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
}

function GetTabellaDistribuzione() {
    try {

        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');

        //now output the data to a simple html table...
        print "<h3>Tabella Distribuzione</h3>";
        print "<table border=1 cellpadding=5>";
        print "<tr><td>Id</td><td>Tipologia</td><td>Numero</td><td>Anno</td><td>Codice</td><td>Dettaglio documento</td></tr>";
        $result = $db->query('SELECT * FROM Distribuzione ORDER BY Anno ASC, Tipologia ASC, Numero ASC');

        foreach ($result as $row) {
            print "<tr><td>" . $row['Id'] . "</td>";
            $t = new DistribuzioneTipologia($row['Tipologia']);
            print "<td>" . $t->GetTipologia() . "</td>";
            print "<td>" . $row['Numero'] . "</td>";
            print "<td>" . $row['Anno'] . "</td>";
            $num_padded = sprintf("%03d", $row['Numero']);
            print "<td>" . $row['Anno'] . "-" . $t->GetCodice() . "-" . $num_padded . "</td>";
            print "<td><a href=DistribuzioneDettaglioNuova.php?idDistribuzione=" . $row['Id'] . ">Aggiungi/Visualizza</a></td>";
            print "</tr>";
        }

        print "</table>";

        // close the database connection

        $db = NULL;
    } catch (PDOException $e) {

        print 'Exception : ' . $e->getMessage();
    }
}

function GetTabellaOpere() {
    try {

        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');
                
        //now output the data to a simple html table...
        print "<h3>Tabella Opere</h3>";
        print "<table border=1 cellpadding=5>";
        print "<tr><td>Id</td><td>Titolo</td><td>Prezzo</td></tr>";
        $result = $db->query('SELECT * FROM Opera ORDER BY Titolo');

        foreach ($result as $row) {
            print "<tr><td>" . $row['Id'] . "</td>";
            print "<td>" . $row['Titolo'] . "</td>";
            print "<td> &euro; " . $row['Prezzo'] . "</td>";
            print "</tr>";
        }

        print "</table>";

        // close the database connection

        $db = NULL;
    } catch (PDOException $e) {

        print 'Exception : ' . $e->getMessage();
    }
}

function GetTabellaDistribuzioneDettaglio($idDistribuzione) {
    try {

        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');
                
        //now output the data to a simple html table...
        print "<h3>Tabella Distribuzione dettaglio</h3>";
        print "<table border=1 cellpadding=5>";
        print "<tr><td>Id</td><td>Codice</td><td>Opera</td><td>Prezzo Unitario</td><td>Quantita</td><td>Sconto</td><td>Totale</td><td>Modifica</td></tr>";
        $result = $db->query('SELECT DistribuzioneDettaglio.id As IDdettaglio, DistribuzioneDettaglio.*, Distribuzione.*, Opera.* FROM DistribuzioneDettaglio, Distribuzione, Opera WHERE DistribuzioneDettaglio.fkDistribuzione = Distribuzione.Id AND DistribuzioneDettaglio.fkOpera = Opera.Id AND DistribuzioneDettaglio.fkDistribuzione = '.$idDistribuzione.' ORDER BY fkDistribuzione ASC');
        
        //DistribuzioneDettaglio (fkDistribuzione, fkOpera, quantita, sconto)

        $totaleDistribuzione = 0;

        foreach ($result as $row) {
            print "<tr><td>" . $row['IDdettaglio'] . "</td>";
            $num_padded = sprintf("%03d", $row['Numero']);
            print "<td>" . $row['Anno'] . "-" . Tipologia::GetCodice($row['Tipologia']) ."-". $num_padded . "</td>";
            print "<td>" . $row['Titolo'] . "</td>";
            print "<td>&euro; " . $row['Prezzo'] . "</td>";
            print "<td>" . $row['quantita'] . "</td>";
            print "<td>" . $row['sconto'] . "</td>";
            $prezzo = $row['Prezzo'];
            $quantita = $row['quantita'];
            $sconto =  1-$row['sconto']/100;
            $totale = $prezzo * $quantita * $sconto;
            $totale = round($totale*100)/100;
            $totaleDistribuzione += $totale;
            print "<td><strong>&euro; " . $totale . "</strong></td>";
            print "<td><a href=DistribuzioneDettaglioElimina.php?idDistribuzioneDettaglio=" . $row['IDdettaglio'] . "&idDistribuzione=".$idDistribuzione.">Elimina</a></td>";
            print "</tr>";
        }

        print "</table>";
        print "<h3>TOTALE: &euro; ".$totaleDistribuzione."</h3>";

        // close the database connection

        $db = NULL;
    } catch (PDOException $e) {

        print 'Exception : ' . $e->getMessage();
    }
}

function GetTabellaDistribuzioneDettaglioTotale() {
    try {

        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');

        //now output the data to a simple html table...
        print "<h3>Tabella Distribuzione dettaglio - Generale</h3>";
        print "<table border=1 cellpadding=5>";
        print "<tr><td>Id</td><td>Codice</td><td>Opera</td><td>Prezzo Unitario</td><td>Quantita</td><td>Sconto</td><td>Totale</td></tr>";
        $result = $db->query('SELECT DistribuzioneDettaglio.id As IDdettaglio, DistribuzioneDettaglio.*, Distribuzione.*, Opera.* FROM DistribuzioneDettaglio, Distribuzione, Opera WHERE DistribuzioneDettaglio.fkDistribuzione = Distribuzione.Id AND DistribuzioneDettaglio.fkOpera = Opera.Id ORDER BY Distribuzione.anno ASC, Distribuzione.tipologia ASC, Distribuzione.numero ASC');

        //DistribuzioneDettaglio (fkDistribuzione, fkOpera, quantita, sconto)

        $totaleDistribuzione = 0;
        $suddivisione = array();

        foreach ($result as $row) {
            print "<tr><td>" . $row['IDdettaglio'] . "</td>";
            $num_padded = sprintf("%03d", $row['Numero']);
            print "<td>" . $row['Anno'] . "-" . Tipologia::GetCodice($row['Tipologia']) ."-". $num_padded . "</td>";
            print "<td>" . $row['Titolo'] . "</td>";
            print "<td>&euro; " . $row['Prezzo'] . "</td>";
            print "<td>" . $row['quantita'] . "</td>";
            print "<td>" . $row['sconto'] . "</td>";
            $prezzo = $row['Prezzo'];
            $quantita = $row['quantita'];
            $sconto =  1-$row['sconto']/100;
            $totale = $prezzo * $quantita * $sconto;
            $totale = round($totale*100)/100;
            $totaleDistribuzione += $totale;
            if(isset($suddivisione[(string)$row['Anno']]))
                $suddivisione[(string)$row['Anno']]+=$totale;
            else
                $suddivisione[(string)$row['Anno']]=$totale;
            print "<td><strong>&euro; " . $totale . "</strong></td>";
            print "</tr>";
        }

        print "</table>";
        print "<h3>TOTALE: &euro; ".$totaleDistribuzione."</h3>";

        print "<h3>SUDDIVISIONE PER ANNI</h3>";
        foreach($suddivisione as $key => $value)
        {
            print "<p>".$key." - &euro; ". $value."</p>";
        }
        // close the database connection

        $db = NULL;
    } catch (PDOException $e) {

        print 'Exception : ' . $e->getMessage();
    }
}

function GetTabellaOperePiuVendute() {
    try {

        //open the database
        $db = new PDO('sqlite:helpbook.sqlite');
                
        //now output the data to a simple html table...
        print "<h3>Tabella Opere più vendute</h3>";
        print "<table border=1 cellpadding=5>";
        print "<tr><td>Titolo</td><td>Venduti</td><td>Conto deposito</td></tr>";
        $result =  $db->query('SELECT O.Titolo, D.Tipologia, DD.quantita FROM Distribuzione D, DistribuzioneDettaglio DD, Opera O WHERE O.Id=DD.fkOpera AND D.Id=DD.fkDistribuzione ORDER BY O.Titolo ASC');
        
        class OperaConteggio
        {
            public $titolo;
            public $venduti;
            public $contodeposito;
        }
        
        $conteggio = array();
        
        foreach ($result as $row) {
            if(!isset($conteggio[$row['Titolo']]))
            {
                $conteggio[$row['Titolo']] = new OperaConteggio();
                $conteggio[$row['Titolo']]->titolo = $row['Titolo'];
                $conteggio[$row['Titolo']]->venduti += 0;
                $conteggio[$row['Titolo']]->contodeposito += 0;
            }
            if($row['Tipologia']==1 || $row['Tipologia']==3){
                $conteggio[$row['Titolo']]->venduti += $row['quantita'];
            }
            if($row['Tipologia']==2){
                $conteggio[$row['Titolo']]->contodeposito += $row['quantita'];
            }
        }
        
        foreach ($conteggio as $row) {
            print "<td>" . $row->titolo . "</td>";
            print "<td>" . $row->venduti . "</td>";
            print "<td>" . $row->contodeposito . "</td>";
            print "</tr>";
            
        }
        print "</table>";


        // close the database connection

        $db = NULL;
    } catch (PDOException $e) {

        print 'Exception : ' . $e->getMessage();
    }
}