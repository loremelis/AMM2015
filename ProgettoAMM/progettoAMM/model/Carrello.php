<?php



class Carrello {
    
    private $ID;
    private $titolo;
    private $price;
    private $amount;
    private $id_ogg;
    
    
    public function __construct($ID,$titolo,$amount,$price,$id_ogg){
        $this->ID = $ID;
        $this->titolo = $titolo;
        $this->amount = $amount;
        $this->price = $price;
        $this->id_ogg = $id_ogg;
        
    }
    
     public function getID4(){
        return $this->ID;
     }
     /*public function setID($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->ID = $intVal;
        return true;
    } */
     
     public function getTitolo(){
         return $this->titolo;
     }
     public function setTitolo($titolo){
         $this->titolo=$titolo;
     }
     
     public function getPrice2(){
        return $this->price;
     }
     public function setPrice($price) {
        $intVal = filter_var($price, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->price=$intVal;
     }

     
     public function getAmount2(){
        return $this->amount;
     }
     public function setAmount($amount) {
        $intVal = filter_var($amount, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->amount=$intVal;
     }
     
     public function getIdObj(){
         return $this->titolo;
     }
     public function setIdObj($id_ogg){
        $intVal = filter_var($id_ogg, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->id_ogg=$intVal;
     }
    
    
    
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

