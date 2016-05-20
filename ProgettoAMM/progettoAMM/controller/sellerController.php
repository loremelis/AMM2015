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
                    
                    // inserimento di una lista di appelli
                    case 'inserisci_oggetto':
                        //TUTTA DA FARE
                    // modifica di un appello
                    case 'modifica_oggetto':
                        //tutta da fare
                    
                }
            }
            // gestione dei comandi inviati dall'utente
            if (isset($request["cmd"])) {
                switch ($request["cmd"]) {
                    // logout
                    case 'logout':
                        $this->logout($vd);
                        break;
                    // modifica delle informazioni sull'indirizzo dell'ufficio
                   
                    /*case 'a_modifica':
                        $appelli = AppelloFactory::instance()->getAppelliPerDocente($user);
                        if (isset($request['appello'])) {
                            $intVal = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_appello = $this->cercaAppelloPerId($intVal, $appelli);
                                $insegnamenti = InsegnamentoFactory::instance()->getListaInsegnamentiPerDocente($user);
                                //$vd->setStato('a_modifica');
                            }
                        }
                        $this->showHomeUtente($vd);
                        break;
                    // salvataggio delle modifiche ad un appello esistente
                    case 'a_salva':
                        $msg = array();
                        if (isset($request['appello'])) {
                            $intVal = filter_var($request['appello'], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
                            if (isset($intVal)) {
                                $mod_appello = $this->cercaAppelloPerId($intVal, $appelli);
                                $this->updateAppello($mod_appello, $request, $msg);
                                if (count($msg) == 0 && AppelloFactory::instance()->salva($mod_appello) != 1) {
                                    $msg[] = '<li> Impossibile salvare l\'appello </li>';
                                }
                                $this->creaFeedbackUtente($msg, $vd, "Appello aggiornato");
                                if (count($msg) == 0) {
                                    $vd->setSottoPagina('appelli');
                                }
                            } 
                        } else {
                            $msg[] = '<li> Appello non specificato </li>';
                        }
                        $this->showHomeUtente($vd);
                        break; */
                    
            }
            } else {
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
    /**
     * Aggiorna i dati relativi ad un oggetto in base ai parametri specificati
     * dall'utente
     * TUTTA DA RIVEDERE
     */
    private function updateTabella($mod_tabella, &$request, &$msg) {
        if (isset($request['oggetto'])) {
            $oggetto = ObjectFactory::instance()->creaOggettoDaCodice($request['oggetto']);
            if (isset($oggetto)) {
                $mod_tabella->setOggetto($oggetto);
            } else {
                $msg[] = "<li>Oggetto non aggiunto</li>";
            }
        
    }
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
    
}
?>
