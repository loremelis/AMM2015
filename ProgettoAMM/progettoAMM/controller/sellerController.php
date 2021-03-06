<?php
include_once 'BaseController.php';
include_once 'model/ObjectFactory.php';
include_once 'model/Object.php';

//Gestisce il Venditore
class sellerController extends BaseController {
    public function __construct() {
        parent::__construct();
    }
    
    //gestisce gli input utente
    public function handleInput(&$request) {
        // creo il descrittore della vista
        $vd = new ViewDescriptor();
        // imposto la pagina
        $vd->setVista($request['page']);

        if (!$this->loggedIn()) {
            // utente non autenticato, rimando alla home
            $this->showLoginPage($vd);
        } else {
            
            $user = UserFactory::instance()->cercaUtentePerId($_SESSION[BaseController::user], $_SESSION[BaseController::role]);
            
            //gestisco le sottopagine da visualizzare
            if (isset($request["subpage"])) {
                switch ($request["subpage"]) {
                    // modifica dei dati anagrafici
                    case 'venditore':
                        
                        $vd->setSottoVista('venditore');
                        break;
                    
                    case 'cliente': 
                        $oggetti = ObjectFactory::instance()->getOggetti();
                        $vd->setSottoVista('cliente');
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
                }
            }
            
            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {
                 
                switch ($request["cmd"]) {
                    
                    case 'logout':
                        $this->logout($vd);
                        break;
                    
                    case 'aggiungiOggetto':
                        $msg = array();
                        $nuovo = new Object('-1','','','','','');
                        $this->aggiungiOggetto($nuovo, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Oggetto creato");
                        if (count($msg) == 0) {
                            if (ObjectFactory::instance()->nuovo($nuovo) != 1) {
                                $msg[] = '<li> Impossibile creare l\'oggetto </li>';
                            }
                        }
                        $oggetti = ObjectFactory::instance()->getOggetti();
                        $this->showHomeVenditore($vd);
                        break;
                        
                    case 'cancellaOggetto':
                        $oggetti = ObjectFactory::instance()->getOggetti();   
                        if (isset($request['oggetto'])) {
                            $intVal = filter_var($request['oggetto'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $ogg = $oggetti[$intVal];
                                if ($ogg != null) {
                                    if (ObjectFactory::instance()->cancella($ogg) != 1) {
                                        $msg[] = '<li> Impossibile cancellare l\'oggetto </li>';
                                    }
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Oggetto eliminato");
                            }
                        }
                        $oggetti = ObjectFactory::instance()->getOggetti();
                        $this->showHomeVenditore($vd);
                        break;
                                          
            }
            } else {
                
                $user = UserFactory::instance()->cercaUtentePerId(
                        $_SESSION[BaseController::user], $_SESSION[BaseController::role]);
                $this->showHomeUtente($vd);
            }
        }
        // richiamo la vista
        require basename(__DIR__) . '/../view/master.php';
    }

    
    protected function aggiungiOggetto(Object $oggetto, $request, $msg) {
        
        if (isset($request['nome_ogg'])) {
            if (!$oggetto->setNameObj($request['nome_ogg'])) {
                $msg[] = '<li>Il nome specificato non &egrave; corretta</li>';
            }
        }
        if (isset($request['foto_ogg'])){ 
            if (!$oggetto->setImage($request['foto_ogg'])) {
                
                $msg[] = '<li>La foto specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['prezzo_ogg'])) {
            if (!$oggetto->setPrice($request['prezzo_ogg'])) {
                $msg[] = '<li>Il prezzo specificato non &egrave; corretto</li>';
            }
        }
        if (isset($request['quantita_ogg'])) {
           if (!$oggetto->setAmount($request['quantita_ogg'])) {
                $msg[] = '<li>La quantit&agrave non &egrave; corretta</li>';
            }
        }
       
        if (isset($request['descrizione_ogg'])) {
            if (!$oggetto->setDescription($request['descrizione_ogg'])) {
                $msg[] = '<li>La descrizione specificata non &egrave; corretta</li>';
            }
        }
        return $msg;
      } 

    
    
    private function getOggettoPerIndice(&$oggetti, &$request, &$msg) {
        if (isset($request['oggetto'])) {
            // verifichiamo che sia un intero
            $intVal = filter_var($request['oggetto'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
            if (isset($intVal)) {
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
}

?>
