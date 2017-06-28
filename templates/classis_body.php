<h2> Osztály:<?php echo translateword($cla); ?>(<?php echo $cla; ?>)</h2>
<p><small><?php echo translateword($cla . ".d"); ?></small></p>

<div class="list-group">
    <?php for ($i = 0; $i < count($ordos); $i ++) : 
        $thislink = currGuidePath() . "?view=ordo&ordo=" . $ordos [$i];
        ?>
        <a class='list-group-item' style='font-size: 20px;' 
           href="<?php echo $thislink; ?>"><?php echo translateword($ordos [$i]); ?>(<?php echo $ordos [$i]; ?>)
        </a>
    <?php endfor; ?>
    
</div>
