<?php
/* questa sarà la pagina per gestire l'autenticazioni e le autorizzazioni di tutte le pagine
Sara la nostra pagina FrontControll cioè il punto unico di accesso all'applicazione */

//error reporting
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

//include dei controller//
include_once 'controller/BaseController.php';
include_once 'controller/clientController.php';
include_once 'controller/sellerController.php';

date_default_timezone_set("Europe/Rome");


// punto unico di accesso all'applicazione
FrontController::dispatch($_REQUEST);


class FrontController {
    
    public static function dispatch(&$request) {
        
        // inizializziamo la sessione 
        session_start();
        if (isset($request["page"])) {
            switch ($request["page"]) {
                
                case "login":
                
                //pagina Login accessibile a tutti, per questo è controllata dal Base Controller
                    $controller = new BaseController();
                    $controller->handleInput($request);  
                    break;
                
                
                case 'client':
                    // la pagina dei clienti gestita dal clientController
                    
                    $controller = new clientController();
                    if (isset($_SESSION[BaseController::role]) &&
                        $_SESSION[BaseController::role] != User::Client) {   //User Client//
                        self::write403();                                     // crea una pagina di errore//
                    }                                                          //vedere se abbiamo bisogno di un amministratore//
                    $controller->handleInput($request);
                    break;
                
                // Venditori
                case 'seller':
                    //Pagina accessibile solo ai venditori controllata dal sellerController
                    $controller = new sellerController();
                    if (isset($_SESSION[BaseController::role]) &&
                        $_SESSION[BaseController::role] != User::Seller)  {    
                        self::write403();
                    }
                    $controller->handleInput($request);
                    break;
                default:
                    self::write404();
                    break;
            }
        } else {
            self::write404(); 
        }
    }
    
    
    /* Gli errori 404 e 403 saranno gestiti da queste due funzioni
     * e dalla pagina error.php apposita */
    
    // Crea una pagina di errore quando il path specificato non esiste
     public static function write404() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 404 Not Found');
        $titolo = "File non trovato!";
        $messaggio = "La pagina che hai richiesto non &egrave; disponibile";
        include_once('error.php');     //Includo la pagina direttamente nella funzione                                              
        exit();
    }
    
    //l'utente non ha i privilegi per accedere alla pagina
    public static function write403() {
        // impostiamo il codice della risposta http a 404 (file not found)
        header('HTTP/1.0 403 Forbidden');
        $titolo = "Accesso negato";
        $messaggio = "Non hai i diritti per accedere a questa pagina";
        $login = true;
        include_once('error.php');
        exit();
    }
}

?>

