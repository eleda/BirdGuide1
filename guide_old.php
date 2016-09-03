<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Imager Guide</title>
</head>

<body>
<p>


<?php 



$version = "1.0.20120424 BETA";

$dl="hu";
$sp["regnum"]=$_GET["regnum"]; //7
$sp["phylum"]=$_GET["phylum"]; //6
$sp["subphylum"]=$_GET["subphylum"]; //5
$sp["classis"]=$_GET["classis"]; //5 
$sp["ordo"]=$_GET["ordo"]; //8
$sp["familia"]=$_GET["familia"]; //6
$sp["genus"]=$_GET["genus"]; //5
$sp["species"]=$_GET["species"]; //7
$sp["n"]="";
$sp["d"]="";
$sp["s"]="";
$sp["p"]="";
$sp["speciesfile"]="";
$resu=$_GET["search"];



//HU_n=Házi veréb
//HU_d=Kis madár
//HU_s=pasdom.mp3
//HU_p=pasdom.jpg

//Egy latin szó más nyelven belüli megfelelőjét adja végeredményül.
function tw($latinword,$tolang)
{
//echo "Ezt a szót kell lefordítani:" . $latinword . ":";
if ( ($latinword!="") && (is_string($latinword))){
$dir = opendir(getcwd());

$file = fopen($tolang.".dic", "r") or exit("A dictionary is required.");

$y=false;
while((!feof($file))&&($y==false))
{
$mc = fgets($file);
$mc = substr($mc,0,strlen($mc)-2);

if (strlen($mc)>=strlen($latinword)){
if (substr($mc, 0, strlen($latinword)+1)==($latinword . "="))
{$kin=substr($mc,strlen($latinword)+1);$y=true;}
}

}
fclose($file);

if ($y==false) {$kin="?";}
}
//echo "|Ez lett belőle:" . $kin;
return $kin;
}


function getinfo($fi,$tag)
{
$dir = opendir(getcwd());
$file = fopen($fi, "r") or exit("A file is required.");
$y=false;
while((!feof($file))&&($y==false))
{
$mc = fgets($file);
$mc = substr($mc,0,strlen($mc)-2);
if (substr($mc,0,strlen($tag)+1)==$tag . "=") {$kin=substr($mc,strlen($tag)+1);$y=true;}
}
fclose($file);
if ($y==false) {$kin="";}
return $kin;
}


function rtw($latinword,$tolang)
{
$t=tw($latinword,$tolang);
if ($t=="?") 
{return "";} 
else
{return "(" . $t . ")";}
}


function curURL() {
//átírva:
return "http://ednetwork.uw.hu/";
/*
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"];
 }
 return $pageURL;
*/
}

function curpurl(){

return curURL() . "korny/guide/guide.php";
//. $_SERVER["SCRIPT_NAME"];
}

//EZZEL LEHET LEKÉRNI, HOGY EGY FAJHOZ MELYIK FÁJL TARTOZIK.


function getspeciesfile(&$sp)
{

$y=false;

$dir = opendir(getcwd());

//List files in images directory
while ((($fil = readdir($dir))!== false)&&($y==false))
  {

  
if ((substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!=".."))
{
 // echo "<li>" . $fil . "</li>";
$file = fopen($fil, "r") or exit("Nincs ilyen faj.");

while(!feof($file))
{
$mc = fgets($file);
$mc = substr($mc,0,strlen($mc)-2);
//echo $mc;
if (substr($mc,0,7)=="regnum=") {$reg=substr($mc,7);}
if (substr($mc,0,7)=="phylum=") {$phy=substr($mc,7);}
if (substr($mc,0,10)=="subphylum=") {$sub=substr($mc,10);}
if (substr($mc,0,8)=="classis=") {$cla=substr($mc,8);}
if (substr($mc,0,5)=="ordo=") {$ord=substr($mc,5);}
if (substr($mc,0,8)=="familia=") {$fam=substr($mc,8);}
if (substr($mc,0,6)=="genus=") {$gen=substr($mc,6);}
if (substr($mc,0,8)=="species=") {$spe=substr($mc,8);}
if (substr($mc,0,8)=="picture=") {$pic=substr($mc,8);}
}
fclose($file);

if (($gen==$sp["genus"]) &&
($spe==$sp["species"]))
{

if ($sp["regnum"]=="") {$sp["regnum"]=$reg;}
if ($sp["phylum"]=="") {$sp["phylum"]=$phy;}
if ($sp["subphylum"]=="") {$sp["subphylum"]=$sub;}
if ($sp["classis"]==""){$sp["classis"]=$cla;}
if ($sp["ordo"]==""){$sp["ordo"]=$ord;}
if ($sp["familia"]==""){$sp["familia"]=$fam;}
if ($sp["genus"]==""){$sp["genus"]=$gen;}
if ($sp["species"]==""){$sp["species"]=$spe;}
if ($sp["picture"]==""){$sp["picture"]=$pic;}
$spec=$fil;
$y=true;

}

}
  
}
closedir($dir);
$sp["speciesfile"]=$spec;
return $spec;
}



