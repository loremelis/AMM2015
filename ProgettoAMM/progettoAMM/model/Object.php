<?php

/* Qua ci sara il php per gestire gli oggetti in vendita */



class Object {
    
    private $ID;
    private $name_obj;
    private $price;
    private $description;
    private $image;
    private $amount;
    

    public function __construct($ID,$name_obj,$price,$description,$image,$amount){
        $this->ID = $ID;
        $this->name_obj = $name_obj;
        $this->price = $price;
        $this->description = $description;
        $this->image = $image;
        $this->amount = $amount;
        
    }
    
     public function getID3(){
        return $this->ID;
     }
     /*public function setID($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->ID = $intVal;
        
    } */
     
     public function getNameObj(){
         return $this->name_obj;
     }
     public function setNameObj($name_obj){
         $this->name_obj=$name_obj;
         
     }
     
     public function getPrice(){
        return $this->price;
     }
     public function setPrice($price) {
        $intVal = filter_var($price, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->price=$intVal;
        
     }
     
     public function getDescription(){
        return $this->description;
     }
     public function setDescription($description){
         $this->description= $description;
         
     }
     
     public function getImage(){
        return $this->image;
     }
     public function setImage($image) {
        $intVal = filter_var($image, FILTER_VALIDATE_URL, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->image=$intVal;
        
     }
     
     public function getAmount(){
        return $this->amount;
     }
     public function setAmount($amount) {
        $intVal = filter_var($amount, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->amount=$intVal;
   
     }
     

}

?>
