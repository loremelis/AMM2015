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
        
        $vd = new ViewDescriptor();
        
        $vd->setVista($request['page']);
        
        $this->setImpToken($vd, $request);
        
        // gestion dei comandi
        if (!$this->loggedIn()) {
            
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
                    
                    case 'carrello': 
                        $vd->setSottoVista('carrello');
                        break;
                    
                    case 'cliente':
                        $vd->setSottoVista('client');
                        break;
                    
                    case 'home':
                        $vd->setSottoVista('home');
                        break;
                    
                    case 'info':
                        $vd->setSottoVista('info');
                        break;
                    default:
                        $vd->setSottoVista('home');
                        break; 
                } // VALUTARE SE SERVE ANCHE LOGIN
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
                    //TUTTO DA VEDERE
                    case 'anagrafica':

                        $msg = array();
                        $this->aggiornaAnagrafica($user, $request, $msg); //DA VALUTARE
                        $this->creaFeedbackUtente($msg, $vd, "Anagrafica aggiornata"); //ok
                        $this->showHomeCLiente($vd);
                        break;
                    
                    //TUTTO DA VEDERE
                     case 'aggiungiCarrello':
                         $object = ObjectFactory::instance()->cercaOggettoPerId(); //VALUTARE COSA METTERE DENTRO LE PARENTESI
                         $msg= array();
                         $this->aggiungiCarrello($object, $request, $msg);
                         $this->creaFeedbackUtente($msg, $vd, "Oggetto aggiunto al carrello");
                         $this->showHomeCLiente($vd);
                         break;
                    default: $this->showHomeCLiente($vd);
                        
                        //Forse fare funzione che elimina dal carrello
                    
            }
            } else {
                // VALUTARE
                $user = UserFactory::instance()->cercaUtentePerId($_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }
        // includo la vista
        require 'view/master.php';
    }
     
    /*Da fare               
    public function aggiungiCarrello($object, $request, $msg) {
        
    } */
 
}
?>

