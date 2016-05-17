

<?php

class ViewDescriptor {
    /* get e post HTTP */
    
    const get = 'get';
    
    const post = 'post';
    
    /* Titolo della pagina */ 
    private $titolo;
    
    private $header_file;
    
    private $content_file;

    
    private $footer_file;
    
    /* variabile con funzionalità diverse a seconda che si entri in modalita client o seller 
       corrispondenti alle varie cartelle nella view */
    private $vista; 
    /* corrisponde alla sottopagine a seconda della vista corrente*/
    private $sottoVista;
    
    private $error_message; //messaggio di errore, da mettere nel Login//
    
    //probabilmente servirà un impToken//


    public function getTitolo(){
        return $this->titolo;
    }
    public function setTitolo($titolo){
        $this->titolo=$titolo;
    }
    
    public function getHeaderFile(){
        return $this->header_file;
    }
    public function setHeaderFile($header_file){
        $this->header_file=$header_file;
    }
    
    public function getContentFile(){
        return $this->content_file;
    }
    public function setContentFile($content_file){
        $this->content_file=$content_file;
    }
            
    public function getVista(){
        return $this->vista;
    }
    public function setVista($vista){
        $this->vista=$vista;
    }
    
      public function getSottoVista() {
        return $this->sottoVista;
    }
  
    public function setSottoVista($sottoVista) {
        $this->sottoVista = $sottoVista;
    }
    
    public function getFooterFile(){
        return $this->footer_file;
    }
    public function setFooterFile($footer_file){
        $this->footer_file=$footer_file;
    }
    
    public function getErrorMessage(){
        return $this->vista;
    }
    public function setErrorMessage($error_message){
        $this->error_message=$error_message;
    }

    
            
 /* da valutare se serve il Javascript ed il JSON
  * o abbiamo bisogno di qualche ciclo all'interno del View Descriptor
  * 
  */    
    
    
    
    
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

?>