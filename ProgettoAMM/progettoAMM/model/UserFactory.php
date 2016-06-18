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
        $query= "SELECT * FROM clienti WHERE username=\"$username\"AND password=\"$password\";";
        
            
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log("[loadUser] impossibile" . " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        
        if (!$stmt->execute()) {   ////bind_param('ss', $username, $password))
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
        $query= "SELECT * FROM venditore WHERE username=\"$username\"AND password=\"$password\";";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->execute()) {     //bind_param('ss', $username, $password))
            error_log("[loadUser] impossibile" . " effettuare il binding in input");
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
            
    //Carica un Cliente eseguendo un prepared statement
    private function caricaClienteDaStmt(mysqli_stmt $stmt) {
        
        if (!$stmt->execute()) {
            printf("1");
            error_log("[caricaClienteDaStmt] impossibile" . " eseguire lo statement");
            return null;
        }
        printf("2");
        $row = array();
        $bind = $stmt->get_result(); /*bind_result(
                $row['id'], $row['nome'], $row['cognome'],$row['email'], 
                $row['citta'], $row['via'], $row['cap'],$row['numCivico'], 
                $row['username'], $row['password']);
           
         */
        if (!$bind) {
            printf("3");
            error_log("[caricaClienteDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        if (!$stmt) {     //->fetch()
            printf("4");
            return null;
        }
        printf("5");
        $stmt->close();
        return self::creaClienteDaArray($row);
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
                $row['id'], 
                $row['username'], 
                $row['password']); 
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
            printf("a7");
                exit();
            return null;
        }
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaUtentePerId] impossibile inizializzare il database");
            $mysqli->close();
            printf("aa6");
                exit();
            return null;
        }
        switch ($role) {
            case User::Cliente:
                $query= "SELECT * FROM clienti WHERE id =\"$id\";";
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    printf("aa5");
                exit();
                    return null;
                }
                if (!$stmt->execute()) {      //ho cambiato bind_param('i', $intval)
                    error_log("[cercaUtentePerId] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    printf("aa3");
                exit();
                    return null;
                }
                return self::caricaClienteDaStmt($stmt);  
                break;
            case User::Venditore:
                $query= "SELECT * FROM venditore WHERE id =\"$id\";";
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();
                    printf("aa2");
                exit();
                    return null;
                }
                if (!$stmt->execute()) {  //ho cambiato bind_param('i', $intval)
                    error_log("[loadUser] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();
                    printf("aa1");
                exit();
                    return null;
                }
                $toRet = self::caricaVenditoreDaStmt($stmt);   
                $mysqli->close();
                return $toRet;
                break;
            default:
                printf("aa");
                exit();
                return null;
        }
    }

    // Crea un Cliente da una riga del db
    public function creaClienteDaArray($row) {
        $cliente = new UserClient();
        $cliente->setID($row['id']);
        $cliente->setNome($row['nome']);
        $cliente->setCognome($row['cognome']);
        $cliente->setCitta($row['citta']);
        $cliente->setCap($row['cap']);
        $cliente->setVia($row['via']);
        $cliente->setEmail($row['email']);
        $cliente->setNumCivico($row['numCivico']);
        $cliente->setRuolo(User::Cliente);
        $cliente->setUsername($row['username']);
        $cliente->setPassword($row['password']);
        
        return $cliente;
    }
    
    //Crea un Venditore
    public function creaVenditoreDaArray($row) {
        $venditore = new UserSeller();
        $venditore->setID($row['id']);
        $venditore->setRuolo(User::Venditore);
        $venditore->setUsername($row['username']);
        $venditore->setPassword($row['password']);
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
            case User::Cliente:
                $count = $this->salvaCliente($user, $stmt);
                break;
            case User::Venditore:
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

}
?>