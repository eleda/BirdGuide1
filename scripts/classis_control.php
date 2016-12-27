<?php
	$con = $classis;
?>

<?php
	$kin = listds ( "regnum" );
	$phy = listds ( "phylum" );
	$cla = listds ( "subphylum" );
	$ord = listds ( "classis" );
	$sub = listds ( "ordo" );
	$sub = listds ( "familia" );
	
	$y = false;
	$specfiles = speciesfilelist ();

	$i = 0;
	while ( $i < count ( $specfiles ) && ! $y ) {
		$details = parsedatafile ( $specfiles [$i] );

		$reg = $details ["regnum"];
		$phy = $details ["phylum"];
		$sub = $details ["subphylum"];
		$cla = $details ["classis"];
		
		if ($cla == $con) {
			$y = true;
		}
		
		$i ++;
	}
	
	// print them
	
	$links = array ();
	$links ["classis"] = "";
	$links ["ordo"] = "";
	
	echo "<h2> Osztály: " . translateword ( $cla ) . " (" . $cla . ")</h2>";
	echo "<p><small>" . translateword ( $cla . ".d" ) . "</small></p>";
	
	$ordos = array ();
	
	// TODO attenni valahova mashova
	$SPE_DIR = 'spe';
	$dir = opendir ( getcwd () . '/' . $SPE_DIR );

	while ( (($fil = readdir ( $dir )) !== false) ) {
		if ((substr ( $fil, strlen ( $fil ) - 4 ) == ".spe") && ($fil != ".") && ($fil != "..")) {
			$file = fopen ( $SPE_DIR . '/' . $fil, "r" ) or exit ( "File error." );
			while ( ! feof ( $file ) ) {
				$mc = fgets ( $file );
				$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
				if (substr ( $mc, 0, 8 ) == "classis=") {
					$cla = substr ( $mc, 8 );
				}
				if (substr ( $mc, 0, 5 ) == "ordo=") {
					$ord = substr ( $mc, 5 );
				}
			}
			
			fclose ( $file );
			if ($cla == $con) {
				$y = true;
			}
			$exi = false;
			for($i = 0; $i < count ( $ordos ); $i ++) {
				if ($ordos [$i] == $ord) {
					$exi = true;
				}
			}
			if ($exi == false) {
				array_push ( $ordos, $ord );
			}
		}
	}
	?>
<div class="list-group">
		<?php
	for($i = 0; $i < count ( $ordos ); $i ++) {
		$thislink = currGuidePath () . "?view=ordo&ordo=" . $ordos [$i];
		
		echo "<a class='list-group-item' style='font-size: 20px;' href=" . $thislink . ">" . translateword ( $ordos [$i] ) . " (" . $ordos [$i] . ")</a>";
	}
	?>
		</div>
