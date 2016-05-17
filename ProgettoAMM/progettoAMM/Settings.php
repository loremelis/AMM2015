<?php

/* classe che contine una lista di variabili di configurazione
 * Controllare e valutare eventuali errori */

class Settings {
    
    private static $appPath;
    const debug = false;
    
    public static $user = "lmelis";
    public static $password = "simpson92";
    public static $host = "localhost";
    public static $db = "amm16_lorenzoMelis";  // Da controllare //
            
    public static function getApplicationPath(){
        
        if(!isset(self::$appPath)){
            switch ($_SERVER['HTTP_HOST']) {    // prende l'indirizzo http dell'host //
                case 'localhost':
                    self::$appPath = 'http://'. $_SERVER['HTTP_HOST'] . '/Lollosfilm/';  //Da controllare//
                    break;
                case 'spano.sc.unica.it':
                    // configurazione pubblica //
                    self::$appPath = 'http://' . $_SERVER['HTTP_HOST'] . '/AMM2015/loremelis/progettoAMM';
                    break;
                default :
                    self::$appPath= '';
                    break;
            }
        }
        
        return self::$appPath;
    }
}

?>
  
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

