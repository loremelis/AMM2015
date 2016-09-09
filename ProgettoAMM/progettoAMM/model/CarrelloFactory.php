<?php

include_once 'Object.php';
include_once 'User.php';
include_once 'ObjectFactory.php';
include_once 'UserSeller.php';
include_once 'UserFactory.php';


class CarrelloFactory{
    
    private static $singleton;
    
    private function __constructor(){
   
    }
    
    
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new CarrelloFactory();
        }
        
        return self::$singleton;
    }
    

    public function &getCarrelli() {
        $carrelli = array();
        
        $query = "select *  from carrello ";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getCarrelli] impossibile inizializzare il database");
            $mysqli->close();
            return $carrelli;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getCarrelli] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->execute()) {
            error_log("[getCarrelli] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        $carrelli =  self::caricaCarrelliDaStmt($stmt);
        
        $mysqli->close();
        return $carrelli;
    }
    
    public function &caricaCarrelliDaStmt(mysqli_stmt $stmt){
        $carrelli = array();
         if (!$stmt->execute()) {
            error_log("[caricaOggettoDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['carrello_id'],
                $row['carrello_titolo'],
                $row['carrello_quantita'],
                $row['carrello_prezzo'],
                $row['carrello_id_ogg']);
                
        if (!$bind) {
            error_log("[caricaOggettoDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        while ($stmt->fetch()) {
            $carrelli[] = self::creaCarrelloDaArray($row);
        }
        
        $stmt->close();
        
        return $carrelli;
    }

    public static function creaCarrelloDaArray($row) {
   
        $carrello = new Carrello(
                $row['carrello_id'],
                $row['carrello_titolo'],
                $row['carrello_quantita'],        
                $row['carrello_prezzo'],
                $row['carrello_id_ogg']);
        return $carrello;
     }
     
     public function nuovo2(Carrello $carrello){
        $query = "INSERT INTO carrello (id,titolo, quantita, prezzo, id_ogg) VALUES (?,?,?,?,?)";
        return $this->modificaDB($carrello, $query);
    }
    
    public function cancella2(Carrello $carrello){
        $query = "delete from carrello where id = ? and titolo = ? and quantita = ? and prezzo = ? and id_ogg= ?";
        return $this->modificaDB($carrello, $query);
    }
    
    //Funzione che modifica il Db
    private function modificaDB(Carrello $carrello, $query){
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            print('m1');
            error_log("[salva] impossibile inizializzare il database");
            return 0;
        }
        $stmt = $mysqli->stmt_init();
       
        $stmt->prepare($query);
        if (!$stmt) {
            print('m2');
            error_log("[modificaDB] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }
        $ID4 = $carrello->getID4();
        $titolo = $carrello->getTitolo();
        $Price2 = $carrello->getPrice2();
        $quantita = $carrello->getAmount2();
        $IdObj	= $carrello->getIdObj();
        if (!$stmt->bind_param('isiii',
               		$ID4,
                        $titolo,
                        $quantita,
                        $Price2,
                        $IdObj)){
            print('m3');

            error_log("[modificaDB] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return 0;
        }
        if (!$stmt->execute()) {
            error_log("[modificaDB] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return 0;
        }
        $mysqli->close();
        return $stmt->affected_rows;
    }
    
    //Funzione che calcola il totale del prezzo
    public function calcolaTotale($carrelli){
        $tot = 0;
        foreach($carrelli as $carrello){
            $a = 0;
            $a = $carrello->getPrice2();
            $tot += $a;
        }
        return $tot;
        
    }
}