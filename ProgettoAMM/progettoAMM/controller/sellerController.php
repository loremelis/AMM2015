<?php
include_once 'BaseController.php';
include_once 'model/ObjectFactory.php';

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
                        $oggetti = ObjectFactory::instance()->getListaOggetti();
                        $vd->setSottoVista('cliente');
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
                }
            }
            
            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {
                 
                switch ($request["cmd"]) {
                    
                    case 'logout':
                        $this->logout($vd);
                        break;
                    
                    case 'aggiungiOggetto':
                        
                        //var_dump($request);
                        //die();
                        //$msg[] = 'msg';
                        //$oggetto = new Object();
                       $msg= $this->aggiungiOggetto($request);
                        $oggetto = ObjectFactory::instance()->nuovo($request);
                        $this->creaFeedbackUtente($msg, $vd, "Oggetto aggiunto al database");
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

    /**
     * Calcola l'id per un nuovo oggetto
     */
    private function prossimoIdOggetto(&$oggetto) {
        $max = -1;
        foreach ($oggetto as $o) {
            if ($o->getId() > $max) {
                $max = $o->getId();
            }
        }
        return $max + 1;
    }
    
    protected function aggiungiOggetto($request) {
        $msg=array();
        if (isset($request['nome_ogg'])) {
          //  if (!$oggetto->setNomeObj($request['nome_ogg'])) {
                $msg[] = '<li>La via specificata non &egrave; corretta</li>';
           // }
        }
        if (isset($request['foto_ogg'])){ 
           // if (!$oggetto->setImage($request['foto_ogg'])) {
                $msg[] = '<li>Il formato del numero civico non &egrave; corretto</li>';
          //  }
        }
        if (isset($request['prezzo_ogg'])) {
           // if (!$oggetto->setPrice($request['prezzo_ogg'])) {
                $msg[] = '<li>La citt&agrave; specificata non &egrave; corretta</li>';
           // }
        }
        if (isset($request['quantita_ogg'])) {
          //  if (!$oggetto->setAmount($request['quantita_ogg'])) {
                $msg[] = '<li>Il CAP specificato non &egrave; corretto</li>';
          //  }
        }
       
        if (isset($request['descrizione_ogg'])) {
          //  if (!$oggetto->setDescription($request['descrizione_ogg'])) {
                $msg[] = '<li>L\'indirizzo email specificato non &egrave; corretto</li>';
          //  }
        }
        return $msg;
      }
        
    
    
    
    
}
?>
