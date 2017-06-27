<?php

	// ------------init--------------
	$speciesfile = findspeciesbyname ( $sp ["genus"], $sp ["species"] );
	
	$details = parsedatafile ( $speciesfile );
	
	$thislinko = currGuidePath () . "?view=ordo&ordo=" . $details ["ordo"];
	$thislinkc = currGuidePath () . "?view=classis&classis=" . $details ["classis"];
	
	$spc = substr ( $speciesfile, 0, strlen ( $speciesfile ) - 4 );
	$speima = $spc . "/" . $details ["picture"];
	$imalink = "picture.php?species=" . $spc;
	
	// sounds
	$snds = array ();
	$specfold = substr ( $speciesfile, 0, strlen ( $speciesfile ) - 4 );
	$pa = getcwd () . "/" . $specfold;
	
	// ???????????
	if (is_dir ( $pa )) {
		$snds = filelistbyext ( "mp3", $spc . "" );
		$imgs = filelistbyext ( "jpg", $spc . "" );
	}
	
	$links = array ();
	$links ["classis"] = $thislinkc;
	$links ["ordo"] = $thislinko;
	
	// --------------print-----------------
	
	?>

<h1><?php echo $details["hu_n"]; ?></h1>
<h2><?php echo $details["genus"] . ' ' . $details["species"];?></h2>

<div class="row">

	<div class="col-sm-6">

		<div class="panel panel-default">
			<div class="panel-body"><?php echo $details["hu_d"]; ?></div>
		</div>
			
			<?php
	if (count ( $snds ) > 0) {
		?>
			
			<div class="panel panel-default">
			<div class="panel-heading">
				Hangok <span class="badge"><?php echo count($snds);?></span>
			</div>
			<div class="panel-body">
				<?php
		printplaylist ( $snds, $specfold );
		?>
				</div>
		</div>
			<?php
	}
	?>
			
		</div>
	<div class="col-sm-6">
					
	<?php printcarousel($imgs, $specfold);?>
			
		</div>
</div>
