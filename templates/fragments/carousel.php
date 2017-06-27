<div id="birdimge" class="carousel slide" data-ride="carousel">

	<!-- Indicators -->
	<ol class="carousel-indicators">

		<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		
		<?php
	for($i = 1; $i < count ( $files ); $i ++) {
		?>
		
			<li data-target="#myCarousel" data-slide-to="<?php echo $i;?>"></li>
		
		<?php
	}
	?>
			
		</ol>

	<!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">

		<div class="item active">
			<img src="<?php echo $files[0]; ?>"
				alt="<?php echo $files[0];?>">
		</div>
				
				<?php
	for($i = 1; $i < count ( $files ); $i ++) {
		?>
						<div class="item">
			<img src="<?php echo $files[$i]; ?>"
				alt="<?php echo $files[$i];?>">
		</div>
						<?php
	}
	?>
	
		</div>

	<!-- Left and right controls -->
	<a class="left carousel-control" href="#myCarousel" role="button"
		data-slide="prev"> <span class="sr-only">&#60;</span>
	</a> <a class="right carousel-control" href="#myCarousel" role="button"
		data-slide="next"> <span class="sr-only">&#62;</span>
	</a>
</div>