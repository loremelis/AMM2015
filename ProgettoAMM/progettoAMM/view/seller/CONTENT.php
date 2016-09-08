<?php
switch ($vd->getSottoVista()) {
    case 'cliente':
        include_once 'cliente.php';
        break;
    case 'venditore':
        include_once 'venditore.php';
        break;
    case 'home':
        include_once 'home.php';
        break;
    case 'info':
        include_once 'info.php';
        break;
    default:
        include_once 'home.php';
}
?>
     