<?php

class UserSeller{
    
    
    private $username; //non so se è necessario//
    
    private $password;

    private $id;
    /**
     * Costruttore
     */
    public function __construct() {
        
    }
    
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
    
    public function getUsername(){         //Guardare user del proff//
        return $this->username;
    }
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

