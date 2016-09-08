<?php

include_once 'Object.php';
include_once 'model/User.php';
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
        $query= "SELECT * FROM oggetti WHERE id=\"$ID\";";
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
        
        $oggetti =  self::caricaOggettiDaStmt($stmt);
        foreach($oggetti as $oggettoo){
            self::caricaIscritti($oggetto);
        }
        if(count($oggetti > 0)){
            $mysqli->close();
            return $oggetti[0];
        }else{
            $mysqli->close();
            return null;
        }
    }
    
    //mi serve una variabile che scorra tutti gli id degli oggetti
    
    /* public function &getCarelloPerCliente(int $i){ 
        $oggetti = array();
        $query = "select * from oggetti where oggetti_id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[getcarrelloPerCliente] impossibile inizializzare il database");
            $mysqli->close();
            return $oggetti;
        }
        
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[getcarrelloPerCliente] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return $oggetti;
        }
        
        if (!$stmt->bind_param('i',$i)){
            error_log("[getcarrelloPerCliente] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return $oggetti;
        }
        $oggetti =  self::caricaOggettiDaStmt($stmt);
        foreach($oggetti as $oggetto){
            self::caricaOggetto($oggetto);
        }
        $mysqli->close();
        return $oggetti;
    } */
    
    public function &getListaOggetti() {
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
    }
    
    public function caricaOggetto(Object $oggetto){
        
        $query = "select * from oggetti where oggetti_id = ?";
        $mysqli = Db::getInstance()->connectDb();
        if (!isset($mysqli)) {
            error_log("[cercaOggettoPerId] impossibile inizializzare il database");
            $mysqli->close();
            return null;
        }
        $stmt = $mysqli->stmt_init();
        $stmt->prepare($query);
        if (!$stmt) {
            error_log("[caricaCarrello] impossibile" .
                    " inizializzare il prepared statement");
            $mysqli->close();
            return null;
        }
        if (!$stmt->bind_param('i', $oggetto->getId())) {
            error_log("[caricaCarrello] impossibile" .
                    " effettuare il binding in input");
            $mysqli->close();
            return null;
        }
        
        if (!$stmt->execute()) {
            error_log("[caricaCarrello] impossibile" .
                    " eseguire lo statement");
            $mysqli->close();
            return null;
        }
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
            $oggetti[] = self::creaDaArray($row);
        }
        
        $stmt->close();
        
        return $oggetti;
    }

    
    public function creaOggettoDaArray($row){
        $oggetto = new Object(
        $row['id'],
        $row['nome'],
        $row['prezzo'],
        $row['descrizione'],
        $row['immagine'],
        $row['quantita']);
        return $oggetto;
     }
     
    /* $oggetto->setID($row['id']);
        $oggetto->setNameObj($row['nome']);
        $oggetto->setPrice($row['prezzo']);
        $oggetto->setDescription($row['descrizione']);
        $oggetto->setImage($row['immagine']);
        $oggetto->setAmount($row['quantita']);
        return $oggetto;
    } */
    
    /*modificare un oggetto
    public function salva(Object $oggetto){
         $query = "UPDATE oggetti SET
                    nome = ?,
                    prezzo = ?,
                    descrizione = ?,
                    immagine = ?,
                    quantita = ?.
                    where oggetti.id = ?";
        return $this->modificaDB($oggetto, $query);
    }
     * */
   
   /* public function aggiungiOggetto(Carrello $c, Oggetto $o){
        $query = "insert into oggetti (oggetti_id) values (?)";
        return $this->queryIscrizione($s, $a, $query);
    }
    
    public function cancellaIscrizione(Studente $s, Appello $a){
        $query = "delete from appelli_studenti where studente_id = ? and appello_id = ?";
        return $this->queryIscrizione($s, $a, $query);
    } */
    
    //aggiungere un nuovo oggetto
   public function nuovo(Object $oggetto){
        $query = "INSERT INTO oggetti (id, nome, prezzo, descrizione, immagine, quantita)
                  values (?, ?, ?, ?, ?, ?)";
        return $this->modificaDB($oggetto, $query);
    }
    
    public function cancella(Object $oggetto){
        $query = "delete from oggetti where oggetti_id = ?";
        return $this->modificaDB($appello, $query);
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
        if (!$stmt->bind_param('isissi',
                $oggetto->getID(),
                $oggetto->getNameObj(),
                $oggetto->getPrice(),
                $oggetto->getDescription(),
                $oggetto->getImage(),
                $oggetto->getAmount())) {
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
