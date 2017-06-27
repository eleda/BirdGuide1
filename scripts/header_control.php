<?php

// COOKIES
$val = "";
if (array_key_exists ( "view", $_GET )) {
	switch ($_GET ["view"]) {
		case "species" :
			$sp ["genus"] = $_GET ["genus"]; // 5
			$sp ["species"] = $_GET ["species"]; // 7
			$val = isset($_COOKIE["sval"]) ? $_COOKIE ["sval"] : "";
			break;
		case "classis" :
			$classis = $_GET ["classis"];
			$val = isset($_COOKIE["sval"]) ? $_COOKIE ["sval"] : "";
			break;
		case "ordo" :
			$ordo = $_GET ["ordo"];
			$val = isset($_COOKIE["sval"]) ? $_COOKIE ["sval"] : "";
			break;
		case "search" :
			$resu = $_GET ["search"];
			$val = $resu;
			setcookie ( "sval", $resu, time () + (86400 * 30), "/" );
			break;
		default :
	}
}

$sp ["n"] = "";
$sp ["d"] = "";
$sp ["s"] = "";
$sp ["p"] = "";
$sp ["speciesfile"] = "";

// random species
$onerandspec = getrandomspecies ( 1 );
$onerandspec = $onerandspec [0];

$onerandspecdet = parsedatafile ( $onerandspec );

$onerandgenus = $onerandspecdet ["genus"];
$onerandspecies = $onerandspecdet ["species"];

// links
$clalink = currGuidePath () . "?view=classis&classis=Aves";
$randspelink = currGuidePath () . "?view=species&genus=" . $onerandgenus . "&species=" . $onerandspecies;

?>
