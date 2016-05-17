<?php

//Classe per la creazione di utenti Clienti//
include_once 'UserClient.php';
include_once 'UserSeller'

class UserFactory {
    
    private static $singleton;
    private function __constructor() {
        
    }
    
    
    //Restituisce un singleton per creare utenti//
    public static function instance() {
        if (!isset(self::$singleton)) {
            self::$singleton = new UserClientFactory();
        }
        return self::$singleton;
    }
    
    //Carica un cliente tramite un username e una password//
    public function caricaCliente($username, $password) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[loadUser] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        
     //cerco il cliente//
        $query = "select clienti.id clienti_id,
            clienti.nome clienti_nome,
            clienti.cognome clienti_cognome,
            clienti.matricola clienti_matricola,
            clienti.email clienti_email,
            clienti.citta clienti_citta,
            clienti.via clienti_via,
            clienti.cap clienti_cap,
            clienti.numero_civico clienti_numero_civico,
            clienti.username clienti_username,
            clienti.password clienti_password,
            
            from clienti 
            where clienti.username= ? and clienti.password= ?";
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
        $cliente = self::caricaClientiDaStmt($stmt);
        if (isset($cliente)) {
            // ho trovato un cliente
            $mysqli->close();
            return $cliente;
        }
        
        
    
    
    
    
    
    
    /**
     * Crea un cliente da una riga del db
     *
     */
    public function creaClienteDaArray($row) {
        $cliente = new Cliente();
        $cliente->setId($row['clienti_id']);
        $cliente->setNome($row['clienti_nome']);
        $cliente->setCognome($row['clienti_cognome']);
        $cliente->setCitta($row['clienti_citta']);
        $cliente->setCap($row['clienti_cap']);
        $cliente->setVia($row['clienti_via']);
        $cliente->setEmail($row['clienti_email']);
        $cliente->setNumeroCivico($row['clienti_numero_civico']);
        $cliente->setUsername($row['clienti_username']);

        return $studente;
    }
    
    /**
     * Salva i dati relativi ad un utente sul db
     * 
     */
    
    //Da valutare//
    public function salva(User $user) {
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salva] impossibile inizializzare il database");
            $mysqli->close();
            return 0;
        }
        $stmt = $mysqli->stmt_init();
        $count = $this->salvaCliente($user, $stmt);
      
        $stmt->close();
        $mysqli->close();
        return $count;
    }
    
    
    
    /**
     * Rende persistenti le modifiche all'anagrafica di uno studente sul db
     * @param Studente $s lo studente considerato
     * @param mysqli_stmt $stmt un prepared statement
     * @return int il numero di righe modificate
     */
    private function salvaStudente(Studente $s, mysqli_stmt $stmt) {
        $query = " update studenti set 
                    password = ?,
                    nome = ?,
                    cognome = ?,
                    email = ?,
                    numero_civico = ?,
                    citta = ?,
                    provincia = ?,
                    matricola = ?,
                    cap = ?,
                    via = ?
                    where studenti.id = ?
                    ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaStudente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }
        if (!$stmt->bind_param('ssssississi', $s->getPassword(), $s->getNome(), $s->getCognome(), $s->getEmail(), $s->getNumeroCivico(), $s->getCitta(), $s->getProvincia(), $s->getMatricola(), $s->getCap(), $s->getVia(), $s->getId())) {
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
    
    /**
     * Rende persistenti le modifiche all'anagrafica di uno cliente sul db
     * 
     */
    private function salvaClient(Studente $s, mysqli_stmt $stmt) {
        $query = " update clienti set 
                    password = ?,
                    nome = ?,
                    cognome = ?,
                    email = ?,
                    numero_civico = ?,
                    citta = ?,
                    cap = ?,
                    via = ?
                    where studenti.id = ?
                    ";
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[salvaCliente] impossibile" .
                    " inizializzare il prepared statement");
            return 0;
        }
        if (!$stmt->bind_param('ssssississi', $s->getPassword(), $s->getNome(), $s->getCognome(), $s->getEmail(), $s->getNumeroCivico(), $s->getCitta(), $s->getCap(), $s->getVia(), $s->getId())) {
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
     * Carica uno studente eseguendo un prepared statement
     * 
     */
    private function caricaClienteDaStmt(mysqli_stmt $stmt) {
        if (!$stmt->execute()) {
            error_log("[caricaStudenteDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['clienti_id'], $row['clienti_nome'], $row['clienti_cognome'], $row['clienti_email'], $row['clienti_citta'], $row['clienti_via'], $row['clienti_cap'], $row['clienti_numero_civico'], $row['clienti_username'], $row['clienti_password']);
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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

