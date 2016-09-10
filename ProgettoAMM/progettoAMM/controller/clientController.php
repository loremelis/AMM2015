<?php

include_once 'model/ObjectFactory.php';
include_once 'clientController.php';
include_once 'model/CarrelloFactory.php';
include_once 'model/Carrello.php';

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
                        $carrelli = CarrelloFactory::instance()->getCarrelli();
                        $vd->setSottoVista('carrello');
                        break;

                    case 'client':
                        $oggetti = ObjectFactory::instance()->getOggetti();
                        $vd->setSottoVista('client');
                        break;

                    case 'home':
                        $vd->setSottoVista('home');
                        break;

                    case 'info':
                        $vd->setSottoVista('info');
                        break;
                    
                    case 'recensioni':
                        $oggetti = ObjectFactory::instance()->getOggetti();
                        $oggetto = $this->getOggettoPerIndice($oggetti, $request, $msg);
                        $vd->setSottoVista('recensioni');
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
                    case 'anagrafica':

                        $msg = array();
                        $this->aggiornaAnagrafica($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Anagrafica aggiornata");
                        $this->showHomeCliente($vd);
                        break;


                    case 'aggiungiCarrello':
                        // recuperiamo l'indice 
                        $msg = array();
                        $oggetti = ObjectFactory::instance()->getOggetti();
                        $a = $this->getOggettoPerIndice($oggetti, $request, $msg);
                        
                        if (isset($a)) {
                            $c = $this->creaCarrelloDaOggetto($a);
                            if (isset($c)){
                                $car = CarrelloFactory::instance()->nuovo2($c);
                            }
                            // if(isset($c)){}
                                //clase che mi decrementa il magazzino 
                                //Con update
                            
                            
                        } else {
                            $msg[] = "<li> Impossibile, Verifica la quantità del prodotto </li>";
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Hai aggiunto l'oggetto al carrello");
                        $this->showHomeCliente($vd);
                        break;

                    case 'cancella':
                        // recuperiamo l'indice 
                        $carrelli = CarrelloFactory::instance()->getCarrelli();
                        if (isset($request['carrello'])) {
                            $intVal = filter_var($request['carrello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod = $carrelli[$intVal];
                                if ($mod != null) {
                                    if (CarrelloFactory::instance()->cancella2($mod) != 1) {
                                        $msg[] = '<li> Impossibile cancellare l\'oggetto </li>';
                                    }
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Oggetto eliminato");
                            }
                        }
                        $carrelli = CarrelloFactory::instance()->getCarrelli();
                        $this->showHomeCliente($vd);
                        break;
                        
                    // case 'compra':
                        

                    default: $this->showHomeCLiente($vd);
                }
            } else {
                
                $user = UserFactory::instance()->cercaUtentePerId($_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }
        // includo la vista
        require 'view/master.php';
    }
      
    
    //Carica l'oggetto del database con l'indice passato
    private function getOggettoPerIndice(&$oggetti, &$request, &$msg) {
            if (isset($intVal) && $intVal > -1 && $intVal < count($oggetti)) {
                return $oggetti[$intVal];
            } else {
                $msg[] = "<li> L'oggetto specificato non esiste </li>";
                return null;
            }
       
    }
    
    //Carica l'oggetto del carrello con l'indice passato
    private function getCarrelloPerIndice(&$carrelli, &$request, &$msg) {
        if (isset($request['carrello'])) {
            // verifichiamo che sia un intero
            $intVal = filter_var($request['carrello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (isset($intVal) && $intVal > -1 && $intVal < count($carrelli)) {
                return $carrelli[$intVal];
            } else {
                $msg[] = "<li> L'oggetto specificato non esiste </li>";
                return null;
            }
        } else {
            $msg[] = '<li> Oggetto non specificato<li>';
            return null;
        }
    }

    
    //Aggiorno l'anagrafica
    protected function aggiornaAnagrafica($user, &$request, &$msg) {
        if (isset($request['via'])) {
            if (!$user->setVia($request['via'])) {
                $msg[] = '<li>La via specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['numero'])) {
            if (!$user->setNumCivico($request['numero'])) {
                $msg[] = '<li>Il formato del numero civico non &egrave; corretto</li>';
            }
        }
        if (isset($request['citta'])) {
            if (!$user->setCitta($request['citta'])) {
                $msg[] = '<li>La citt&agrave; specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['cap'])) {
            if (!$user->setCap($request['cap'])) {
                $msg[] = '<li>Il CAP specificato non &egrave; corretto</li>';
            }
        }

        if (isset($request['email'])) {
            if (!$user->setEmail($request['email'])) {
                $msg[] = '<li>L\'indirizzo email specificato non &egrave; corretto</li>';
            }
        }

        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (UserFactory::instance()->salva($user) != 1) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
    public function creaCarrelloDaOggetto(Object $a){
                                $carrello = new Carrello(
                                    20,
                                    $a->getNameObj(),
                                    $a->getPrice(),
                                    1,
                                    $a->getID3()); 
                                return $carrello;
                            }

    

}
?>

