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

$IdDistribuzione = $_GET["idDistribuzione"];
 
if(!empty($IdDistribuzione))
{
    // CREA IL DOCUMENTO
    $dis = new Distribuzione(0,0);
}
else
{
    print "<h2>Dati passati non validi</h2>";
    die();
}
if($dis->Elimina($IdDistribuzione)) { 
    print "<h2>Elemento eliminato correttamente</h2>";
}
else
{
    print "<h2>Attenzione errore</h2>";
}
echo "<br/><a href='index.php'>TORNA INDIETRO</a>";