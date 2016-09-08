<?php
switch ($vd->getSottoVista()) {
    case 'client':
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
    case 'info':
        include_once 'info.php';
        break;
    default: 
        include_once 'home.php';
        break;
}
?>  