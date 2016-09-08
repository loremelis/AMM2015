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
<body background="../img/logo.jpg">  
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
   
      
            
                <a href="http://validator.w3.org/check/referer" class="xhtml" title="Questa pagina contiene HTML valido">
                        <img style="border:0;width:70px;height:20px" src="https://www.w3.org/Icons/valid-html401-blue" alt="HTML Valido!" />
                </a>
                <a href="https://jigsaw.w3.org/css-validator/check/referer" class="css" title="Questa pagina ha CSS validi">
                        <img style="border:0;width:70px;height:20px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="CSS Valido!" />
                </a>
                        
            
    </footer>
    </div>
         
</body>

</html>

