<?php

/* classe che contine una lista di variabili di configurazione
 * Controllare e valutare eventuali errori */

class Settings {
    
    
    // variabili di accesso per il database
    public static $db_host = 'localhost';
    public static $db_user = 'melisLorenzo';
    public static $db_password = 'sogliola2040';
    public static $db_name='amm_meliLorenzo';
    
    private static $appPath;
          
    public static function getApplicationPath(){
        
        if(!isset(self::$appPath)){
            switch ($_SERVER['HTTP_HOST']) {    // prende l'indirizzo http dell'host //
                case 'localhost':
                
                    self::$appPath = 'http://'. $_SERVER['HTTP_HOST'] . '/AMM2015/ProgettoAMM/progettoAMM/';
                    break;
                
                case 'spano.sc.unica.it':
                    // configurazione pubblica //
                    self::$appPath = 'http://' . $_SERVER['HTTP_HOST'] . '/amm2015/melisLorenzo/ProgettoAMM/progettoAMM/';
                   
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

