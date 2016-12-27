<?php
$welcometitle = "Üdvözöllek a Madárhatározóban!";
$welcometext = "Szeretettel Üdvözöllek az internetes határozóban! Itt a saját általam készített képekkel, hangokkal ismerhetők meg a különféle madarak. Az adatbázis kereshető! Jö böngészést kívánunk!";
?>

<div class="visible-lg">
	<div class="jumbotron">
	
	<h1> <?php echo $welcometitle; ?> </h1>

		<div class="visible-lg"> 
	 <?php echo $welcometext; ?> 
	</div>
	</div>
</div>

<h2>Véletlen madarak</h2>

<div class="row">

<!-- TODO KIEMELNI -->
	<?php printrandomsps(); ?>

</div>