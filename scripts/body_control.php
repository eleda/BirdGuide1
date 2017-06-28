<?php

if (array_key_exists("view", $_GET)) {
    switch ($_GET ["view"]) {
        case "species" :
            include ('scripts/species_control.php');
            include ('templates/species_body.php');
            break;
        case "classis" :
            include ('scripts/classis_control.php');
            include ('templates/classis_body.php');
            break;
        case "ordo" :
            include ('scripts/ordo_control.php');
            include ('templates/ordo_body.php');
            break;
        case "search" :
            include ('scripts/results_control.php');
            break;
        default :
            include ('scripts/index_control.php');
            include ('templates/index_body.php');
    }
} else {
    include ('scripts/index_control.php');
    include ('templates/index_body.php');    
}
