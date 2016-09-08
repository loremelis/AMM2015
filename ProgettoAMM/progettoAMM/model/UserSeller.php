<?php

include_once 'User.php';

class UserSeller extends User {

    public function __construct($ruolo, $password, $username, $ID) {
        
        parent::__construct($ruolo, $password, $username, $ID);
		$this->ID=$ID;
       }
	
       
    public function getID2(){
    	
        return $this->ID;
    }
	
}

?>
