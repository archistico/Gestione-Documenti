<?php

// Converti le lettere accentate
function html($string) {
    return htmlspecialchars($string, REPLACE_FLAGS, CHARSET);
}

function GetTabellaDistribuzione(){
    try {

    //open the database
    $db = new PDO('sqlite:helpbook.sqlite');
      
    //now output the data to a simple html table...
    print "<table border=1 cellpadding=5>";
    print "<tr><td>Id</td><td>Tipologia</td><td>Numero</td><td>Anno</td><td>Codice</td></tr>";
    $result = $db->query('SELECT * FROM Distribuzione ORDER BY Anno ASC, Tipologia ASC, Numero ASC');

    foreach ($result as $row) {
        print "<tr><td>" . $row['Id'] . "</td>";
        $t = new DistribuzioneTipologia($row['Tipologia']);
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
}