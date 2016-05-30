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

$tipologia = $_GET["idTipologia"];
$anno = $_GET["Anno"];

if(!empty($anno) || !empty($tipologia))
{
    // CREA IL DOCUMENTO
    $dis = new Distribuzione($tipologia, $anno);
}
else
{
    print "<h2>Dati passati non validi</h2>";
    die();
}
if($dis->Aggiungi()) {
    print "<h2>Elemento inserito correttamente</h2>";
}
else
{
    print "<h2>Attenzione errore</h2>";
}

GetTabellaDistribuzione();