//EZZEL LEHET LEKÉRDEZNI EGY FAJ RÉSZLETEIT.
function getspeciesdetails($fil, &$sp)
{

if ($fil!=""){
$file = fopen($fil, "r") or exit ("vége");
//if (feof($file)) {echo "End of file";} else {"Nincs vege";}

while(!feof($file))
{
$mc = fgets($file);
//echo $mc;
if (substr($mc,0,5)=="HU_n=") {$sp["n"]=substr($mc,5);}
if (substr($mc,0,5)=="HU_d=") {$sp["d"]=substr($mc,5);}
if (substr($mc,0,5)=="HU_s=") {$sp["s"]=substr($mc,5);}
if (substr($mc,0,5)=="HU_p=") {$sp["p"]=substr($mc,5);}
}
fclose($file);
}
else
{
echo "Ilyen faj nincs.";
}

}


function indexpage(){

echo "<h2>" . tw("_welcometitle","hu") . "</h2>";
echo "<p>";
echo tw("_welcometext","hu");
echo "</p>";

$dir = opendir(getcwd());
$regnums=array();
$phlyums=array();
$subphlyums=array();
$classises=array();

$shtphlyums=array();
$shtsubphlyums=array();
$shtclassises=array();


echo "<p>Királyságok:</p>";
echo "<ul>";

while (($fil = readdir($dir))!== false){

	if (strtolower(substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!="..") ){
	
		$file = fopen($fil, "r") or exit("Hiba.");
		
		while(!feof($file)){			
		$mc = fgets($file);
		$mc = substr($mc,0,strlen($mc)-2);
		$mc2= strtolower($mc);
		if (substr($mc2,0,7)=="regnum=") {$reg=substr($mc,7);}
		if (substr($mc2,0,7)=="phylum=") {$phy=substr($mc,7);}
		if (substr($mc2,0,10)=="subphylum=") {$sub=substr($mc,10);}
		if (substr($mc2,0,8)=="classis=") {$cla=substr($mc,8);}
	
		} 
		fclose($file);
		
	$rootphy= $reg . "|" . $phy;
	$rootsub= $rootphy . "|" . $sub;
	$rootcla= $rootsub . "|" . $cla;
	
//echo $rootcla . " ";
		
		$exi=false;
		for ($i=0; $i<count($regnums); $i++) {if ($regnums[$i]==$reg) {$exi=true;}}
		if ($exi==false) {array_push($regnums,$reg);}

		$exi=false;		
		for ($i=0; $i<count($phlyums); $i++) {if ($phlyums[$i]==$rootphy){$exi=1;}}
			if($exi==0){ array_push($phlyums,$rootphy);array_push($shtphlyums,$phy);}

$exi=false;
		for ($i=0; $i<count($subphlyums); $i++) {if ($subphlyums[$i]==$rootsub){$exi=1;}}
		if ($exi==0) {array_push($subphlyums,$rootsub);array_push($shtsubphlyums,$sub);}

$exi=false;
		for ($i=0; $i<count($classises); $i++) {if ($classises[$i]==$rootcla) {$exi=1;}}
		if ($exi==0) {array_push($classises,$rootcla);array_push($shtclassises,$cla);}

	} //if vége
} //while vége



//TESZT:KIIRATÁS

	//for ($i=0; $i<count($regnums); $i++) {echo $regnums[$i] . "</br>";}
	//for ($i=0; $i<count($phlyums); $i++) {echo $phlyums[$i] . "</br>";}
	//for ($i=0; $i<count($subphlyums); $i++) {echo $subphlyums[$i] . "</br>";}
	//for ($i=0; $i<count($classises); $i++) {echo $classises[$i] . "</br>";}
	

//KILISTÁZÁS

		for ($i=0; $i<count($regnums); $i++) {
		echo "<p>" . tw($regnums[$i],"hu") . " (". $regnums[$i] . ")</br>";

	for ($j=0; $j<count($phlyums); $j++) {
	
	if (substr($phlyums[$j],0,strlen($regnums[$i]))==$regnums[$i])
	{
		echo "-" . tw($shtphlyums[$j],"hu") . " (". $shtphlyums[$j]. ")</br>";
	//	echo	count($subphylums);
	for ($k=0; $k<count($subphlyums); $k++)
	 {
	 //echo substr($subphlyums[$k],0,strlen($regnums[$i]."|".$phylums[$j])) . "-";
	if (substr($subphlyums[$k],0,strlen($regnums[$i]."|".$phylums[$j]))==$regnums[$i]."|".$phylums[$j])
	{
		echo "--" . tw($shtsubphlyums[$j],"hu") . " (" . $shtsubphlyums[$j] . ")</br>";
		
			for ($l=0; $l<count($classises); $l++) {
			if (substr($classises[$l],0,strlen($regnums[$i]."|".$phylums[$j]."|".$classises[$k]))==$classises[$k])
	{
$thislink=curpurl() . "?view=classis&classis=" . $shtclassises[$i];

		echo "---<a href=". $thislink . ">" . tw($shtclassises[$k],"hu") . " (".$shtclassises[$k]. ")</a></p>";
	}
		}//for vége
		}
		}//for vége
			}
		}//for vége
	}//for vége
	

} //az egésznek vége

