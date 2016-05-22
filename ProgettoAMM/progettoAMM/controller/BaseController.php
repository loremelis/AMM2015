<?php

//CONTROLLER che gestisce gli utenti non loggati

include_once 'view/ViewDescriptor.php';
include_once 'model/UserFactory.php';
include_once 'model/User.php';
include_once 'model/UserClient.php';
include_once 'model/UserSeller.php';   

 /* Controller che gestisce gli utenti non autenticati, 
 * fornendo le funzionalita' comuni anche agli altri controller
 */
class BaseController {
    const user = 'user';
    const role = 'role';
    const impersonato = '_imp';
    
    
    public function __construct() {
        
    }
    
    // Metodo per gestire l'input dell'utente. Le sottoclassi lo sovrascrivono
     
    public function handleInput(&$request) {   
        
        $vd = new ViewDescriptor();
        // imposto la pagina
        
        $vd->setVista($request['page']);      
        
        // imposto il token per impersonare un utente
        $this->setImpToken($vd, $request);        
        
        // gestion dei comandi
        
        if (isset($request["cmd"])) {
            
            switch ($request["cmd"]) {
                case 'login':
                    $username = isset($request['user']) ? $request['user'] : '';
                    $password = isset($request['password']) ? $request['password'] : '';
                    $this->login($vd, $username, $password);
                    
              
                    if ($this->loggedIn()) {
                        $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
                    }
                    break;
                default : $this->showLoginPage();
            }
        } else {
            if ($this->loggedIn()) {
                //utente autenticato
                //imposta la pagina principale dell'utente
                $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
                $this->showHomeUtente($vd);
            } else {
                // utente non autenticato
                $this->showLoginPage($vd);
            }
        }
        // richiamo la vista
        require 'view/master.php';
    }
    
    // Verifica se l'utente sia correttamente autenticato
     
    protected function loggedIn() {
        return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
    }
    
    //Imposta la vista master.php per visualizzare la pagina di login
    
    protected function showLoginPage($vd) {       
        // mostro la pagina di login
        $vd->setTitolo("lollosfilm - login");
        $vd->setHeaderFile('view/login/HEADER.php');
        $vd->setContentFile('view/login/CONTENT.php');
        $vd->setFooterFile('view/login/FOOTER.php');
    }
    
    //Funzione che imposta la vista del Cliente
    
    protected function showHomeCLiente($vd) {
        
        $vd->setTitolo("Lollosfilm - gestione Cliente ");
        $vd->setHeaderFile('view/client/HEADER.php');
        $vd->setContentFile('view/client/CONTENT.php');
        $vd->setFooterFile('view/cient/FOOTER.php');
       
    }
    
    //Funzione dche imposta la vista del Venditore
    protected function showHomeVenditore($vd) {
        
        $vd->setTitolo("Lollosfilm - gestione venditore ");
        $vd->setHeaderFile('view/seller/HEADER.php');
        $vd->setContentFile('view/seller/CONTENT.php');
        $vd->setFooterFile('view/seller/FOOTER.php');
       
    }
    
    
    // Funziona che decide che pagina mostrare a seconda del l'Utente
    protected function showHomeUtente($vd) {
        $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
        switch ($user->getRuolo()) {
            case User::Cliente:
                $this->showHomeCLiente($vd);
                break;
            case User::Venditore:
                $this->showHomeVenditore($vd);
                break;
            case User::Amministratore:
                $this->showHomeAmministratore($vd);
                break;
            
            //DA CONTROLLARE
        }
    }
    
    
    
    protected function setImpToken(ViewDescriptor $vd, &$request) {
        if (array_key_exists('_imp', $request)) {
            $vd->setImpToken($request['_imp']);
        }
    }
    
    //Autenticazione
    protected function login($vd, $username, $password) {
        // carichiamo i dati dell'utente
        $user = UserFactory::instance()->caricaUtente($username, $password);
        if (isset($user) && $user->esiste()) {
            
            // utente autenticato
            $_SESSION[self::user] = $user->getId();
            $_SESSION[self::role] = $user->getRuolo();
            $this->showHomeUtente($vd);
        } else {
            $vd->setMessaggioErrore("Utente sconosciuto o password errata");
            $this->showLoginPage($vd);
        }
    }
    
    
    //Procedura logout
    protected function logout($vd) {
        // reset array $_SESSION
        $_SESSION = array();
        // termino la validita' del cookie di sessione
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            
            setcookie(session_name(), '', time() - 2032016, '/');
        }
        // distruggo il file di sessione
        session_destroy();
        $this->showLoginPage($vd);
    }
    
    //DA RIVEDERE E PROBABILMENTE DA SPOSTARE IN CLIENT CONTROLLER
    //Aggiorno l'anagrafica
    protected function aggiornaAnagrafica($user, &$request, &$msg) {
        if (isset($request['via'])) {
            if (!$user->setVia($request['via'])) {
                $msg[] = '<li>La via specificata non &egrave; corretta</li>';
            }
        }
        if (isset($request['civico'])) 
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
        
        if (isset($request['pass1']) && isset($request['pass2'])) {
            if ($request['pass1'] == $request['pass2']) {
                if (!$user->setPassword($request['pass1'])) {
                    $msg[] = '<li>Il formato della password non &egrave; corretto</li>';
                }
            } else {
                $msg[] = '<li>Le due password non coincidono</li>';
            }
        }
        
        // salviamo i dati se non ci sono stati errori
        if (count($msg) == 0) {
            if (UserFactory::instance()->salva($user) != 1) {
                $msg[] = '<li>Salvataggio non riuscito</li>';
            }
        }
    }
    
    
    //Messaggio di FeedBack
    protected function creaFeedbackUtente(&$msg, $vd, $okMsg) {
        if (count($msg) > 0) {
            // ci sono messaggi di errore nell'array,
            // qualcosa e' andato storto...
            $error = "Si sono verificati i seguenti errori \n<ul>\n";
            foreach ($msg as $m) {
                $error = $error . $m . "\n";
            }
            // imposto il messaggio di errore
            $vd->setMessaggioErrore($error);
        } else {
            // non ci sono messaggi di errore, la procedura e' andata
            // quindi a buon fine, mostro un messaggio di conferma
            $vd->setMessaggioConferma($okMsg);
        }
    }
}
