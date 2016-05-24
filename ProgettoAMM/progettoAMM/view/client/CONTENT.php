<?php
switch ($vd->getSottoVista()) {
    case 'cliente':
        include_once 'client.php';
        break;
    case 'anagrafica':
        include_once 'anagrafica.php';
        break;
    case 'carrello':
        include_once 'carrello.php';
        break;
    case 'home':
        include_once 'home.php';
        break;
    default: 
        include_once 'home.php';
}
?>     