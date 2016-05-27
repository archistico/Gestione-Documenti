<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 27/05/16
 * Time: 16.58
 */
include 'Documento.php';
include 'Distribuzione.php';


$date = new DateTime();
$dateStr = $date->format('m-d-Y');
$dateArray = date_parse_from_format('m-d-Y', $dateStr);
echo $dateArray['day']."-".$dateArray['month']."-".$dateArray['year'];
echo "<br/>";

$doc = new Documento(Tipologia::ContoDeposito, 2018);
$dis = new Distribuzione();
//$dis->CreaDB();
//$dis->Aggiungi($doc);

try {

    //open the database
    $db = new PDO('sqlite:helpbook.sqlite');
      
    //now output the data to a simple html table...
    print "<table border=1 cellpadding=5>";
    print "<tr><td>Id</td><td>Tipologia</td><td>Numero</td><td>Anno</td><td>Codice</td></tr>";
    $result = $db->query('SELECT * FROM Distribuzione');

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