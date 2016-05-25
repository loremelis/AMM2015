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
    
    // Restiuisce un singleton per creare utenti

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
                  WHERE studenti.username = ?";
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        printf($query);
        if (!$stmt) {
            error_log("[loadUser] impossibile" . " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->bind_param('ss',$username, $password)) {
            error_log("[loadUser] impossibile" . " effettuare il binding in input");
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
        $query = "SELECT *
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
   
    // Restituisce la lista dei Clienti
    // $clienti
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
            $clienti[] = self::creaClienteDaArray($row);   //DA VALUTARE
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
                          WHERE clienti.id = ?";
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
                return self::caricaClienteDaStmt($stmt);  //DA VALUTARE
                break;
            case User::Venditore:
                $query = "SELECT *
                          FROM venditore
                          WHERE venditore.id = ?";
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
                $toRet = self::caricaVenditoreDaStmt($stmt);   //DA VALUTARE
                $mysqli->close();
                return $toRet;
                break;
            default: return null;
        }
    }
    
    // Crea un Cliente da una riga del db
    public function creaClienteDaArray($row) {
        $cliente = new UserClient();
        $cliente->setID($row['clienti_id']);
        $cliente->setNome($row['clienti_nome']);
        $cliente->setCognome($row['clienti_cognome']);
        $cliente->setCitta($row['clienti_citta']);
        $cliente->setCap($row['clienti_cap']);
        $cliente->setVia($row['clienti_via']);
        $cliente->setEmail($row['clienti_email']);
        $cliente->setNumCivico($row['clienti_numCivico']);
        $cliente->setRuolo(User::Cliente);
        $cliente->setUsername($row['clienti_username']);
        $cliente->setPassword($row['clienti_password']);
        
        return $cliente;
    }
    
    //Crea un Venditore
    public function creaVenditoreDaArray($row) {
        $venditore = new UserSeller();
        $venditore->setID($row['venditore_id']);
        $venditore->setRuolo(User::Docente);
        $venditore->setUsername($row['venditore_username']);
        $venditore->setPassword($row['venditore_password']);
        return $venditore;
    }

    //Salva i dati relativi ad un utente sul db
    // VEDERE SE MI SERVE PER INTERO
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
   
    //Rende persistenti le modifiche all'anagrafica di un cliente sul db
    private function salvaCliente(Cliente $c, mysqli_stmt $stmt) {
        $query = " UPDATE clienti SET 
                    password = ?,
                    nome = ?,
                    cognome = ?,
                    email = ?,
                    numCivico = ?,
                    citta = ?,
                    cap = ?,
                    via = ?
                    where clienti.id = ? ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaCliente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }
        if (!$stmt->bind_param('ccccicici', $c->getPassword(), $c->getNome(), 
                $c->getCognome(), $c->getEmail(), $c->getNumCivico(), 
                $c->getCitta(),$c->getCap(), $c->getVia(), $c->getID())) {   //NON PRENDE GetID
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
    
  
    //Carica un Venditore eseguendo un prepared statement
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
            error_log("[caricaClienteDaStmt] impossibile" . " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['clienti_id'], $row['clienti_nome'], $row['clienti_cognome'],$row['clienti_email'], 
                $row['clienti_citta'], $row['clienti_via'], $row['clienti_cap'],$row['clienti_numCivico'], 
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