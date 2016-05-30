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
        print "<tr><td>Id</td><td>Tipologia</td><td>Numero</td><td>Anno</td><td>Codice</td><td>Dettaglio</td></tr>";
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
        print "<tr><td>Id</td><td>Codice</td><td>Opera</td><td>Prezzo Unitario</td><td>Quantita</td><td>Sconto</td><td>Totale</td></tr>";
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
        print "<h3>Tabella Distribuzione dettaglio</h3>";
        print "<table border=1 cellpadding=5>";
        print "<tr><td>Id</td><td>Codice</td><td>Opera</td><td>Prezzo Unitario</td><td>Quantita</td><td>Sconto</td><td>Totale</td></tr>";
        $result = $db->query('SELECT DistribuzioneDettaglio.id As IDdettaglio, DistribuzioneDettaglio.*, Distribuzione.*, Opera.* FROM DistribuzioneDettaglio, Distribuzione, Opera WHERE DistribuzioneDettaglio.fkDistribuzione = Distribuzione.Id AND DistribuzioneDettaglio.fkOpera = Opera.Id ORDER BY fkDistribuzione ASC');

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