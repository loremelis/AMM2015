 <div id="carrello"><a href="carrello.php">Carrello</a></div>
        
        <!-- Qua ci sarà tutto il codice per gestire gli ordini -->
        
        <table>
            <caption>Catalogo delle locandine</caption>
            <?php 
            $i = 0;
            foreach ($oggetti as $oggetto) {
            ?>
            <tr <?= $i % 2 == 0 ? 'class="alt-row"' : '' ?>>
                <td id="nome_loc"><?= $oggetto->getNameObj() ?></td>
                <td ><a href="img/fightclub.jpg"><?= $oggetto->getImage() ?></a></td>
                <td><?= $oggetto->getDescription() ?></td>
                <td><?= $oggetto->getPrice() ?></td>
                <td><?= $oggetto->getAmount() ?></td>
                <td><a href="cliente.php">Link</a></td> <!-- Aggiungere un qualcosa di statico per aggiungere al carrello -->
            </tr> 
              <?php
                $i++;
            }
            ?>
        </table> 
        