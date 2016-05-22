<?php

include_once 'Object.php';
include_once 'User.php';
include_once 'UserFactory.php';
include_once 'UserClient.php';
include_once 'UserSeller.php';


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
    
    public function cercaOggettoPerId($oggettoId){
        $oggetti = array();
        $query = "select *
               from oggetti
               where oggetti.id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaOggettoPerId] impossibile inizializzare il database");
            $mysqli->close();
            return $oggetti;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cercaOggettoPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $oggetti;
        }
         
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[cercaOggettoPerId] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $oggetti;
        }
        
         
        if (!$stmt->bind_param('i', $oggettoId)) {
            error_log("[cercaOggettoPerId] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $oggetti;
        }
    }
    
      public function creaDaArray($row){
        $oggetto = new Object();
        $oggetto->setId($row['oggetto_id']);
        $oggetto->setName($row['oggetto_nome']);
        $oggetto->setPrice($row['oggetto_prezzo']);
        $oggetto->setDescriprion($row['oggetto_descrizione']);
        $oggetto->setImage($row['oggetto_immagine']);
        $oggetto->setAmount($row['oggetto_quantita']);
        return $oggetto;
    }
    
    //modificare un oggetto
    public function salva(Object $oggetto){
         $query = "update oggetti set 
                    nome = ?,
                    prezzo = ?,
                    descrizione = ?,
                    immagine = ?,
                    quantita = ?.
                    where oggetti.id = ?";
        return $this->modificaDB($oggetto, $query);
    }
    
    //aggiungere un nuovo oggetto
   public function nuovo(Object $oggetto){
        $query = "insert into oggetti (id, nome, prezzo, descrizione, immagine, quantita)
                  values (?, ?, ?, ?, ?, ?)";
        return $this->modificaDB($oggetto, $query);
    }
    //cancellare un oggetto
    public function cancella(Object $oggetto){
        $query = "delete from oggetti where name = ?";
        return $this->modificaDB($oggetto, $query);
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
        if (!$stmt->bind_param('ssisii', 
                $oggetto->getNameObj(),
                $oggetto->getDescription(),
                $oggetto->getPrice(),
                $oggetto->getImage(),
                $oggetto->getAmount(),
                $oggetto->getID())) {
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
