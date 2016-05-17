<?php
include_once 'BaseController.php';

/**
 * Controller che gestisce la modifica dei dati dell'applicazione relativa agli 
 * Clienti con il ruolo Clienti

 */
class StudenteController extends BaseController {
    const appelli = 'appelli';
    /**
     * Costruttore
     */
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
        // imposto la vista
        $vd->setVista($request['page']);
        // imposto il token per impersonare un utente (nel lo stia facendo)
        $this->setImpToken($vd, $request);
        // gestion dei comandi
        // tutte le variabili che vengono create senza essere utilizzate 
        // direttamente in questo switch, sono quelle che vengono poi lette
        // dalla vista, ed utilizzano le classi del modello
        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home
            $this->showLoginPage($vd);
        } else {
            // utente autenticato
            $user = UserFactory::instance()->cercaUtentePerId(
                            $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
            // verifico quale sia la sottopagina della categoria
            // Docente da servire ed imposto il descrittore 
            // della vista per caricare i "pezzi" delle pagine corretti
            // tutte le variabili che vengono create senza essere utilizzate 
            // direttamente in questo switch, sono quelle che vengono poi lette
            // dalla vista, ed utilizzano le classi del modello
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {
                    // modifica dei dati anagrafici
                    case 'anagrafica':
                        $vd->setSottoPagina('anagrafica');
                        break;
                    // visualizzazione degli esami sostenuti
                    case 'carrello':  //TUTTA DA FARE
                     
                        break;
                    // iscrizione ad un appello
                    case 'cliente':
                        // TUTTA da fare
                        
                        $vd->setSottoPagina('client');
                        break;
                    default:
                        $vd->setSottoPagina('home');
                        break;
                }
            }
            // gestione dei comandi inviati dall'utente
            
            //TUTTA DA RIVEDERE
            if (isset($request["cmd"])) {
                // abbiamo ricevuto un comando
                switch ($request["cmd"]) {
                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;
                    // aggiornamento indirizzo
                    case 'indirizzo':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaIndirizzo($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Indirizzo aggiornato");
                        $this->showHomeUtente($vd);
                        break;
                    // cambio email
                    case 'email':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaEmail($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Email aggiornata");
                        $this->showHomeUtente($vd);
                        break;
                    // cambio password
                    case 'password':
                        // in questo array inserisco i messaggi di 
                        // cio' che non viene validato
                        $msg = array();
                        $this->aggiornaPassword($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Password aggiornata");
                        $this->showHomeStudente($vd);
                        break;
                    // iscrizione ad un appello
                    case 'iscrivi':
                        // recuperiamo l'indice 
                        $msg = array();
                        $a = $this->getAppelloPerIndice($appelli, $request, $msg);
                        if (isset($a)) {
                            $isOk = $a->iscrivi($user);
                            $count = AppelloFactory::instance()->aggiungiIscrizione($user, $a);
                            if (!$isOk || $count != 1) {
                                $msg[] = "<li> Impossibile cancellarti dall'appello specificato </li>";
                            }
                        } else {
                            $msg[] = "<li> Impossibile iscriverti all'appello specificato. Verifica la capienza del corso </li>";
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Ti sei iscritto all'appello specificato");
                        $this->showHomeStudente($vd);
                        break;
                    // cancellazione da un appello
                    case 'cancella':
                        // recuperiamo l'indice 
                        $msg = array();
                        $a = $this->getAppelloPerIndice($appelli, $request, $msg);
                        if (isset($a)) {
                            $isOk = $a->cancella($user);
                            $count = AppelloFactory::instance()->cancellaIscrizione($user, $a);
                            if (!$isOk || $count != 1) {
                                $msg[] = "<li> Impossibile cancellarti dall'appello specificato </li>";
                            }
                        } else {
                            $msg[] = "<li> Impossibile cancellarti dall'appello specificato </li>";
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Ti sei cancellato dall'appello specificato");
                        $this->showHomeUtente($vd);
                        break;
                    default : $this->showLoginPage($vd);
                }
            } else {
                // nessun comando
                $user = UserFactory::instance()->cercaUtentePerId(
                                $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }
        // includo la vista
        require basename(__DIR__) . '/../view/master.php';
    }
    
    
}
?>

