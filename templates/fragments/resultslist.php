<?php if ($count > 0): ?>
    <p><?php echo $count; ?>  találat.</p>
    <div class="row">
        <?php
        foreach ($results as $rfile) {
            printspeciesthumb($rfile);
        }
        ?>
    </div>
<?php else: ?>
    <p>Nincs találat.</p>
<?php endif; ?>       