<?php

// Aggiungere ruolo a questa classe e alla classe Seller 

class UserClient{
    
    private $ID;
    
    private $username;
    
    private $password;

    private $nome;

    private $cognome;
    
    private $data;
   
    private $via;
   
    private $numCivico;

    private $citta;

    private $cap;
    
    private $email;
    
    private $ruolo;

    /**
     * Costruttore
     */
    public function __construct() {
        
    }
    
    //Verificare se serve la funzione Esiste come per il prof//
    
    public function getID(){
        return $this->ID;
    }
    public function setId($ID){
        $intVal = filter_var($ID, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if(!isset($intVal)){
            return false;
        }
        $this->ID = $intVal;
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
    public function setCOgnome($Cognome){
        $this->cognome=$Cognome;
        return true;
    }
    
    public function getData(){
        return $this->data;
    }
    public function setData($data){
        $this->data=$data;
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
    public function setCap($cap) {                     //Il cap è formato da 5 numeri da 0 a 9 //
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
    
    public function getUsername(){         //Guardare user del proff//
        return $this->username;
    }
    //imposto l'username del clien //
    public function setUsername($username) {
        // utilizzo la funzione filter var specificando un'espressione regolare
        // che implementa la validazione personalizzata
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
    
    
    
}






/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>

