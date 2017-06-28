<h1><?php echo $details["hu_n"]; ?></h1>
<h2><?php echo $details["genus"] . ' ' . $details["species"]; ?></h2>

<div class="row">

    <div class="col-sm-6">

        <div class="panel panel-default">
            <div class="panel-body"><?php echo $details["hu_d"]; ?></div>
        </div>

        <?php if (count($snds) > 0) : ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Hangok <span class="badge"><?php echo count($snds); ?></span>
                </div>
                <div class="panel-body">
                    <?php
                    $files = $snds;
                    $pa = $specfold;
                    // Generate a playlist.
                    include ('templates/fragments/playlist.php');
                    ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <div class="col-sm-6">

        <?php
        $files = $imgs;
        $pa = $specfold;
        include ('templates/fragments/carousel.php');
        ?>        

    </div>
</div>