<?php

//Classe per la creazione di utenti Clienti e Venditori//
include_once 'Db.php';
include_once 'User.php';
include_once 'UserClient.php';
include_once 'UserSeller.php';

class UserFactory {
    
    private static $singleton;
    private function __constructor() {
    }
    /**
     * Restiuisce un singleton per creare utenti
     */
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UserFactory();
        }
        return self::$singleton;
    }
    
     // Carica un utente tramite username e password
     
    public function caricaUtente($username, $password) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[loadUser] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
        // cerco prima nella tabella clienti
        $query = "SELECT *
            FROM clienti 
            WHERE studenti.username = ? AND studenti.password = ?;";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        $cliente = self::caricaClienteDaStmt($stmt);
        if (isset($cliente)) {
            // ho trovato uno studente
            $mysqli->close();
            return $cliente;
        }
        // ora cerco il venditore
        $query = "SELECT*
               FROM venditore 
               WHERE venditore.username = ? AND venditore.password = ?;";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->bind_param('ss', $username, $password)) {
            error_log("[loadUser] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        $venditore = self::caricaVenditoreDaStmt($stmt);
        if (isset($venditore)) {
            // ho trovato un venditore
            $mysqli->close();
            return $venditore;
        }
    }
    
    /* non penso mi serva una lista di venditori
    public function &getListaVenditori() {
        $docenti = array();
        $query = "select 
               docenti.id docenti_id,
               docenti.nome docenti_nome,
               docenti.cognome docenti_cognome,
               docenti.email docenti_email,
               docenti.citta docenti_citta,
               docenti.cap docenti_cap,
               docenti.via docenti_via,
               docenti.provincia docenti_provincia,
               docenti.numero_civico docenti_numero_civico,
               docenti.ricevimento docenti_ricevimento,
               docenti.username docenti_username,
               docenti.password docenti_password,
               dipartimenti.id dipartimenti_id,
               dipartimenti.nome dipartimenti_nome
               
               from docenti 
               join dipartimenti on docenti.dipartimento_id = dipartimenti.id";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaDocenti] impossibile inizializzare il database");
            $mysqli->close();
            return $docenti;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaDocenti] impossibile eseguire la query");
            $mysqli->close();
            return $docenti;
        }
        while ($row = $result->fetch_array()) {
            $docenti[] = self::creaDocenteDaArray($row);
        }
        $mysqli->close();
        return $docenti;
    }  */
   
     // Restituisce la lista dei Clienti
     
    public function &getListaCLienti() {
        $clienti = array();
        $query = "SELECT * FROM studenti ";
        $mysqli = Db::getInstance()->connectDb();    
        if (!isset($mysqli)) {
            error_log("[getListaClienti] impossibile inizializzare il database");
            $mysqli->close();
            return $clienti;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaClienti] impossibile eseguire la query");
            $mysqli->close();
            return $clienti;
        }
        while ($row = $result->fetch_array()) {
            $clienti[] = self::creaClienteDaArray($row);
        }
        return $clienti;
    }
    
    
    // Cerca un Utente tramite l'id
    public function cercaUtentePerId($id, $role) {
        $intval = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intval)) {
            return null;
        }
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaUtentePerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        switch ($role) {
            case User::Cliente:
                $query = "SELECT *
                          FROM clienti 
                          WHERE studenti.id = ?";
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }
                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }
                return self::caricaClienteDaStmt($stmt);
                break;
            case User::Venditore:
                $query = "select *
               FROM venditore
               WHERE docenti.id = ?";
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    return null;
                }
                if (!$stmt->bind_param('i', $intval)) {
                    error_log("[loadUser] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    return null;
                }
                $toRet =  self::caricaVenditoreDaStmt($stmt);
                $mysqli->close();
                return $toRet;
                break;
            default: return null;
        }
    }
    // Crea un Cliente da una riga del db
    // Questa è TUTTA DA RIFARE
 
    public function creaClienteDaArray($row) {
        $cliente = new UserClient();
        $cliente->setID($row['clienti_id']);
        $cliente->setNome($row['clienti_nome']);
        $cliente->setCognome($row['clienti_cognome']);
        $cliente->setCitta($row['clienti_citta']);
        $cliente->setCap($row['clienti_cap']);
        $cliente->setVia($row['clienti_via']);
        $cliente->setEmail($row['clienti_email']);
        $cliente->setNumeroCivico($row['clienti_numero_civico']);
        $cliente->setRuolo(User::Cliente);
        $cliente->setUsername($row['clienti_username']);
        $cliente->setPassword($row['clienti_password']);
        
        return $cliente;
    }
    /**
     * Crea un docente da una riga del db
     NON PENSO MI SERVA 
     
    public function creaDocenteDaArray($row) {
        $docente = new Docente();
        $docente->setId($row['docenti_id']);
        $docente->setNome($row['docenti_nome']);
        $docente->setCognome($row['docenti_cognome']);
        $docente->setEmail($row['docenti_email']);
        $docente->setCap($row['docenti_cap']);
        $docente->setCitta($row['docenti_citta']);
        $docente->setVia($row['docenti_via']);
        $docente->setProvincia($row['docenti_provincia']);
        $docente->setNumeroCivico($row['docenti_numero_civico']);
        $docente->setRicevimento($row['docenti_ricevimento']);
        $docente->setRuolo(User::Docente);
        $docente->setUsername($row['docenti_username']);
        $docente->setPassword($row['docenti_password']);
        $docente->setDipartimento(DipartimentoFactory::instance()->creaDaArray($row));
        return $docente;
    }
    /**
     * Salva i dati relativi ad un utente sul db
     * // VEDERE SE MI SERVE PER INTERO

     */
    public function salva(User $user) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salva] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }
        $stmt = $mysqli->stmt_init();
        $count = 0;
        switch ($user->getRuolo()) {
            case User::Studente:
                $count = $this->salvaCliente($user, $stmt);
                break;
            case User::Docente:
                $count = $this->salvaVenditore($user, $stmt);   //NON PENSO DI AVERNE BISOGNO
        }
        $stmt->close();
        $mysqli->close();
        return $count;
    }
    /**
     * Rende persistenti le modifiche all'anagrafica di un cliente sul db
     */
    private function salvaCliente(Cliente $c, mysqli_stmt $stmt) {
        $query = " update clienti set 
                    password = ?,
                    nome = ?,
                    cognome = ?,
                    email = ?,
                    numero_civico = ?,
                    citta = ?,
                    cap = ?,
                    via = ?
                    where clienti.id = ?
                    ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaCliente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }
        if (!$stmt->bind_param('ccccicici', $c->getPassword(), $c->getNome(), $c->getCognome(), $c->getEmail(), $c->getNumCivico(), $c->getCitta(),$c->getCap(), $c->getVia(), $c->getId())) {
            error_log("[salvaCliente] impossibile" .
                    " effettuare il binding in input");
            return 0;
        }
        if (!$stmt->execute()) {
            error_log("[caricaIscritti] impossibile" .
                    " eseguire lo statement");
            return 0;
        }
        return $stmt->affected_rows;
    }
    
    /**
     * Rende persistenti le modifiche all'anagrafica di un docente sul db
     * @param Docente $d il docente considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     NON PENSO DI AVERNE BISOGNO
    private function salvaDocente(Docente $d, mysqli_stmt $stmt) {
        $query = " update docenti set 
                    password = ?,
                    nome = ?,
                    cognome = ?,
                    email = ?,
                    citta = ?,
                    provincia = ?,
                    cap = ?,
                    via = ?,
                    ricevimento = ?,
                    numero_civico = ?,
                    dipartimento_id = ?
                    where docenti.id = ?
                    ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaStudente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }
        if (!$stmt->bind_param('sssssssssiii', 
                $d->getPassword(), 
                $d->getNome(), 
                $d->getCognome(), 
                $d->getEmail(), 
                $d->getCitta(),
                $d->getProvincia(),
                $d->getCap(), 
                $d->getVia(), 
                $d->getRicevimento(),
                $d->getNumeroCivico(), 
                $d->getDipartimento()->getId(),
                $d->getId())) {
            error_log("[salvaStudente] impossibile" .
                    " effettuare il binding in input");
            return 0;
        }
        if (!$stmt->execute()) {
            error_log("[caricaIscritti] impossibile" .
                    " eseguire lo statement");
            return 0;
        }
        return $stmt->affected_rows;
    }
    
     * Carica un docente eseguendo un prepared statement
     * @param mysqli_stmt $stmt
     * @return null
     */
    private function caricaVenditoreDaStmt(mysqli_stmt $stmt) {
        if (!$stmt->execute()) {
            error_log("[caricaVenditoreDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['venditore_id'], 
                $row['venditore_username'], 
                $row['venditore_password']); 
        if (!$bind) {
            error_log("[caricaVenditoreDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        if (!$stmt->fetch()) {
            return null;
        }
        $stmt->close();
        return self::creaVenditoreDaArray($row);
    }
    
     //Carica un Cliente eseguendo un prepared statement

    private function caricaClienteDaStmt(mysqli_stmt $stmt) {
        if (!$stmt->execute()) {
            error_log("[caricaClienteDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['clienti_id'], $row['clienti_nome'], $row['clienti_cognome'],$row['clienti_email'], 
                $row['clienti_citta'], $row['clienti_via'], $row['clienti_cap'],$row['clienti_numero_civico'], 
                $row['clienti_username'], $row['clienti_password']);
        if (!$bind) {
            error_log("[caricaClienteDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        if (!$stmt->fetch()) {
            return null;
        }
        $stmt->close();
        return self::creaClienteDaArray($row);
    }
}
?>