function searchresults($f)
{
if ($f!=""){
$dir = opendir(getcwd());
$fnd=0;

setcookie("sresult", $f, time()+3600);

	    echo "<p><a href=". curpurl() .">Főlap</a></p>";
		
echo "<p>Találatok:</p>";



echo "<ul>";

while (($fil = readdir($dir))!== false){

if ( strtolower(substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!="..") ){

$file = fopen($fil, "r") or exit("Hiba.");
while(!feof($file))
{
$mc = fgets($file);
$mc = substr($mc,0,strlen($mc)-2);
$mc2= strtolower($mc);

if (substr($mc2,0,7)=="regnum=") {$reg=substr($mc,7);}
if (substr($mc2,0,7)=="phylum=") {$phy=substr($mc,7);}
if (substr($mc2,0,10)=="subphylum=") {$sub=substr($mc,10);}
if (substr($mc2,0,8)=="classis=") {$cla=substr($mc,8);}
if (substr($mc2,0,5)=="ordo=") {$ord=substr($mc,5);}
if (substr($mc2,0,8)=="familia=") {$fam=substr($mc,8);}
if (substr($mc2,0,6)=="genus=") {$gen=substr($mc,6);}
if (substr($mc2,0,8)=="species=") {$spe=substr($mc,8);}
if (substr($mc2,0,5)=="hu_n=") {$hun=substr($mc,5);}
}
fclose($file);

$poshun = strpos(strtolower($hun),strtolower($f));
$posgen = strpos(strtolower($gen),strtolower($f));
$posspe = strpos(strtolower($spe),strtolower($f));
//echo "<p>" . $gen . " " . $spe . " " . $f . $posgen . $posspe . "</p>";

//echo $posgen;
//echo $posspe;


if (($posgen!==false)||($posspe!==false)||($poshun!==false))
{
echo "<li>" .
"<a href='" . curpurl() . "?view=species&genus=" . $gen . "&species=" . $spe . "'>" . 
"<b>" . $hun . "</b> ". $gen . " " . $spe ."</a></br>Rend: " . $ord . ",  Család: " . $fam . "</li>";
$fnd++;
}


}
}

echo "</ul>";
echo $fnd . " találat.";

if ($fnd==0)
{
echo "<p>Nincs találat.</p>";
}

}

}




