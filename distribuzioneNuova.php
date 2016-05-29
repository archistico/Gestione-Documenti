<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="utf-8">   
        <title>Helpbook - Test</title>
    </head>
    <body>
        <form name="formDati" action="distribuzioneAggiungi.php" method="get">        
            <?php
            define('CHARSET', 'UTF-8');
            define('REPLACE_FLAGS', ENT_COMPAT | ENT_XHTML);

            include 'Utilita.php';
            include 'Distribuzione.php';
            include 'DistribuzioneDettaglio.php';
            include 'Database.php';
           
            echo "<h2>Seleziona anno</h2>";
            Database::ListaAnni();
            
            echo "<h2>Seleziona tipologia</h2>";
            Database::ListaDistribuzioneTipologia();
            
            echo "<br/>";
            echo "<br/>";
            ?>              
            <button type="submit" > INSERISCI</button></br>
            <?php 
                GetTabellaDistribuzione();
            ?>
        </form>
    </body>
</html>

