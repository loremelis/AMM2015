<?php
include_once 'BaseController.php';

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
                //logout
                switch ($request["cmd"]) {
                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;
                    
                    case 'aggiungi_oggetto':
                    
                        $msg=array();
                        $nuovo = new Object();
                        $nuovo->setID(-1);
                        $this->updateObject($nuovo, $request, $msg);
                        $this->creaFeedbackUtente($msg, $vd, "Appello creato");
                        if (count($msg) == 0) {
                            $vd->setSottoPagina('cliente');
                            if (ObjectFactory::instance()->nuovo($nuovo) != 1) {
                                $msg[] = '<li> Impossibile creare l\'appello </li>';
                            }
                        }
                        //$appelli = ObjectFactory::instance()->getAppelliPerDocente($user);
                        $this->showHomeUtente($vd);   //Forse
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
    
    //aggiorna i dati del nuovo Oggetto
    //ASSOLUTAMENTE DA RIVEDERE
    public function updateObject($nuovo, $request, $msg) {

        if (isset($request['oggetto'])) {
            $oggetto = ObjectFactory::instance()->creaDaArray($request['oggetto']);
            if (isset($oggetto)) {
                $nuovo->setOggetto($oggetto);
            } else {
                $msg[] = "<li>Oggetto non aggiunto</li>";
            }
        
    }
        
    }
    
}
?>
