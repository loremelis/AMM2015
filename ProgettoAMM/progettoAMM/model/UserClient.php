<?php

class UserClient extends User {
   
	
    private $nome;

    private $cognome;
   
    private $via;
   
    private $numCivico;

    private $citta;

    private $cap;
    
    private $email;


    // Costruttore
    
    public function __construct($ruolo, $password, $username, $ID, $nome, $cognome, $via, $numCivico, $citta, $cap, $email) {
        
        parent::__construct($ruolo, $password, $username, $ID);
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->via = $via;
        $this->numCivico = $numCivico;
        $this->citta = $citta;
        $this->cap = $cap;
        $this->email = $email;
		$this->ID=$ID;
        
        
    }
    
    
    public function getID2(){
    	
        return $this->ID;
    }
    
    public function getNome(){
        return $this->nome;
    }
    public function setNome($nome){
        $this->nome=$nome;
        return true;
    }
    
    public function getCognome(){
        return $this->cognome;
    }
    public function setCognome($Cognome){
        $this->cognome=$Cognome;
        return true;
    }
    
    public function getVia(){
        return $this->via;
    }
    public function setVia($via){
        $this->via=$via;
        return true;
    }
    
    public function getNumCivico(){
        return $this->numCivico;
    }
    public function setNumCivico($numCivico) {
        $intVal = filter_var($numCivico, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (isset($intVal)) {
            $this->numCivico = $intVal;
            return true;
        }
        return false;
    }
    
    public function getCitta(){
        return $this->citta;
    }
    public function setCitta($citta){
        $this->citta=$citta;
        return true;
    }
    
    public function getCap(){
        return $this->cap;
    }
    public function setCap($cap) {                  //Il cap è formato da 5 numeri da 0 a 9 //
        if (!filter_var($cap, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/[0-9]{5}/')))) {
            return false;
        }
        $this->cap = $cap;
        return true;
    }
    
    public function getEmail(){
        return $this->email;
    }
     public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $this->email = $email;
        return true;
    }
}

?>