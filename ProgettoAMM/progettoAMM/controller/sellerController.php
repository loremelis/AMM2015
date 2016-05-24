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
        // imposto il token per impersonare un utente (nel lo stia facendo)
        $this->setImpToken($vd, $request);
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
                    
                    // aggiunta di un elemento nella tabella
                   
                    /* case 'aggiungi_elemento':
                     * break;
                     */
                      
                    // case salva elemento 
                    
                    /* case 'a_salva':
                        $msg = array();
                        
                        $this->showHomeUtente($vd);
                        break; */
                    
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
     * Aggiorna i dati relativi ad un oggetto in base ai parametri specificati
     * dall'utente
     * TUTTA DA RIVEDERE
     
    private function updateTabella($mod_tabella, &$request, &$msg) {
        if (isset($request['oggetto'])) {
            $oggetto = ObjectFactory::instance()->creaOggettoDaCodice($request['oggetto']);
            if (isset($oggetto)) {
                $mod_tabella->setOggetto($oggetto);
            } else {
                $msg[] = "<li>Oggetto non aggiunto</li>";
            }
        
    }
    } */
    
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
    
    //private function aggiungiElemento(){}
    //private funciotn salvaElemento(){}
    
}
?>
