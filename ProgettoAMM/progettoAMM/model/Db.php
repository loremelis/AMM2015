<!-- file di connessione al database -->
    
    <?php
    include_once '../Settings.php';
    
    class Db {
   
    private function __construct() {
        
    }
    
    private static $singleton;
    
    //restituisce un singleton per la connessione del database
    public static function getInstance(){
        if(!isset(self::$singleton)){
            self::$singleton = new Db();
        }
        
        return self::$singleton;
        
    }
    
    //connessione al database
    public function connectDb(){
        $mysqli = new mysqli();
        $mysqli->connect(Settings::$db_host, Settings::$db_user,
        Settings::$db_password, Settings::$db_name);
        if($mysqli->errno != 0){
            return null;
        }else{
            return $mysqli;
        }
    }
}



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

