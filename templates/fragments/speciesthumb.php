<div class="col-sm-6 col-md-3">

	<a href=<?php echo $species_link; ?> class="thumbnail"
		style="width: 300px; height: 200px;"> <img class="img-rounded"
		style="height: 100%;" src="<?php echo $paintfile;?>"
		alt="Generic placeholder thumbnail">
	</a>

	<h2>
		<b>
					<?php echo $hun; ?>
      		</b>
	</h2>
			<?echo $gen . " " . $spe; ?>
			Rend: <a href="<?php echo $thislinko;?>"><?php echo translateword($ord); ?></a><br />
			Család: <?php echo translateword($fam); ?>
</div>
