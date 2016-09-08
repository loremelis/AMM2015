<form id="inserzione" action="../index.php?page=seller&cmd=aggiungiOggetto">
            <h2> Inserire l'elemento da aggiungere al catalogo</h2>
            <label for="nome_ogg">Nome oggetto</label>
            <input type="text" name="nome_ogg" id="nome_ogg"/><br>
            
            <label for="foto_ogg">URL immagine</label>
            <input type="file" name="foto_ogg" id="foto_ogg"/><br>
            
            <label for="prezzo_ogg">Prezzo</label>
            <input type="number" name="prezzo_ogg" id="prezzo_ogg"/><br>
            
            <label for="quantita_ogg">Quantità di oggetto disponibili</label>
            <select size="1" name="quantita_ogg" id="quantita_ogg">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
            </select><br>
            
            <label for="descrizione_ogg">Descrizione del film</label>
            <textarea name="descrizione_ogg" id="descrizione_ogg" rows="10">Descrizione</textarea><br>
            
            <input type="submit" value="Inserisci" id="inserire_ogg"/>
        </form>