//MEGJELENITI A FAJ ADATAIT.
function showspecies(&$sp)
{
getspeciesdetails(getspeciesfile($sp),$sp);



$thislinko=curpurl() . "?view=ordo&ordo=" . $sp["ordo"];
$thislinkc=curpurl() . "?view=classis&classis=" . $sp["classis"];

echo "<table width='100%' border='0'>";
echo "  <tr><td>";

    echo "<p>";
	    echo "<a href=". curpurl() .">Főlap</a>&gt;&gt;";
	echo "<a href=".$thislinkc.">".$sp["regnum"]."</a>&gt;&gt;";
	echo "<a href=".$thislinkc.">".$sp["phylum"]."</a>&gt;&gt;";
	echo "<a href=".$thislinkc.">".$sp["subphylum"]."</a>&gt;&gt;";
	echo "<a href=".$thislinkc.">".$sp["classis"]."</a>&gt;&gt;";
	echo "<a href=".$thislinko.">".$sp["ordo"]."</a>&gt;&gt;";
	echo "<a href=".$thislinko.">".$sp["familia"]."</a>";
	
	echo "</p>";

echo " <h2>" . $sp["n"] . "</h2>";
echo "      <h3>". $sp["genus"] . " " . $sp["species"] ."</h3>";

echo "  </tr>";
echo "  <tr>";
echo "    <td>";

echo "<table width='800'>";
echo "  <tr>";
echo "    <td width='463' valign='top'><p>".
$sp["d"]. "</td></p>";
$spc=substr($sp["speciesfile"],0,strlen($sp["speciesfile"])-4);
$speima=$spc."/" . $sp["picture"];
$imalink = curURL() . "/guide/picture.php?species=" . $spc;

echo "    <td width='321' align='right' valign='top'><div align='right'>";
echo "<a href=" . $imalink . " target='_blank'><img src=". 
$speima ." alt='picture of species' width='320' height='240' /></a></div></td>";
echo "  </tr>";
echo "  <tr>";
echo "    <td colspan='2'>";



//KILISTÁZZA A FAJ HANGJAIT.

//echo substr($sp["speciesfile"],0,strlen($sp["speciesfile"])-4);

$snds=array();
$specfold=substr($sp["speciesfile"],0,strlen($sp["speciesfile"])-4);
$pa=getcwd() . "/" . $specfold;

if (is_dir($pa)){
$dir = opendir($pa);
while (($fil = readdir($dir))!== false){
if ((substr($fil,strlen($fil)-4)==".mp3")&&($fil!=".")&&($fil!="..")){array_push($snds,$fil);}
}
}

if (count($snds)>0){
echo "<h4>Hangok</h4>";
echo "<ul>";

for ($i=0;$i<count($snds);$i++)
{
$pat = curURL() . "/guide/video.php?file=" . $specfold . "/" . $snds[$i];
echo "<li><a href=". $pat . 
" onClick=" . chr(34) . "return popup(this, 'Video')" . chr(34) . ">" .
$snds[$i] . "</a></li>";
}
echo "</ul>";
}



echo "</td>";
echo "  </tr>";
echo "</table>";

echo "</td>";
echo "  </tr>";
echo "</table>";

}


function listds($ty){
$arr=array();
$dir = opendir(getcwd());

//while ((($fil = readdir($dir))!== false)&&($y==false))
	while (($fil = readdir($dir))!== false){
	
	if ((substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!="..")){
	
	$file = fopen($fil, "r") or exit("Fájlhiba.");
		while(!feof($file))
		{
		$mc = fgets($file);
		$mc = substr($mc,0,strlen($mc)-2);
		if (substr($mc,0,strlen($ty)+1)==$ty . "=") {$kin=substr($mc,strlen($ty)+1);}
		}
	fclose($file);
		
	$exi=false;
	for ($i=0; $i<count($arr); $i++) {if ($arr[$i]==$kin) {$exi=true;}}
	if ($exi==false) {array_push($arr,$kin);}
	}
	 }
return $arr;
}



