<?php
// ------------init--------------
$speciesfile = findspeciesbyname($sp ["genus"], $sp ["species"]);

$details = parsedatafile($speciesfile);

$thislinko = currGuidePath() . "?view=ordo&ordo=" . $details ["ordo"];
$thislinkc = currGuidePath() . "?view=classis&classis=" . $details ["classis"];

$spc = substr($speciesfile, 0, strlen($speciesfile) - 4);
$speima = $spc . "/" . $details ["picture"];
$imalink = "picture.php?species=" . $spc;

// sounds
$snds = array();
$specfold = substr($speciesfile, 0, strlen($speciesfile) - 4);
$pa = getcwd() . "/" . $specfold;

if (is_dir($pa)) {
    $snds = filelistbyext("mp3", $spc . "");
    $imgs = filelistbyext("jpg", $spc . "");
}

$links = array();
$links ["classis"] = $thislinkc;
$links ["ordo"] = $thislinko;

// --------------print-----------------
?>


