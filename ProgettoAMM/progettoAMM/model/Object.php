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

    
    
     public function getID(){
        return $this->ID;
     }
     public function setId($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->id = $intVal;
        return true;
    }
     
     public function getNameObj(){
         return $this->name_obj;
     }
     public function setNameObj($name_obj){
         $this->name=$name_obj;
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
     public function setAmount($amount) {
        $intVal = filter_var($amount, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->amount=$intVal;
     }

}

?>
