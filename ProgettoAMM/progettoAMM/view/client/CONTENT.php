
<?php
switch ($vd->getSottoVista()) {
    case 'cliente':
        include_once 'cliente.php';
        break;
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;
    case 'carrello':
        include_once 'carrello.php';
        break;
    default:
        
        ?>
        <div id="carrello"><a href="carrello.php">Carrello</a></div>
        
        <!-- Qua ci sarà tutto il codice per gestire gli ordini -->
        
        <table id="tab_client">
            <caption>Catalogo delle locandine</caption>
            <tr class="dispari">
                <td id="nome_loc" >Fight Club</td>
                <td ><a href="img/fightclub.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td><a href="cliente.php">Link</a></td>
            </tr>
            <tr class="pari">
                <td id="nome_loc">The Lord of the Rings</td>
                <td><a href="img/lotr.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="cliente.php">Link</a></td>
            </tr>
            <tr class="dispari">
                <td id="nome_loc">Star Wars</td>
                <td><a href="img/jason-palmer-epvi-montage-low-res-watermarked.jpg.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="cliente.php">Link</a></td>
            </tr>
            <tr class="pari">
                <td id="nome_loc">Godfather</td>
                <td><a href="img/godfather.jpg.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="cliente.php">Link</a></td>
            </tr>
            <tr class="dispari">
                <td id="nome_loc">The Departed</td>
                <td><a href="img/departed.jpg.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="cliente.php">Link</a></td>
            </tr>
            <tr class="pari">
                <td id="nome_loc">2001 Space Odysey</td>
                <td><a href="img/2001.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="cliente.php">Link</a></td>
            </tr>
            
        </table>
        <?php
        break;
}
?>

