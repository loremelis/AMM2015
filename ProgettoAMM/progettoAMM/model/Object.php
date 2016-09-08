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
    
     public function getID(){
        return $this->ID;
     }
     public function setID($id) {
        $intVal = filter_var($id, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
        if (!isset($intVal)) {
            return false;
        }
        $this->ID = $intVal;
        return true;
    }
     
     public function getNameObj(){
         return $this->name_obj;
     }
     public function setNameObj($name_obj){
         $this->name_obj=$name_obj;
         return true;
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
        return true;
     }
     
     public function getDescription(){
        return $this->description;
     }
     public function setDescription($description){
         $this->description= $description;
         return true;
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
        return true;
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
        return true;
     }
     
    
    /* public function aggiungi(Object $oggetto) {
        $this->carrello[] = $oggetto;
        return true;
    }
    
    
    public function cancella(Object $oggetto) {
        $pos = $this->posizione($oggetto);
        if ($pos > -1) {
            array_splice($this->carrello, $pos, 1);
            return true;
        }
        return false;
    } */
 

    /**
     * Calcola la posizione di uno studente all'interno della lista
     * @param Studente $studente lo studente da ricercare
     * @return int la posizione dello studente nella lista, -1 se non e' stato 
     * inserito
     */
    /*private function posizione(Oggetto $oggetto) {
        for ($i = 0; $i < count($this->carrello); $i++) {
            if ($this->carrello[$i]->equals($oggetto)) {
                return $i;
            }
        }
        return -1;
    }

     */
}

?>
