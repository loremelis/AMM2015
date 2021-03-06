<?php

//classe che mi serve per definire il ruolo di Cliente o Venditore

class User {
    
    //Costanti che definiscono il ruolo di Venditore e Cliente
    
    const Venditore = 1;
   
    const Cliente = 2;

    protected $ruolo;
  
    protected $password;
    
    protected $username;
  
    protected $ID;


    public function __construct($ruolo, $password, $username, $ID) {
        
        $this->ruolo = $ruolo;
        $this->password = $password;
        $this->username = $username;
        $this->ID = $ID;
    }
    
    public function getRuolo() {
        return $this->ruolo;
    }
   
    public function setRuolo($ruolo) {
        switch ($ruolo) {
            case self::Venditore:
            case self::Cliente:
                $this->ruolo = $ruolo;
                return true;
            default:
                return false;
        }
    }
    
    public function getID2(){
        return $this->ID;
    }
    public function setID($ID){
        $intVal = filter_var($ID, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(!isset($intVal)){
            return false;
        }
        $this->ID = $intVal;
    }

    
    public function getUsername(){      
        return $this->username;
    }
    public function setUsername($username) {

        if (!filter_var($username, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[a-zA-Z]{5,}/')))) {
            return false;
        }
        $this->username = $username;
        return true;
    }
    
    public function getPassword(){
        return $this->password;
    }
    public function setPassword($password){
        $this->password=$password;
        return true;    //restituisce true se la password è giusta //
    }
    
    //Verifica che l'utente esista per il sistema
    public function esiste() {
        
        return isset($this->ruolo);
    }
}

?>
