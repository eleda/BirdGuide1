<?php
// adatgyujtes

$con = $classis;

$kin = collect_data_by_name("regnum");
$phy = collect_data_by_name("phylum");
$cla = collect_data_by_name("subphylum");
$ord = collect_data_by_name("classis");
$sub = collect_data_by_name("ordo");
$sub = collect_data_by_name("familia");

$y = false;
$specfiles = speciesfilelist();

$i = 0;
while ($i < count($specfiles) && !$y) {
    $details = parsedatafile($specfiles [$i]);

    $reg = $details ["regnum"];
    $phy = $details ["phylum"];
    $sub = $details ["subphylum"];
    $cla = $details ["classis"];

    if ($cla == $con) {
        $y = true;
    }

    $i ++;
}

$links = array();
$links ["classis"] = "";
$links ["ordo"] = "";

$ordos = array();

// TODO attenni valahova mashova
$SPE_DIR = 'data/spe';
$dir = opendir(getcwd() . '/' . $SPE_DIR);

while ((($fil = readdir($dir)) !== false)) {
    if ((substr($fil, strlen($fil) - 4) == ".spe") && ($fil != ".") && ($fil != "..")) {
        $file = fopen($SPE_DIR . '/' . $fil, "r") or exit("File error.");
        while (!feof($file)) {
            $mc = fgets($file);
            $mc = substr($mc, 0, strlen($mc) - 2);
            if (substr($mc, 0, 8) == "classis=") {
                $cla = substr($mc, 8);
            }
            if (substr($mc, 0, 5) == "ordo=") {
                $ord = substr($mc, 5);
            }
        }

        fclose($file);
        if ($cla == $con) {
            $y = true;
        }
        $exi = false;
        for ($i = 0; $i < count($ordos); $i ++) {
            if ($ordos [$i] == $ord) {
                $exi = true;
            }
        }
        if ($exi == false) {
            array_push($ordos, $ord);
        }
    }
}
?>


