<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// RECUPERO DATI E AGGIUNGO
define('CHARSET', 'UTF-8');
define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

include 'Utilita.php';
include 'Distribuzione.php';
include 'DistribuzioneDettaglio.php';

$idDistribuzione = $_GET["idDistribuzione"];
$idOpera = $_GET["idOpera"];
$quantita = $_GET["quantita"];
$sconto = $_GET["sconto"];

if(!empty($idDistribuzione) || !empty($idOpera) || !empty($quantita) || !empty($sconto))
{
    // CREA IL DOCUMENTO
    $disdet = new DistribuzioneDettaglio($idDistribuzione, $idOpera, $quantita, $sconto);
}
else
{
    print "<h2>Dati passati non validi</h2>";
    die();
}
if($disdet->Aggiungi()) {
    print "<h2>Elemento inserito correttamente</h2>";
}
else
{
    print "<h2>Attenzione errore</h2>";
}
echo "<br/><a href='DistribuzioneDettaglioNuova.php?idDistribuzione=".$idDistribuzione."'>TORNA INDIETRO</a>";