function showds($ty, $con){

switch ($ty) {
case "classis": 
//kingdom-suborder

$kin=listds("regnum");
$phy=listds("phylum");
$cla=listds("subphylum");
$ord=listds("classis");
$sub=listds("ordo");
$sub=listds("familia");

//1. megvizsgáljuk, hogy a család melyik országból..phylumból való.

$y=false;
$dir = opendir(getcwd());
while ((($fil = readdir($dir))!== false)&&($y==false))
{
if ((substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!=".."))
{
$file = fopen($fil, "r") or exit("Fájelhiba.");
while(!feof($file))
{
$mc = fgets($file);
$mc = substr($mc,0,strlen($mc)-2);
if (substr($mc,0,7)=="regnum=") {$reg=substr($mc,7);}
if (substr($mc,0,7)=="phylum=") {$phy=substr($mc,7);}
if (substr($mc,0,10)=="subphylum=") {$sub=substr($mc,10);}
if (substr($mc,0,8)=="classis=") {$cla=substr($mc,8);}

}
fclose($file);
if ($cla==$con) {$y=true;} 
}
}
closedir($dir);
//1.b kiírjuk:

echo "<p><a href=". curpurl() .">Főlap</a>";

echo " &gt;&gt; " . tw($reg,"hu") . " (" . $reg . 
") &gt;&gt; " . tw($phy,"hu") . " (" . $phy .  
") &gt;&gt; " .  tw($sub,"hu") . " (" . $sub .
 ")</p>";
echo "<h2> Osztály: "  . tw($cla,"hu") . " (" . $cla . ")</h2>";
echo "<p>" . getinfo("hu.dic",$cla.".d") . "</p>";

//Az összes ORDO-t kiírja:

$ordos=array();

$dir = opendir(getcwd());
while ((($fil = readdir($dir))!== false))
{
if ((substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!=".."))
{
$file = fopen($fil, "r") or exit("Fájelhiba.");
while(!feof($file))
{
$mc = fgets($file);
$mc = substr($mc,0,strlen($mc)-2);
if (substr($mc,0,8)=="classis=") {$cla=substr($mc,8);}
if (substr($mc,0,5)=="ordo=") {$ord=substr($mc,5);}
}

fclose($file);
if ($cla==$con) {$y=true;} 
$exi=false;
for ($i=0; $i<count($ordos); $i++) {if ($ordos[$i]==$ord) {$exi=true;}}
if ($exi==false) {array_push($ordos,$ord);}
}
}

for ($i=0; $i<count($ordos); $i++) {

$thislink=curpurl() . "?view=ordo&ordo=" . $ordos[$i];
//echo "nyelv:" . $dl;
echo "<p><a href=" . $thislink . ">" . tw($ordos[$i],"hu") . " (". $ordos[$i] . ")</a></p>";
}




break;
//////////////////////////////////////////////////
//Az ORDO-n belül az összes FAMILIA és FAJ kigyűjtése.
case "ordo": 


//Az összes létező család (FAMILIA) az ORDO-n (renden) belül

$familias=array();
$dir = opendir(getcwd());
while ((($fil = readdir($dir))!== false))
{
if ((substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!=".."))
{
$file = fopen($fil, "r") or exit("Fájelhiba.");
while(!feof($file))
{
$mc = fgets($file);
$mc = substr($mc,0,strlen($mc)-2);
if (substr($mc,0,7)=="regnum=") {$reg=substr($mc,7);}
if (substr($mc,0,7)=="phylum=") {$phy=substr($mc,7);}
if (substr($mc,0,10)=="subphylum=") {$sub=substr($mc,10);}

if (substr($mc,0,8)=="classis=") {$cla=substr($mc,8);}
if (substr($mc,0,5)=="ordo=") {$ord=substr($mc,5);}
if (substr($mc,0,8)=="familia=") {$fam=substr($mc,8);}
}

fclose($file);
if ($cla==$con) {$y=true;} 
$exi=false;

if ($ord==$con){
for ($i=0; $i<count($familias); $i++) {if ($familias[$i]==$fam) {$exi=true;}}
if ($exi==false) {array_push($familias,$fam);}
}

}
}

$thislinkc=curpurl() . "?view=classis&classis=" . $cla;

 echo "<p>";
    echo "<a href=". curpurl() .">Főlap</a>&gt;&gt;";
	echo "<a href=".$thislinkc.">".$reg."</a>&gt;&gt;";
	echo "<a href=".$thislinkc.">".$phy."</a>&gt;&gt;";
	echo "<a href=".$thislinkc.">".$sub."</a>&gt;&gt;";
	echo "<a href=".$thislinkc.">".$cla."</a>&gt;&gt;";
	echo $ord;
	echo "</p>";
	
	echo "<h2>Rend: ".   tw($con,"hu") . " (" . $con . ")</h2>";
	echo "<p>" . getinfo("hu.dic", $con.".d") . "</p>";

// Most kiiírja az össezs létező családot és azon belül a fajokat.

for ($i=0; $i<count($familias); $i++) {
echo "<h3>Család: "  . tw($familias[$i],"hu") . " (" .  $familias[$i] . ")</h3>";
echo "<p>" . getinfo("hu.dic", $familias[$i].".d") . "</p>";


//$spec=array();
//$specfi=array();
echo "<ul>";

$dir = opendir(getcwd());
while ((($fil = readdir($dir))!== false))
{
if ((substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!=".."))
{
$file = fopen($fil, "r") or exit("Fájelhiba.");
while(!feof($file))
{
$mc = fgets($file);
$mc = substr($mc,0,strlen($mc)-2);
if (substr($mc,0,8)=="familia=") {$fam=substr($mc,8);}
if (substr($mc,0,6)=="genus=") {$gen=substr($mc,6);}
if (substr($mc,0,8)=="species=") {$spe=substr($mc,8);}
}
fclose($file);
$exi=false;

if ($fam==$familias[$i]){
//array_push($spec,$genus . " " . $species);
//array_push($specfi,$fil);
$thislink=curpurl() . "?view=species&genus=" . $gen . "&species=".$spe;
$natname=getinfo($fil,"HU_n");
echo "<li><a href=" . $thislink . ">". $natname . " (" .$gen." ".$spe.")</a></li>";
}
}
}
echo "</ul>";
}


 break; 
//case "genus": echo "<h2>Fajok</h2>"; break;
}

}

