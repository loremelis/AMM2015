 <div id="contenuto_carrelllo"> 
            <h2>Prezzo totale: <!--codice per calcolare il totale--> </h2>
            <!-- Tasto per procedere all'aquisto -->
        
            <table id="table_carrello">
                <caption>Contentuto del tuo carrello</caption>
                <?php
                 $i = 0;
                 $c = 0;
                 foreach ($carrelli as $carrello) {
                ?>
                    <tr <?= $c % 2 == 0 ? 'class="alt-row"' : '' ?>>
                        <td><?= $carrello->getTitolo() ?></td>
                        <td><?= $carrello->getAmount() ?></td>
                        <td><a href="../index.php?page=client&cmd=cancella&carrello=<?=$c ?> ">Cancella</a></td>
                        
                    </tr>
                    <?php
                    $c++;
                    $i++;
            }
            ?>
            </table>
        </div>

<!-- aggiungere qualcosa di dinamico che cambi la tabella man mano che si aggiungono titoli -->

