<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">   
        <title>Helpbook - Test</title>
    </head>
    <body>

<?php

define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

include 'Utilita.php';
include 'Documento.php';
include 'Distribuzione.php';
include 'DistribuzioneDettaglio.php';

$date = new DateTime();
$dateStr = $date->format('m-d-Y');
$dateArray = date_parse_from_format('m-d-Y', $dateStr);
echo $dateArray['day']."-".$dateArray['month']."-".$dateArray['year'];
echo "<br/>";

// CREA IL DOCUMENTO
$doc = new Documento(Tipologia::Ricevuta, 2016);
$dis = new Distribuzione();
//$dis->CreaDB();
//$dis->Aggiungi($doc);

// CREA L'OPERA
$opera = new Opera('Due non è il doppio', 18.40);
//$opera->CreaDB();
$opera->Aggiungi();
echo $opera->GetID();
echo "<br/>";
echo $opera->GetTitolo();

// CREA IL DETTAGLIO
$disdet = new DistribuzioneDettaglio(23,2,2,35.5);
//$disdet->CreaDB();
//$disdet->Aggiungi($disdet);

try {

    //open the database
    $db = new PDO('sqlite:helpbook.sqlite');
      
    //now output the data to a simple html table...
    print "<table border=1 cellpadding=5>";
    print "<tr><td>Id</td><td>Tipologia</td><td>Numero</td><td>Anno</td><td>Codice</td></tr>";
    $result = $db->query('SELECT * FROM Distribuzione ORDER BY Anno ASC, Tipologia ASC, Numero ASC');

    foreach ($result as $row) {
        print "<tr><td>" . $row['Id'] . "</td>";
        $t = new TipologiaDocumento($row['Tipologia']);
        print "<td>" . $t->GetTipologia() . "</td>";
        print "<td>" . $row['Numero'] . "</td>";
        print "<td>" . $row['Anno'] . "</td>";
        $num_padded = sprintf("%03d", $row['Numero']);
        print "<td>" . $row['Anno'] . "-" . $t->GetCodice() . "-" . $num_padded . "</td>";
        print "</tr>";
    }

    print "</table>";

    // close the database connection

    $db = NULL;
} catch (PDOException $e) {

    print 'Exception : ' . $e->getMessage();
}

?>
    </body>
</html>