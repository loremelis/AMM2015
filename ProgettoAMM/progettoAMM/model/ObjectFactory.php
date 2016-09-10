<?php

include_once 'Object.php';
include_once 'User.php';
include_once 'UserClient.php';
include_once 'UserSeller.php';
include_once 'UserFactory.php';


class ObjectFactory{
    
    private static $singleton;
    
    private function __constructor(){
   
    }
    
    
    public static function instance(){
        if(!isset(self::$singleton)){
            self::$singleton = new ObjectFactory();
        }
        
        return self::$singleton;
    }
    
    
    public function cercaOggettoPerId($id){
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaUtentePerId] impossibile inizializzare il database");
            $mysqli->close();

            return null;
        }
        $query= "SELECT * FROM oggetti WHERE id =\"$id\";";
                $stmt = $mysqli->stmt_init();
                $stmt->prepare($query);
                if (!$stmt) {
                    error_log("[cercaUtentePerId] impossibile" .
                            " inizializzare il prepared statement");
                    $mysqli->close();

                    return null;
                }
                if (!$stmt->execute()) {      
                    error_log("[cercaUtentePerId] impossibile" .
                            " effettuare il binding in input");
                    $mysqli->close();

                    return null;
                }
                print('o1');
                $oggetto = self::caricaOggettoDaStmt($stmt); 
                if(isset($oggetto)){
                    print('02');
                    $mysqli->close();
                    return $oggetto;
                }
    }
    
    /* public function &getListaOggetti() {
        $oggetti = array();
        $query = "select * from oggetti ";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getListaOggetti] impossibile inizializzare il database");
            $mysqli->close();
            return $oggetti;
        }
        $result = $mysqli->query($query);
        if ($mysqli->errno > 0) {
            error_log("[getListaOggetti] impossibile eseguire la query");
            $mysqli->close();
            return $oggetti;
        }
        while ($row = $result->fetch_array()) {
            $oggetti[] = self::creaOggettoDaArray($row);
        }
        return $oggetti;
    } */
    
    public function &getOggetti() {
       $oggetti = array();
        
        $query = "select *  from oggetti";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getOggetti] impossibile inizializzare il database");
            $mysqli->close();
            return $appelli;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getOggetti] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->execute()) {
            error_log("[getOggetti] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        $oggetti =  self::caricaOggettiDaStmt($stmt);
        
        $mysqli->close();
        return $oggetti;
    }

    
    public function &caricaOggettiDaStmt(mysqli_stmt $stmt){
        $oggetti = array();
         if (!$stmt->execute()) {
            error_log("[caricaOggettoDaStmt] impossibile" .
                    " eseguire lo statement");
            return null;
        }
        $row = array();
        $bind = $stmt->bind_result(
                $row['oggetti_id'],
                $row['oggetti_nome'],
                $row['oggetti_prezzo'],
                $row['oggetti_descrizione'],
                $row['oggetti_immagine'],
                $row['oggetti_quantita']);
                
        if (!$bind) {
            error_log("[caricaOggettoDaStmt] impossibile" .
                    " effettuare il binding in output");
            return null;
        }
        while ($stmt->fetch()) {
            $oggetti[] = self::creaOggettoDaArray($row);
        }
        
        $stmt->close();
        
        return $oggetti;
    }

    public function creaOggettoDaArray($row){
        $oggetto = new Object(
        $row['oggetti_id'],
        $row['oggetti_nome'],
        $row['oggetti_prezzo'],
        $row['oggetti_descrizione'],
        $row['oggetti_immagine'],
        $row['oggetti_quantita']);
        return $oggetto;
     }

    //aggiungere un nuovo oggetto
    public function nuovo(Object $oggetto){
       $query = "INSERT INTO oggetti (id, nome, prezzo, descrizione, immagine, quantita) VALUES (?,?,?,?,?,?)" ;
       return $this->modificaDB($oggetto, $query);
    }
    
    //Cancellare una locandina
    public function cancella(Object $oggetto){
        $query = "delete from oggetti  where id = ? and nome = ? and prezzo = ? and descrizione = ? and immagine = ? and quantita = ?";
        return $this->modificaDB($oggetto, $query);
    }
    
    public function salva2(Object $oggetto){
        $qua = $oggetto->getAmount();
        $int = $oggetto->getID3();
        $query = "UPDATE oggetti SET quantita = \"$qua\" WHERE id = \"$int\"";
        return $this->modificaDB2($qua,$int, $query);
    }
    
    //Funzione che modifica il Db
    private function modificaDB(Object $oggetto, $query){
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salva] impossibile inizializzare il database");
            return 0;
        }
        $stmt = $mysqli->stmt_init();
       
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[modificaDB] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }
        $ID3= $oggetto->getID3();
        $nome = $oggetto->getNameObj();
        $prezzo = $oggetto->getPrice();
        $descrizione = $oggetto->getDescription();
        $image = $oggetto->getImage();
        $amount= $oggetto->getAmount();
        if (!$stmt->bind_param('isissi',
                $ID3,
                $nome,
                $prezzo,
                $descrizione,
                $image,
                $amount)) {
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
    
    private function modificaDB2($amount,$id, $query){
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[salva] impossibile inizializzare il database");
            return 0;
        }
        $stmt = $mysqli->stmt_init();
       
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[modificaDB] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return 0;
        }
        
        
        if (!$stmt->bind_param('ii', $amount,$id)) {
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
    
  }
?>
