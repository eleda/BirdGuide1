<?php
require_once('guide_vars.php');
require_once('guide_helper.php');
?>

<?php
include('scripts/header_control.php');
include('templates/header.php');
?>

<?php

if (array_key_exists ( "view", $_GET )) {
	switch ($_GET ["view"]) {
		case "species" :
			include ('scripts/species_control.php');
			break;
		case "classis" :
			include ('scripts/classis_control.php');
			break;
		case "ordo" :
			include ('scripts/ordo_control.php');
			break;
		case "search" :
			include ('scripts/results_control.php');
			break;
		default :
			include ('scripts/index_control.php');
	}
} else {
	include ('scripts/index_control.php');
}

?>

<?php
include('templates/footer.php');
?>