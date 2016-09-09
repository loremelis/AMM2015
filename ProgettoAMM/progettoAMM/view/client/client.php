 <!-- Aggiungere codice ajax per modificare il carrello con un numero che indichi quanti oggetti contiene -->
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
                        <td><a href="..index.php?page=client&subpage=recensioni&oggetto<?=$c?> ">Leggi..</a></td>
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

