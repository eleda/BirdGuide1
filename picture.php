<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
<title>Picture Viewer</title>

<script type="text/javascript">
function changepic(fil)
{
document.getElementById("pic").src=fil;
}
</script>

<link href="guide.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php
function curURL() {
	// �t�rva:
	return "http://edweb.p8.hu/";
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
function curpurl() {
	return curURL () . "guide/picture.php";
	// . $_SERVER["SCRIPT_NAME"];
}

// EL�K�SZ�T�S:
$sp ["species"] = $_GET ["species"]; // 7

$dir = opendir ( getcwd () );
{
	$file = fopen ( $sp ["species"] . ".spe", "r" ) or exit ( "Species file not found." );
	while ( ! feof ( $file ) ) {
		$mc = fgets ( $file );
		$mc = substr ( $mc, 0, strlen ( $mc ) - 2 );
		
		if (substr ( $mc, 0, 8 ) == "genus=") {
			$gen = substr ( $mc, 8 );
		}
		if (substr ( $mc, 0, 8 ) == "species=") {
			$spe = substr ( $mc, 8 );
		}
		if (substr ( $mc, 0, 8 ) == "picture=") {
			$pic = substr ( $mc, 8 );
		}
	}
	fclose ( $file );
	
	// K�PEK MEGJELEN�T�SE ALUL
	
	$pics = array ();
	$di = getcwd () . "/" . $sp ["species"];
	$dir = opendir ( $di );
	
	while ( ($fil = readdir ( $dir )) !== false ) {
		if ((strtolower ( substr ( $fil, strlen ( $fil ) - 4 ) ) == ".jpg") && ($fil != ".") && ($fil != "..")) {
			array_push ( $pics, $fil );
		}
	}
}

echo "<table width=300 border=0>";
echo "  <tr>";
echo "    <td>";
$pfi = $sp ["species"] . "/" . $pic;
echo "<img src=" . $pfi . " name=p1 width=598 height=488 id='pic'/>";
echo "</td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td>";
// <img src=fricoe/main.jpg width=201 height=149 onclick='changepic()'>

if (count ( $pics ) > 0) {
	
	// echo "<ul>";
	
	for($i = 0; $i < count ( $pics ); $i ++) {
		// echo "<li>" . $pics[$i] . "</li>";
		
		$chpic = $sp ["species"] . "/" . $pics [$i];
		echo "<img src=" . $sp ["species"] . "/" . $pics [$i] . " width='150' height='120'
 onclick='changepic(" . chr ( 34 ) . $chpic . chr ( 34 ) . ")'/>";
		
		if ($i != 0) {
			
			if (($i / 4) == intval ( $i / 4 )) {
				echo "</br>";
			}
		}
		
		// $pat = curURL() . "/guide/video.php?file=" . $specfold . "/" . $snds[$i];
		// echo "<li><a href=". $pat .
		// " onClick=" . chr(34) . "return popup(this, 'Video')" . chr(34) . ">" .
		// $snds[$i] . "</a></li>";
	}
	// echo "</ul>";
}

echo "</td>";
echo "  </tr>";
echo "</table>";

?>



</body>
</html>
