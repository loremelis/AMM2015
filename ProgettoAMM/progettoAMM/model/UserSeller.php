<?php
//Probabilmente non mi serve questa classe

class UserSeller extends User {

    public function __construct($ruolo, $password, $username, $ID) {
        
        parent::__construct($ruolo, $password, $username, $ID);
        
    }
    
    }
?>
