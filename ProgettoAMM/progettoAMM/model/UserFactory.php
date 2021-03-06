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
        $query= "SELECT * FROM clienti WHERE username=? and password=?";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
       
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
        $query= "SELECT * FROM venditore WHERE username=? and password=?";
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        
        if (!$stmt) {
            error_log("[loadUser] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        
        if (!$stmt->bind_param('ss', $username, $password)){
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
            
    //Carica un Cliente
    private function caricaClienteDaStmt(mysqli_stmt $stmt) {
        
        if (!$stmt->execute()) {
            error_log("[caricaClienteDaStmt] impossibile" . " eseguire lo statement");
            return null;
        }
        
        $row = array();
        $bind = $stmt->bind_result(
                $row['clienti_username'], 
                $row['clienti_password'],
                $row['clienti_nome'], 
                $row['clienti_cognome'],
                $row['clienti_email'],
                $row['clienti_numCivico'],
                $row['clienti_citta'],  
                $row['clienti_id'], 
                $row['clienti_cap'],
                $row['clienti_via']);
        
        
        
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
    
    //Carica un Venditore
    private function caricaVenditoreDaStmt(mysqli_stmt $stmt) {
        if (!$stmt->execute()) {
            error_log("[caricaVenditoreDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['venditore_username'], 
                $row['venditore_password'],
                $row['venditore_id']); 
        	
				
        if (!$bind) {
            error_log("[caricaVenditoreDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        if (!$stmt->fetch()){
            return null;
        }
        $stmt->close();
        return self::creaVenditoreDaArray($row);
    }
    

    // Restituisce la lista dei Clienti
    public function &getListaCLienti() {
        $clienti = array();
        $query = "SELECT * FROM clienti ";
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
                $query= "SELECT * FROM clienti WHERE id =\"$id\"";
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();

                    return null;
                }
                if (!$stmt->execute()) {      
                    error_log("[cercaUtentePerId] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();

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

                    return null;
                }
                if (!$stmt->execute()) {  
                    error_log("[loadUser] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();

                    return null;
                }
                $toRet = self::caricaVenditoreDaStmt($stmt);   
                $mysqli->close();
                return $toRet;
                break; 
            default:

                return null;
        }
    }

    // Crea un Cliente da una riga del db
    public function creaClienteDaArray($row) {
	    $cliente = new UserClient(
	    User::Cliente, 
	    $row['clienti_password'], 
	    $row['clienti_username'], 
	    $row['clienti_id'], 
	    $row['clienti_nome'], 
	    $row['clienti_cognome'], 
	    $row['clienti_via'], 
	    $row['clienti_numCivico'], 
	    $row['clienti_citta'], 
	    $row['clienti_cap'], 
	    $row['clienti_email']
		);

        return $cliente;
    }
    
    //Crea un Venditore da una riga del db
    public function creaVenditoreDaArray($row) {

       $venditore = new UserSeller(
       User::Venditore, 
       $row['venditore_password'],
       $row['venditore_username'], 
       $row['venditore_id']); 
       return $venditore;
    }

    //Salva i dati relativi ad un utente sul db
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
                $count = $this->salvaVenditore($user, $stmt); //fatta anche se non mi serve
        }
        $stmt->close();
        $mysqli->close();
        return $count;
    }
   
    //Rende persistenti le modifiche all'anagrafica di un cliente sul db
    private function salvaCliente(UserClient $c, mysqli_stmt $stmt) {
        $query = " UPDATE clienti SET 
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
        
        $name = $c->getNome();
        $cog = $c->getCognome();
        $ema = $c->getEmail(); 
        $num = $c->getNumCivico();
        $cit = $c->getCitta();
        $cap = $c->getCap();
        $via = $c->getVia();
        $ID2 = $c->getID2();
        if (!$stmt->bind_param('sssisssi',$name,$cog,$ema,$num,$cit,$cap,$via,$ID2)) {   
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