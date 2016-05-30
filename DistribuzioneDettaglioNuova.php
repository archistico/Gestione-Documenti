<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <title>Helpbook - Test</title>
</head>
<body>
<form name="formDati" action="DistribuzioneDettaglioAggiungi.php" method="get">
    <?php
    define('CHARSET', 'UTF-8');
    define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

    $idDistribuzione = $_GET["idDistribuzione"];
    
    include 'Utilita.php';
    include 'Distribuzione.php';
    include 'DistribuzioneDettaglio.php';
    include 'Database.php';

    echo "<h2>Seleziona opera</h2>";
    Database::SelectOpere();
    echo "<input type='hidden' name='idDistribuzione' value=".$idDistribuzione.">";

    echo "<h2>Seleziona quantità</h2>";
    echo "<input type='number' name='quantita' min=1 max=10000 value=1 required>";

    echo "<h2>Seleziona sconto</h2>";
    echo "<input type='number' name='sconto' min=0 max=100 step=0.01 value=30 required>";

    echo "<br/>";
    echo "<br/>";
    ?>
    <button type="submit" > INSERISCI</button></br>
    <?php
    GetTabellaDistribuzioneDettaglio($idDistribuzione);
    ?>
</form>
</body>
</html>

