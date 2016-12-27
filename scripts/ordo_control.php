
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
<h2>Rend: <?php echo translateword($con) . " (" . $con . ")"; ?></h2>

<?php
	
	$ordodesc = translateword ( $con . ".d" );
	
	if ($ordodesc != "?") {
		?>
<p><?php echo $ordodesc;?></p>
<?php
	}
	
	?>
	
	<?php
	
	// LIST ALL ORDO ITEMS
	foreach ( $familiae as $fam ) {
		?>
<h3>Család: <?php echo translateword($fam); ?> (<?php echo $fam;?>) </h3>

<?php
		$famdesc = translateword ( $fam . ".d" );
		
		if ($famdesc != "?") {
			?>
<p><?php echo $famdesc; ?></p>
<?php
		}
		
		?>

<div class="row">
		
		<?php
		foreach ( $all_species as $spe ) {
			
			$fami = strtolower ( findvalue ( $spe, "familia", "l" ) );
			
			if ($fami == $fam) {
				printspeciesthumb ( $spe );
			}
		}
		?>
		</div>

<?php
	}

