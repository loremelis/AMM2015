<form id="anagrafica" method="post" action="cliente/anagrafica<?= $vd->scriviToken('?')?>" >
            <h2> Inserire i dati del cliente</h2>
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" value="<?= $user->getNome() ?>"><br>
            
            <label for="cognome">Cognome</label>
            <input type="text" name="cognome" id="cognome" value="<?= $user->getCognome() ?>"/><br>
            
            <label for="data">Data di Nascita</label>
            <input type="date" name="data" id="data" value="<?= $user->getData() ?>" /><br>
            
            <input type="submit" value="Salva" id="salva1"/>
            
            <label for="via">Via o Piazza</label>
            <input type="text" name="via" id="via" value="<?= $user->getVia() ?>"/><br>
            
            <label for="numero">Numero Civico</label>
            <input type="number" name="numero" id="numero" value="<?= $user->getNumCivico() ?>"/><br>
            
            <label for="citta">Città</label>
            <input type="text" name="citta" id="citta" value="<?= $user->getCitta() ?>"/><br>
            
            <label for="cap">CAP</label>
            <input type="text" name="cap" id="cap" value="<?= $user->getCap() ?>"/><br>
            
            <input type="submit" value="Salva" id="salva2"/>
            
            <label for="email">E-mail</label>
            <input type="email" name="email" id="email" value="<?= $user->getEmail() ?>"/><br>
            
            <input type="submit" value="Salva" id="salva3"/>
            
            <!-- valutare se mettere nuova password -->
            <!-- valutare i diversi tipi di input -->
            
            
        </form>