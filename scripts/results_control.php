<?php
$f = $resu;
?>

<?php

if ($f != "") {    
    // Print Search Results.
    $src = search($f);
    $results = $src ['results'];
    $count = $src ['count'];
    
    include ('templates/fragments/resultslist.php');
}
    
