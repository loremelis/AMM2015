<?php

/* Qua ci sara il php per gestire gli oggetti in vendita -->
 in questa cartella ci andranno anche */



class Object {
    
    private $ID;
    private $name_obj;
    private $price;
    private $description;
    private $image;
    private $amount;
    private $link;
    
    
     public function getID(){
        return $this->ID;
     }
     public function setID($ID){
         $this->ID= $ID;
     }
     
     public function getNameObj(){
         return $this->name_obj;
     }
     public function setName($name_obj){
         $this->name=$name_obj;
     }
     
     public function getPrice(){
        return $this->price;
     }
     public function setPrice($price){
         $this->price= $price;
     }
     
     public function getDescription(){
        return $this->description;
     }
     public function setDescriprion($description){
         $this->description= $description;
     }
     
     public function getImage(){
        return $this->image;
     }
     public function setImage($image){
         $this->image= $image;
     }
     
     public function getAmount(){
        return $this->amount;
     }
     public function setAmount($amount){
         $this->amount= $amount;
     }
     
     public function getLink(){
        return $this->link;
     }
     public function setLink($link){
         $this->link= $link;
     }
     
    
             
     
     
     
    
    
    
}

?>
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


