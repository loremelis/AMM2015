<?php

//CONTROLLER che gestisce gli utenti non loggati

include_once 'view/ViewDescriptor.php';
include_once 'model/UserFactory.php';
include_once 'model/User.php';
include_once 'model/UserClient.php';
include_once 'model/UserSeller.php';   

 
class BaseController {
    const user = 'user';
    const role = 'role';

    public function __construct() {
        
    }
    
    // Metodo per gestire l'input dell'utente. Le sottoclassi lo sovrascrivono
     
    public function handleInput(&$request) {   

        $vd = new ViewDescriptor();
        // imposto la pagina
        
        $vd->setVista($request['page']);      
               
        if (isset($request["cmd"])) {
              
            switch ($request["cmd"]) {
            
                case 'login':
               
                   $username = $request['user'];
                   $password = $request['password'];
		   $this->login($vd, $username, $password);
                     
              		
                    if ($this->loggedIn()) {
                        $user = UserFactory::instance()->cercaUtentePerId($_SESSION[self::user], $_SESSION[self::role]);
                    
                    }
					
                    break;
                case 'logout':
                        $this->logout($vd);
                        break;
                
                default : 
                $this->showLoginPage();
               
            	break;
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
    
//Gestisce la visualizzazione della pagina Home
    public function handleInput2(&$request) {
        
        $vd = new ViewDescriptor();
        // imposto la pagina
        
        $vd->setVista($request['page']);      

        $this->showHomePage($vd);
        
        // richiamo la vista
        require 'view/master.php';
    }
    
 //Gestisce la visualizzazione della pagina Info
    public function handleInput3(&$request) {
        
        $vd = new ViewDescriptor();
        // imposto la pagina
        
        $vd->setVista($request['page']);      
        
       
        
        $this->showInfoPage($vd);
        
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
    
    protected function showHomeCliente($vd) {
        $vd->setTitolo("Lollosfilm - gestione Cliente ");
        $vd->setHeaderFile('view/client/HEADER.php');
        $vd->setContentFile('view/client/CONTENT.php');
        $vd->setFooterFile('view/client/FOOTER.php');
       
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
                $this->showHomeCliente($vd);
                break;
            case User::Venditore:
                $this->showHomeVenditore($vd);
                break;
        }
    }

    
    //Autenticazione
    protected function login($vd, $username, $password) {
		
        // carichiamo i dati dell'utente
        $user = UserFactory::instance()->caricaUtente($username, $password);
        
		 if (isset($user) && $user->esiste()) {
            // utente autenticato
            $_SESSION[self::user] = $user->getID2();  
            $_SESSION[self::role] = $user->getRuolo();
            $this->showHomeUtente($vd);
        } else {
            $vd->setMessaggioErrore("Utente sconosciuto o password errata");
            $this->showLoginPage($vd);
        }
        
       
    }
    
    
    //Procedura logout
    protected function logout($vd) {
        
        $_SESSION = array();
        // termino la validita' del cookie di sessione
        if (session_id() != '' || isset($_COOKIE[session_name()])) {
            
            setcookie(session_name(), '', time() - 2032016, '/');
        }
        // distruggo il file di sessione
        session_destroy();
        $this->showLoginPage($vd);
    }
    
    
    
    
    //Messaggio di FeedBack
    protected function creaFeedbackUtente(&$msg, $vd, $okMsg) {
        if (count($msg) > 0) {
            
            $error = "Si sono verificati i seguenti errori \n<ul>\n";
            foreach ($msg as $m) {
                $error = $error . $m . "\n";
            }
            // imposto il messaggio di errore
            $vd->setMessaggioErrore($error);
        } else {
            
            $vd->setMessaggioConferma($okMsg);
        }
    }

      
    //visualizzazione Home
    protected function showHomePage($vd) {       
        // mostro la pagina di login
        $vd->setTitolo("lollosfilm - home");
        $vd->setHeaderFile('view/home/HEADER.php');
        $vd->setContentFile('view/home/CONTENT.php');
        $vd->setFooterFile('view/home/FOOTER.php');
    }

    public function showInfoPage($vd) {
        // mostro la pagina di login
        $vd->setTitolo("lollosfilm - home");
        $vd->setHeaderFile('view/info/HEADER.php');
        $vd->setContentFile('view/info/CONTENT.php');
        $vd->setFooterFile('view/info/FOOTER.php');
        
        
    }

}


