<?php

//Struttura per popolare la vista generica della master
class ViewDescriptor {
    
    const get = 'get';
   
    const post = 'post';
   
    private $titolo;
    
    private $header_file;
    
    private $content_file;

    private $messaggioErrore;
 
    private $messaggioConferma; 
  
    private $vista;

    private $sottoVista;
    
    private $impToken;
    
    private $footer_file;
    
   
    public function __construct() {
    
    }
  
    public function getTitolo() {
        return $this->titolo;
    }
    public function setTitolo($titolo) {
        $this->titolo = $titolo;
    }

    public function setHeaderFile($headerFile) {
        $this->header_file = $headerFile;
    }
    public function getHeaderFile() {
        return $this->header_file;
    }
    
    public function setFooterFile($footerFile) {
        $this->footer_file = $footerFile;
    }
    public function getFooterFile() {
        return $this->footer_file;
    }

    public function setContentFile($contentFile) {
        $this->content_file = $contentFile;
    }
    public function getContentFile() {
        return $this->content_file;
    }

    public function getMessaggioErrore() {
        return $this->messaggioErrore;
    }
    public function setMessaggioErrore($msg) {
        $this->messaggioErrore = $msg;
    }

    public function getSottoVista() {
        return $this->sottoVista;
    }
    public function setSottoVista($view) {
        $this->sottoVista = $view;
    }

    public function getMessaggioConferma() {
        return $this->messaggioConferma;
    }
    public function setMessaggioConferma($msg) {
        $this->messaggioConferma = $msg;
    }

    public function getVista() {
        return $this->vista;
    }
    public function setVista($vista) {
        $this->vista = $vista;
    }
    


    public function setImpToken($token) {
        $this->impToken = $token;
    }
    
    /* metodo per gestire le variabili a livello pagina
     * si possono impersonare piu utenti in piu schede dello stesso
     * browser
     */
    public function scriviToken($pre = '', $method = self::get) {
        $imp = BaseController::impersonato;
        switch ($method) {
            case self::get:
                if (isset($this->impToken)) {
                    
                    return $pre . "$imp=$this->impToken";
                }
                break;
            case self::post:
                if (isset($this->impToken)) {
                    return "<input type=\"hidden\" name=\"$imp\" value=\"$this->impToken\"/>";
                }
                break;
        }
        return '';
    }
}
?>