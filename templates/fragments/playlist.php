<audio id="audio" preload="auto" tabindex="0" style="width: 100%;"
	controls>
	<source src="<?php echo $files[0];?>">
	Playlist doesn't work now.
</audio>

<ul id="playlist">
	<li class="active"><a href="<?php echo $files[0];?>">
			<?php echo $files[0];?>
			</a></li>
	
	<?php
	for($i = 1; $i < count ( $files ); $i ++) {
		?>
		<li><a href="<?php echo $files[$i];?>">
				<?php echo $files[$i]; ?>
			</a></li>
	<?php
	}
	
	?>
	
</ul>