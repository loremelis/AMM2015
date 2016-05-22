<!-- riportae tutto a questa pagina che sostituira progetto.php
staccare tutti i vari pezzi-->

<?php

include_once 'ViewDescriptor.php';
include_once 'Settings.php';

//ciclo if isJson//

?>
<!DOCTYPE html>

<!--  

     Pagina master che contiene il layout dell'applicazione 
     carico le varie pagine a pezzi a seconda della zona del layout:
     -Header
     -content
     -footer
-->
<html>
    
<head>
        <meta charset="UTF-8">
        <title><?= $vd->getTitolo() ?></title>   <!-- fare la classe getTitolo -->
        <base href="<?= Settings::getApplicationPath() ?>php/"/> 
        <link rel="stylesheet" type="text/css" 
              href="../css/css.css" media="screen">
        
        <!-- valutare se abbiamo bisogno di un javascript-->
</head>
<body background="logo.jpg">  
    <div id="page">
        <header>
            <?php
                $header= $vd->getHeaderFile();  
                require "$header";
             ?>
        </header>  <!-- aggiungere qualche cambio per client e seller e aggiungere il carrello-->
         
        <!-- Questo sarà il contenuto principale della pagina -->
        <div class="content">
           <?php
                    if ($vd->getMessaggioErrore() != null) {
                        ?>
                        <div class="errore">   <!-- DA FARE -->
                            <div>
                                <?=
                                $vd->getMessaggioErrore();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    if ($vd->getMessaggioConferma() != null) {
                        ?>
                        <div class="conferma">    <!-- DA FARE -->
                            <div>
                                <?=
                                $vd->getMessaggioConferma();
                                ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                    <?php
                    $content = $vd->getContentFile();
                    require "$content";
                    ?>

        </div>

    <footer> 
        <?php
                $footer = $vd->getFooterFile(); 
                require "$footer";
             ?>
    </footer>
        
        
        
        <div class="validator">
            
                <a href="http://validator.w3.org/check/referer" class="xhtml" title="Questa pagina contiene HTML valido">
                <abbr title="eXtensible HyperText Markup Language">HTML</abbr> Valido</a>
                <a href="http://jigsaw.w3.org/css/check/referer" class="css" title="Questa pagina ha CSS validi">
                <abbr title="Cascading Style Sheets">CSS</abbr> Valido</a>
            
        </div>
    </div>
         
</body>

</html>

