
<?php
$con = $ordo;
?>

<?php
	
	// ---------------------init----------------------
	$files = speciesfilelist ();
	$familiae = array ();
	$all_species = array ();
	
	foreach ( $files as $fname ) {
		$sps = parsedatafile ( $fname );
		$ord = strtolower ( $sps ["ordo"] );
		$fam = strtolower ( $sps ["familia"] );
		
		if ($ord == strtolower ( $con )) {
			if (! in_array ( $fam, $familiae )) {
				array_push ( $familiae, $fam );
			}
			array_push ( $all_species, $fname );
		}
	}
	
	$links = array ();
	
	// ---------------print-----------------------
	
	?>


