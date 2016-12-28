<?php

require_once('guide_vars.php');

// Get Current Root URL.
function curURL() {
	// ?t?rva:
	// return "http://ednetwork.uw.hu/";
	return "";
	// return "http://localhost/";
	/*
	 * $pageURL = 'http';
	 * if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 * $pageURL .= "://";
	 * if ($_SERVER["SERVER_PORT"] != "80") {
	 * $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
	 * } else {
	 * $pageURL .= $_SERVER["SERVER_NAME"];
	 * }
	 * return $pageURL;
	 */
}

// Get Current Guide URL.
function currGuidePath() {
	// return "";
	// return curURL() . "korny/guide/guide.php";
	return $_SERVER ["SCRIPT_NAME"];
}

// Parse line from a Data File
function parsedataline($lin) {
	$pieces = explode ( '=', trim( $lin ));

	return $pieces;
}

// Parse all data from a formatted Data FIle
function parsedatafile($filename) {

	$alldata = array ();
	
	$file = fopen ( $filename, "r" ) or exit ( "A file " . $filename . " is required." );
	
	while ( ! feof ( $file ) ) {
		$lin = fgets ( $file );
		
		$lin = substr ( $lin, 0, strlen ( $lin ) - 1 ); // for enter key
		
		if (strrpos ( $lin, "=" ) !== FALSE) {
			$pieces = parsedataline ( $lin );
			$alldata [strtolower ( $pieces [0] )] = $pieces [1];
		}
	}
	
	fclose ( $file );

	return $alldata;
}

// Find a value from a Data File
function findvalue($filename, $fnam, $side) {
	$alldata = array ();
	$fnam = strtolower ( $fnam );
	$side = strtolower ( $side );
	
	$file = fopen ( $filename, "r" ) or exit ( "A file " . $filename . " is required." );
	
	$fnd = false;
	$data = '?';
	
	while ( ! feof ( $file ) && ! $fnd ) {
		$lin = fgets ( $file );
		
		$lin = substr ( $lin, 0, strlen ( $lin ) - 2 ); // for enter key
		
		if (strrpos ( $lin, "=" ) !== FALSE) {
			$pieces = parsedataline ( strtolower ( $lin ) );
			
			if ($side == 'r') {
				$sid = $pieces [1];
				$osid = $pieces [0];
			} else {
				$sid = $pieces [0];
				$osid = $pieces [1];
			}
			
			if ($sid == $fnam) {
				$fnd = true;
				$data = $osid;
			}
		}
	}
	
	fclose ( $file );
	return $data;
}

// Translate Latin word.
function translateword2($latinword, $unkown_display, $bracket_latin) {
	$latinword = strtolower ( $latinword );
	
	$dl = 'hu';
	
	if ($unkown_display) {
		$unkown_sign = '?';
	} else {
		$unkown_sign = '';
	}
	
	// echo "Ezt a sz?t kell leford?tani:" . $latinword . ":";
	if (($latinword != "") && (is_string ( $latinword ))) {
		$dir = opendir ( getcwd () );
		$file = fopen ( $dl . ".dic", "r" ) or exit ( "A dictionary is required." );
		
		$y = false;
		while ( (! feof ( $file )) && ($y == false) ) {
			$mc = fgets ( $file );
			$mc = substr ( $mc, 0, strlen ( $mc ) - 1 );
			
			if (strlen ( $mc ) >= strlen ( $latinword )) {
				$leftside = strtolower ( substr ( $mc, 0, strlen ( $latinword ) + 1 ) );
				if ($leftside == ($latinword . "=")) {
					$found_word = substr ( $mc, strlen ( $latinword ) + 1 );
					
					if ($bracket_latin) {
						$kin = '(' . $found_word . ')';
					} else {
						$kin = $found_word;
					}
					
					$y = true;
				}
			}
		}
		
		fclose ( $file );
		
		if ($y == false) {
			$kin = $unkown_sign;
		}
	}
	
	return $kin;
}