echo "<table width=900 border=0 cellspacing=0 cellpadding=0>";
echo "  <tr>";
echo "    <td>";

echo "<h1>Internetes határozó</h1>";
echo "<form method='get' action='guide.php' id='sch' >";
echo "<input type='hidden' name='view' value='search' />";
echo "  <label>Keresés a határozóban:";
$val = $resu;

echo "  <input type='text' name='search' id='sch' class='sch' width='200px' value='". $val . "' />";
echo "  </label>";
echo "  <label>";
echo "  <input type='submit' name='go' id='go' value='Keresés'  class='go' width='100px' height='30px'/>";
echo "  </label>";
echo "</form>";

echo "</td>";
echo "  </tr>";
echo "  <tr>";
 echo "   <td>";
 
 switch($_GET["view"]){
case "species": showspecies($sp); break;
case "classis": showds("classis",$sp["classis"]); break;
case "ordo": showds("ordo",$sp["ordo"]); break;
case "search": searchresults($resu); break;
default:
indexpage();
}
 
 echo "</td>";
 echo " </tr>";
echo "  <tr>";
    echo "<td>";
	
echo "<p><hr></p>";
echo "<p class='footer'>". $version . " - 2011-2012.  Elekes Dávid | ";
echo "<a href='" . curURL() . "'>Vissza a főoldalra</a></p>";

echo "</td>";
echo "  </tr>";
echo "</table>";



?>


<a href="#" onmouseover="window.status='';return true"> </a></p>
</body>
</html>
