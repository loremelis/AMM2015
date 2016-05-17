<?php
include_once 'BaseController.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa ai 
 * Docenti da parte di utenti con ruolo Venditore o Amministratore 
 */
class DocenteController extends BaseController {
    const elenco = 'elenco';
    public function __construct() {
        parent::__construct();
    }
    /**
     * Metodo per gestire l'input dell'utente. 
     * @param type $request la richiesta da gestire
     */
    
    public function handleInput(&$request) {
        // creo il descrittore della vista
        $vd = new ViewDescriptor();
        // imposto la pagina
        $vd->setVista($request['page']);
        // imposto il token per impersonare un utente (nel lo stia facendo)
        $this->setImpToken($vd, $request);
        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home
            $this->showLoginPage($vd);
        } else {
            

             // Tutto da rivedere
            
            $user = UserFactory::instance()->cercaUtentePerId(     
                    $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
            
            // verifico quale sia la sottopagina della categoria
            // Venditore da servire ed imposto il descrittore 
            // della vista per caricare i "pezzi" delle pagine corretti
            // tutte le variabili che vengono create senza essere utilizzate 
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {
                    
                    // aggiunta di un elemento alla tabella
                    case 'aggiungielemento':
                    case 'listaelementi':
                    case 'rimuovi elemento'
                     
                   
            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {
                switch ($request["cmd"]) {
                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;
                    // modifica delle informazioni sull'indirizzo dell'ufficio
                    case 'ufficio':
                        $msg = array();
                        if (isset($request['dipartimento'])) {
                            $intVal = filter_var($request['dipartimento'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (!isset($intVal) || $intVal < 0 || $intVal > count($dipartimenti)
                                    || $user->setDipartimento($dipartimenti[$intVal])) {
                                $msg[] = '<li>Il dipartimento specificato non &egrave; corretto</li>';
                            }
                        }
                        $this->aggiornaIndirizzo($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Indirizzo ufficio aggiornato");
                        $this->showHomeUtente($vd);
                        break;
                    
                  
                // nessun comando, dobbiamo semplicemente visualizzare 
                // la vista
                // nessun comando
                $user = UserFactory::instance()->cercaUtentePerId(
                        $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }
        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }
    
    
}
    }}
}
?>