// Translate Latin word (defaults).
function translateword($latinword) {
	return translateword2 ( $latinword, true, false );
}

// List all specific data.
function listds($ty) {
	$arr = array ();
	
	$specfiles = speciesfilelist ();
	
	foreach ( $specfiles as $fil ) {
		$details = parsedatafile ( $fil );
		array_push ( $arr, $details [$ty] );
	}
	
	return $arr;
}

// util.
function endswith($haystack, $needle) {
	// search forward starting from end minus needle length characters
	return $needle === "" || (($temp = strlen ( $haystack ) - strlen ( $needle )) >= 0 && strpos ( $haystack, $needle, $temp ) !== FALSE);
}

// File list.
function filelistbyext($ext, $dirr) {
	$files = array ();
	
	$dir = opendir ( getcwd () . '/' . $dirr );
	
	while ( ($fil = readdir ( $dir )) !== false ) {
		
		if (endswith ( $fil, "." . $ext ) && ($fil != ".") && ($fil != "..")) {
			array_push ( $files, $dirr . '/' . $fil );
		}
	}
	
	return $files;
}

// Specfillist
function speciesfilelist() {
	return filelistbyext ( "spe", 'spe' );
}

// Random generator
function randomGen($min, $max, $quantity) {
	$numbers = range ( $min, $max );
	shuffle ( $numbers );
	return array_slice ( $numbers, 0, $quantity );
}

// Randspecs.
function getrandomspecies($cnt) {
	$sps = speciesfilelist ();
	$rg = randomGen ( 0, count ( $sps ) - 1, $cnt );
	
	$rspecs = array ();
	
	foreach ( $rg as $rn ) {
		array_push ( $rspecs, $sps [$rn] );
	}
	
	return $rspecs;
}

// MEGV�LTOZOTT SZIGNAT�RA!!!!!!!!!!!!!!!!!!!!!!!
// Search a species file by data
function findspeciesbyname($fgenus, $fspecies) {
	$speciesfilename = "";
	
	$specfiles = speciesfilelist ();
	
	$i = 0;
	$found = false;
	
	while ( $i < count ( $specfiles ) - 1 && ! $found ) {
		
		$fil = $specfiles [$i];
		$spdata = parsedatafile ( $fil );
		$genus = $spdata ["genus"];
		$species = $spdata ["species"];
		
		if ($genus == $fgenus && $species == $fspecies) {
			$speciesfilename = $fil;
			$found = true;
		}
		
		$i ++;
	}
	
	return $speciesfilename;
}
function listallregnaitems() {
	$items = array ();
	
	$regnums = array ();
	$phylums = array ();
	$subphylums = array ();
	$classises = array ();
	
	$shtphylums = array ();
	$shtsubphylums = array ();
	$shtclassises = array ();
	
	$files = speciesfilelist ();
	
	foreach ( $files as $fname ) {
		
		$spdata = parsedatafile ( $fname );
		
		$reg = $spdata ["regnum"];
		$phy = $spdata ["phylum"];
		$sub = $spdata ["subphylum"];
		$cla = $spdata ["classis"];
		
		$rootphy = $reg . "|" . $phy;
		$rootsub = $rootphy . "|" . $sub;
		$rootcla = $rootsub . "|" . $cla;
		
		// insert all elements once
		
		$exi = false;
		
		for($i = 0; $i < count ( $regnums ); $i ++) {
			if ($regnums [$i] == $reg) {
				$exi = true;
			}
		}
		
		if ($exi == false) {
			array_push ( $regnums, $reg );
		}
		
		$exi = false;
		
		for($i = 0; $i < count ( $phylums ); $i ++) {
			if ($phylums [$i] == $rootphy) {
				$exi = 1;
			}
		}
		
		if ($exi == 0) {
			array_push ( $phylums, $rootphy );
			array_push ( $shtphylums, $phy );
		}
		
		$exi = false;
		
		for($i = 0; $i < count ( $subphylums ); $i ++) {
			if ($subphylums [$i] == $rootsub) {
				$exi = 1;
			}
		}
		
		if ($exi == 0) {
			array_push ( $subphylums, $rootsub );
			array_push ( $shtsubphylums, $sub );
		}
		
		$exi = false;
		for($i = 0; $i < count ( $classises ); $i ++) {
			if ($classises [$i] == $rootcla) {
				$exi = 1;
			}
		}
		
		if ($exi == 0) {
			array_push ( $classises, $rootcla );
			array_push ( $shtclassises, $cla );
		}
	}
	
	$items ["regnum"] = $regnums;
	$items ["phlyum"] = $phylums = array ();
	$items ["subphylum"] = $subphylums = array ();
	$items ["classis"] = $classises = array ();
	
	$items ["phlyum_path"] = $shtphylums = array ();
	$items ["subphylum_path"] = $shtsubphylums = array ();
	$items ["classis_path"] = $shtclassises = array ();
}

