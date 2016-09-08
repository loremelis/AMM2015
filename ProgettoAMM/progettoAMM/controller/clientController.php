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
                        $carrelli = CarrelloFactory::instance()->getListaCarrello();
                        $vd->setSottoVista('carrello');
                        break;

                    case 'client':
                        $oggetti = ObjectFactory::instance()->getListaOggetti();
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
                    case 'anagrafica':

                        $msg = array();
                        $this->aggiornaAnagrafica($user, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Anagrafica aggiornata");
                        $this->showHomeCliente($vd);
                        break;


                    case 'aggiungiCarrello':
                        // recuperiamo l'indice 
                        $msg = array();
                        $oggetti = ObjectFactory::instance()->getListaOggetti();
                       
                        $a = $this->getOggettoPerIndice($oggetti, $request, $msg);
                         
                        if (isset($a)) {
                          //  var_dump($a->getNameObj());
                            $carrello = new Carrello(
                                    '',
                                    $a->getNameObj(),
                                    $a->getPrice(),
                                    '1',
                                    $a->getID()); //Questo uno da rivedere perchè deve aggiungersi
                            $c = CarrelloFactory::instance()->nuovo($carrello);
                            if(isset($c)){
                                //clase che mi decrementa il magazzino 
                                //Con update
                            }
                            
                        } else {
                            $msg[] = "<li> Impossibile, Verifica la quantità del prodotto </li>";
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Hai aggiunto l'oggetto al carrello");
                        $this->showHomeCliente($vd);
                        break;

                    case 'cancella':
                        // recuperiamo l'indice 
                        
                        $msg = array();
                        $a = $this->getCarrelloPerIndice($carrelli, $request, $msg);
                        if (isset($a)) {
                            $c = CarrelloFactory::instance()->cancella($a);
                            //Funzione che aumenta la quantita di prodotti nella tabella clienti in base a quanto era nel carrello
                        } else {
                            $msg[] = "<li> Impossibile, Verifica la quantità del prodotto </li>";
                        }
                        $this->creaFeedbackUtente($msg, $vd, "Hai cancellato correttamente l'oggetto");
                        $this->showHomeCliente($vd);
                        break;

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

    private function getOggettoPerIndice(&$oggetti, &$request, &$msg) {
        if (isset($request['oggetto'])) {
            // verifichiamo che sia un intero
            $intVal = filter_var($request['oggetto'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (isset($intVal) && $intVal > -1 && $intVal < count($oggetti)) {
                return $oggetti[$intVal];
            } else {
                $msg[] = "<li> L'oggetto specificato non esiste </li>";
                return null;
            }
        } else {
            $msg[] = '<li> Oggetto non specificato<li>';
            return null;
        }
    }
    
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
        if (isset($request['civico'])) {
            if (!$user->setNumCivico($request['civico'])) {
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

    

}
?>

