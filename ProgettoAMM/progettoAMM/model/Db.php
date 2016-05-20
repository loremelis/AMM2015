<!-- file di connessione al database -->
    
 <?php
    include_once 'progetto/AMM/Settings.php';
    
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
?>