// Get Search Data.
function search($f) {
	$ret = array ();
	$results_list = array ();
	
	$files = speciesfilelist ();
	$fnd = 0;
	
	setcookie ( "sresult", $f, time () + 3600 );
	
	foreach ( $files as $fname ) {
		$rsp = parsedatafile ( $fname );
		
		$curr_species = $rsp ['species'];
		
		$hun = $rsp ["hu_n"];
		$gen = $rsp ["genus"];
		$spe = $curr_species;
		
		$poshun = strpos ( strtolower ( $hun ), strtolower ( $f ) );
		$posgen = strpos ( strtolower ( $gen ), strtolower ( $f ) );
		$posspe = strpos ( strtolower ( $spe ), strtolower ( $f ) );
		
		if (($posgen !== false) || ($posspe !== false) || ($poshun !== false)) {
			array_push ( $results_list, $fname );
			$fnd ++;
		}
	}
	
	$ret ['success'] = 1;
	$ret ['count'] = $fnd;
	
	$ret ['results'] = $results_list;
	
	return $ret;
}

// Generate a species image box.
function printspeciesthumb($rfile) {

	$ritem = parsedatafile ( $rfile );

	$npref = substr ( $rfile, 0, strlen ( $rfile ) - 4 );
	$hun = $ritem ['hu_n'];
	$gen = $ritem ['genus'];
	$spe = $ritem ['species'];
	$ord = $ritem ['ordo'];
	$fam = $ritem ['familia'];
	$picfile = $npref . '/' . $ritem ['picture'];
	
	if (file_exists ( $picfile )) {
		$paintfile = $picfile;
	} else {
		$paintfile = "images/genbrd.png";
	}

	$species_link = currGuidePath () . "?view=species&genus=" . $gen . "&species=" . $spe;
	$thislinko = currGuidePath () . "?view=ordo&ordo=" . $ord;
	$thislinkc = currGuidePath () . "?view=classis&classis=" . $ritem ["classis"];

	?>

	<?php include ('templates/fragments/speciesthumb.php'); ?>

<?php
}

// Print Search Results.
function printresultslist($f) {
	$src = search ( $f );
	$results = $src ['results'];
	$count = $src ['count'];
	
	?>
	<?php include ('templates/fragments/resultslist.php'); ?>

<?php
}


// Generate image viewer
function printcarousel($files, $pa) {
	?>
	<?php include ('templates/fragments/carousel.php'); ?>
<?php
}

// Generate a playlist.
function printplaylist($files, $pa) {
	?>
	<?php include ('templates/fragments/playlist.php'); ?>

<?php
}



// Generate random species
function printrandomsps() {
	$randspec = getrandomspecies ( 4 );
	
	foreach ( $randspec as $onespec ) {
		printspeciesthumb ( $onespec );
	}
}

?>