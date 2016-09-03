<!DOCTYPE html>
<html lang="hu">
<head>
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-2">
<meta charset="utf-8">
<title>Infra Bird Guide</title>
<meta name="generator" content="Bootply" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">
<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
<link href="css/extra.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">

</head>
<body>
 
<?php
include 'guide_fcnlib.php';
include 'guide_vars.php';

$val = "";
if (array_key_exists ( "view", $_GET )) {
	switch ($_GET ["view"]) {
		case "species" :
			$sp ["genus"] = $_GET ["genus"]; // 5
			$sp ["species"] = $_GET ["species"]; // 7
			$val = $_COOKIE ["sval"];
			break;
		case "classis" :
			$classis = $_GET ["classis"];
			$val = $_COOKIE ["sval"];
			break;
		case "ordo" :
			$ordo = $_GET ["ordo"];
			$val = $_COOKIE ["sval"];
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

$onerandspec = getrandomspecies ( 1 );
$onerandspec = $onerandspec [0];
$onerandspecdet = parsedatafile ( $onerandspec );

$onerandgenus = $onerandspecdet ["genus"];
$onerandspecies = $onerandspecdet ["species"];

$clalink = currGuidePath () . "?view=classis&classis=Aves";
$randspelink = currGuidePath () . "?view=species&genus=" . $onerandgenus . "&species=" . $onerandspecies;

?>
<div class="container">

		<div class="navbar navbar-default" role="navigation">

			<div class="navbar-header navbar-left">

				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>

				<a class="navbar-brand" rel="home"
					href="<?php echo currGuidePath();?>" title="Madárhatározó">Madárhatározó <strong>BETA!!</strong></a>

			</div>

			<ul class="nav navbar-nav collapse navbar-collapse"
				id="bs-example-navbar-collapse-1">
				<li><a href="<?php echo $clalink;?>">Osztályok</a></li>
				<li><a href="<?php echo $randspelink;?>">Random</a></li>
			</ul>

			<div class="col-sm-6 col-md-6 pull-left">

				<form method="get" class="navbar-form navbar-search"
					action='guide.php' id='sch'>
					<div class="input-group">
						<input type="text" class="form-control"
							placeholder="Madárfajok, családok" name="search" id="sch"
							width="100px" value="<?php echo $val; ?>" />
						<div class="input-group-btn">
							<button type='submit' class="btn btn-default" name="go" id="go">Keresés</button>
							<input type='hidden' name='view' value='search' />
						</div>
					</div>
				</form>

			</div>

		</div>

		<div class="container">

<?php

if (array_key_exists ( "view", $_GET )) {
	switch ($_GET ["view"]) {
		case "species" :
			showspecies ( $sp );
			break;
		case "classis" :
			showclassis ( $classis );
			break;
		case "ordo" :
			showordo ( $ordo );
			break;
		case "search" :
			showresults ( $resu );
			break;
		default :
			showindex ();
	}
} else {
	showindex ();
}

?>

</div>
		<p></p>


		<footer class="navbar navbar-default">
			<div class="container">
				<div class="navbar-text pull-left">
	<?php echo $version; ?> - 2011-2016.  Elekes Dávid | <a href="issues.html">Ismert hibák</a>
</div>
			</div>
		</footer>
	</div>

	<script
		src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/extra.js"></script>
</body>
</html>
