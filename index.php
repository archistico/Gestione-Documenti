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
include 'Distribuzione.php';
include 'DistribuzioneDettaglio.php';

$date = new DateTime();
$dateStr = $date->format('m-d-Y');
$dateArray = date_parse_from_format('m-d-Y', $dateStr);
echo $dateArray['day']."-".$dateArray['month']."-".$dateArray['year'];
echo "<br/>";

// CREA IL DOCUMENTO
$dis = new Distribuzione(Tipologia::Ricevuta, 2016);
//$dis->CreaDB();
//$dis->Aggiungi();

// CREA L'OPERA
$opera = new Opera('Il musicista', 14.5);
//$opera->CreaDB();
//$opera->Aggiungi();

// CREA IL DETTAGLIO
$disdet = new DistribuzioneDettaglio($dis->GetIDbyDistribuzione(Tipologia::Fattura, 4,2016),$opera->GetID(),2,35.5);
$disdet->CreaDB();
$disdet->Aggiungi($disdet);

GetTabellaDistribuzione();

?>
    </body>
</html>