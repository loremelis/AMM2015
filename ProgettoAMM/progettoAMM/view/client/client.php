 <div id="carrello"><a href="../index.php?page=client&subpage=carrello">Carrello</a></div>
 
<?php if (count($oggetti) > 0) { ?>
    <table id="tab_client">
            <caption>Catalogo delle locandine</caption>
        <thead>
            <tr>
                <th >Titolo</th>
                <th >Prezzo</th>
                <th >Descrizione</th>
                <th >Immagine</th>
                <th >Quantità</th>
                <th >Aggiungere al carrello</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            $c = 0;
            foreach ($oggetti as $oggetto) {
                    ?>
                    <tr <?= $c % 2 == 0 ? 'class="alt-row"' : '' ?>>
                        <td><?= $oggetto->getNameObj() ?></td>
                        <td><?= $oggetto->getPrice() ?></td>
                        <td><a href="recensioni/<?= $oggetto->getDescription() ?>">Leggi..</a></td>
                        <td><a href="../img/<?=$oggetto->getImage() ?>">Immagine</a></td>
                        <td><?= $oggetto->getAmount() ?></td>
                        <td><a href="../index.php?page=client&cmd=aggiungiCarrello&oggetto=<?=$c ?> ">Aggiungi</a></td>
                        
                    </tr>
                    <?php
                    $c++;
                    $i++;
            }
            ?>
        </tbody>
    </table>
<?php } else { ?>
    <p> Nessun oggetto disponibile </p>
<?php } ?>




        
        <!-- Qua ci sarà tutto il codice per gestire gli ordini 
        
        <table id="tab_client">
            <caption>Catalogo delle locandine</caption>
            <tr class="dispari">
                <td id="nome_loc" >Fight Club</td>
                <td ><a href="img/fightclub.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td><a href="../index.php?page=client&cmd=aggiungiCarrello">Link</a></td>
            </tr>
            <tr class="pari">
                <td id="nome_loc">The Lord of the Rings</td>
                <td><a href="img/lotr.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td><a href="../index.php?page=client&cmd=aggiungiCarrello">Link</a></td>
            </tr>
            <tr class="dispari">
                <td id="nome_loc">Star Wars</td>
                <td><a href="img/jason-palmer-epvi-montage-low-res-watermarked.jpg.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="../index.php?page=client&cmd=aggiungiCarrello">Link</a></td>
            </tr>
            <tr class="pari">
                <td id="nome_loc">Godfather</td>
                <td><a href="img/godfather.jpg.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="../index.php?page=client&cmd=aggiungiCarrello">Link</a></td>
            </tr>
            <tr class="dispari">
                <td id="nome_loc">The Departed</td>
                <td><a href="img/departed.jpg.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="../index.php?page=client&cmd=aggiungiCarrello">Link</a></td>
            </tr>
            <tr class="pari">
                <td id="nome_loc">2001 Space Odysey</td>
                <td><a href="img/2001.jpg">Immagine</a></td>
                <td>Descrizione</td>
                <td>Quantità</td>
                <td>prezzo</td>
                <td>
                    <a href="../index.php?page=client&cmd=aggiungiCarrello">Link</a></td>
            </tr>
            
        </table> -->
        