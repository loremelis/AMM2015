<?php

include_once 'BaseController.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa agli 
 * Clienti con il ruolo Clienti
 */
class clientController extends BaseController {
    
    public function __construct() {
        parent::__construct();
    }
    
    //gestisce gli input
    public function handleInput(&$request) {
        // creo il descrittore della vista
        $vd = new ViewDescriptor();
        // imposto la vista
        $vd->setVista($request['page']);
        // imposto il token per impersonare un utente (nel lo stia facendo)
        $this->setImpToken($vd, $request);
        
        // gestion dei comandi
        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla pagina di Login
            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = UserFactory::instance()->cercaUtentePerId($_SESSION[BaseController::user], $_SESSION[BaseController::role]);
            
            // verifico quale sia la sottopagina della categoria da visalizzare
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {
                    // modifica dei dati anagrafici
                    case 'anagrafica':
                        $vd->setSottoVista('anagrafica');
                        break;
                    // visualizzazione degli esami sostenuti
                    case 'carrello': 
                        $vd->setSottoVista('carrello');
                        break;
                    
                    case 'cliente':
                        $vd->setSottoVista('client');
                        break;
                    default:
                        $vd->setSottoVista('home');
                        break;
                }
            }
            // gestione dei comandi inviati dall'utente
            
            if (isset($request["cmd"])) {
                // abbiamo ricevuto un comando
                switch ($request["cmd"]) {
                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;
                    // aggiornamento tutta anagrafica
                    case 'indirizzo':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaAnagrafica($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Indirizzo aggiornato");
                        $this->showHomeUtente($vd);
                        break;
                    
                }
            } else {
                // nessun comando
                $user = UserFactory::instance()->cercaUtentePerId($_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }
        // includo la vista
        require basename(__DIR__) . '/../view/master.php';
    }
    
    
}
?>

