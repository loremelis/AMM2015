<!-- riportae tutto a questa pagina che sostituira progetto.php
staccare tutti i vari pezzi-->




<?php

include_once 'ViewDescriptor.php';
include_once basename(__DIR__) . '/../Settings.php';

//ciclo if isJson//

?>
<!DOCTYPE html>

<!--  

     Pagina master che contiene il layout dell'applicazione 
     carico le varie pagine a pezzi a seconda della zona del layout:
     -Header
     -content
     -right bar
     -footer
-->
<html>
    
<head>
        <meta charset="UTF-8">
        <title><?= $vd->getTitolo() ?></title>   <!-- fare la classe getTitolo -->
        <base href="<?= Settings::getApplicationPath() ?>php/"/> <!-- il tag base specifica il link della pagina -->
        <link rel="stylesheet" type="text/css" 
              href="../css/css.css" media="screen">
        
        <!-- valutare se abbiamo bisogno di un javascript-->
</head>
<body background="logo.jpg">  <!-- valutiamo se serve registrare il logo nella variabile e ripeterlo-->
    <div id="page">
        <header>
            <?php
                $header= $vd->getHeaderFile();  //$vd da implementare nel controller//
                require "$header";
             ?>
        </header>  <!-- aggiungere qualche cambio per client e seller e aggiungere il carrello-->
         
        <!-- Questo sarà il contenuto principale della pagina -->
        <div class="content">
            <?php
                $content = $vd->getContentFile(); // non è il $content del view Descriptor //
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
                <a href="http://jigsaw.w3.org/css-validator/check/referer" class="css" title="Questa pagina ha CSS validi">
                <abbr title="Cascading Style Sheets">CSS</abbr> Valido</a>
            
        </div>
   
     
        
        <?php
       
        ?>
         
</body>

</html>

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

