<?php

//Get Current Root URL.
function curURL() {
//?t?rva:
//return "http://ednetwork.uw.hu/";
return "";
//return "http://localhost/";
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

//Get Current Guide URL.
function currGuidePath(){
//return "";
//return curURL() . "korny/guide/guide.php";
return $_SERVER["SCRIPT_NAME"];
}


//Parse line from a Data File
function parsedataline($lin)
{
	$pieces = explode("=", $lin);
	return $pieces;
}

//Parse all data from a formatted Data FIle
function parsedatafile($filename)
{
	
	$alldata = array();
	
	$file = fopen($filename, "r") or exit("A file ". $filename . " is required.");
	
	while(!feof($file))
	{
		$lin = fgets($file);
		
		$lin = substr($lin,0,strlen($lin)-2); //for enter key
		
		if(strrpos($lin, "=")!==FALSE)
		{
			$pieces = parsedataline($lin);
			$alldata[strtolower($pieces[0])] = $pieces[1];
		}
	}
	
	fclose($file);
	return $alldata;
}


//Find a value from a Data File
function findvalue($filename, $fnam, $side)
{

	$alldata = array();
	$fnam = strtolower($fnam);
	$side = strtolower($side); 

	$file = fopen($filename, "r") or exit("A file ". $filename . " is required.");
	
	$fnd = false;
	$data = '?';
	
	while(!feof($file) && !$fnd)
	{
		$lin = fgets($file);

		$lin = substr($lin,0,strlen($lin)-2); //for enter key
	
		if(strrpos($lin, "=")!==FALSE)
		{
			$pieces = parsedataline(strtolower($lin));
			
			if($side=='r')
			{
				$sid = $pieces[1];
				$osid = $pieces[0];
			}
			else
			{
				$sid = $pieces[0];
				$osid = $pieces[1];
			}
			
			if($sid == $fnam)
			{
				$fnd = true;
				$data = $osid;
			}
		}
	}

	fclose($file);
	return $data;
}


//Translate Latin word.
function translateword2($latinword, $unkown_display, $bracket_latin)
{
	
	$latinword = strtolower($latinword);
	
	$dl = 'hu';

	if($unkown_display)
	{
		$unkown_sign='?';
	}
	else
	{
		$unkown_sign='';
	}

	//echo "Ezt a sz?t kell leford?tani:" . $latinword . ":";
	if ( ($latinword!="") && (is_string($latinword))){
		$dir = opendir(getcwd());
		$file = fopen($dl. ".dic", "r") or exit("A dictionary is required.");

		$y=false;
		while((!feof($file))&&($y==false))
		{
			$mc = fgets($file);
			$mc = substr($mc,0,strlen($mc)-2);

			if (strlen($mc)>=strlen($latinword))
			{
				$leftside=strtolower(substr($mc, 0, strlen($latinword)+1));
				if ($leftside==($latinword . "="))
				{
					$found_word  = substr($mc,strlen($latinword)+1);

					if($bracket_latin)
					{
						$kin = '(' . $found_word . ')';
					}
					else
					{
						$kin = $found_word;
					}
						
					$y = true;
				}
			}

		}

		fclose($file);

		if ($y==false)
		{
			$kin=$unkown_sign;
		}

	}

	return $kin;
}

//Translate Latin word (defaults).
function translateword($latinword)
{
	return translateword2($latinword, true, false);
}


//List all specific data.
function listds($ty){
	$arr=array();
	
	$specfiles = speciesfilelist();

	foreach ($specfiles as $fil)
	{
		$details = parsedatafile($fil);
		array_push($arr, $details[$ty]);
	}

	return $arr;
}


//util.
function endswith($haystack, $needle) {
	// search forward starting from end minus needle length characters
	return $needle === "" || (($temp = strlen($haystack) - strlen($needle)) >= 0 && strpos($haystack, $needle, $temp) !== FALSE);
}


//File list.
function filelistbyext($ext, $dirr)
{

	$files=array();

	$dir = opendir(getcwd().'/'.$dirr);
	
	

	while (($fil = readdir($dir))!== false){

		if (endswith($fil, ".".$ext)&&($fil!=".")&&($fil!="..")){
			array_push($files, $fil);
		}
	}

	return $files;
	
}

//Specfillist
function speciesfilelist()
{
	return filelistbyext("spe","");
}

//Random generator
function randomGen($min, $max, $quantity) {
	$numbers = range($min, $max);
	shuffle($numbers);
	return array_slice($numbers, 0, $quantity);
}

//Randspecs.
function getrandomspecies($cnt)
{
	$sps = speciesfilelist();
	$rg = randomGen(0,count($sps)-1,$cnt);
	
	$rspecs = array();
	
	foreach ($rg as $rn)
	{
		array_push($rspecs, $sps[$rn]);
	}
	
	return $rspecs;
	
}


//MEGVÁLTOZOTT SZIGNATÚRA!!!!!!!!!!!!!!!!!!!!!!!
//Search a species file by data
function findspeciesbyname($fgenus, $fspecies)
{

	$speciesfilename="";
	
	$specfiles = speciesfilelist();
	
	$i=0;
	$found=false;
	
	while($i<count($specfiles)-1 && !$found)
	{
		
		$fil = $specfiles[$i];
		$spdata = parsedatafile($fil);
		$genus = $spdata["genus"];
		$species = $spdata["species"];
		
		if($genus==$fgenus && $species==$fspecies)
		{
			$speciesfilename=$fil;
			$found=true;			
		}
		
		
		$i++;		
	}
	
	return $speciesfilename;

}


function listallregnaitems()
{
	
	$items = array();

	$regnums=array();
	$phylums=array();
	$subphylums=array();
	$classises=array();
	
	$shtphylums=array();
	$shtsubphylums=array();
	$shtclassises=array();
	
	$files = speciesfilelist();
	
	foreach($files as $fname) {
		 
		$spdata = parsedatafile($fname);
	
		$reg = $spdata["regnum"];
		$phy = $spdata["phylum"];
		$sub = $spdata["subphylum"];
		$cla = $spdata["classis"];
	
		$rootphy= $reg . "|" . $phy;
		$rootsub= $rootphy . "|" . $sub;
		$rootcla= $rootsub . "|" . $cla;
	
		//insert all elements once
	
		$exi=false;
	
		for ($i=0; $i<count($regnums); $i++)
		{
		if ($regnums[$i]==$reg) {$exi=true;}
		}
	
		if ($exi==false)
		{
		array_push($regnums,$reg);
		}
	
		$exi=false;
	
		for ($i=0; $i<count($phylums); $i++)
		{
		if ($phylums[$i]==$rootphy)
		{
		$exi=1;
		}
		}
	
		if($exi==0){
		array_push($phylums,$rootphy);
		array_push($shtphylums,$phy);
		}
	
		$exi=false;
	
		for ($i=0; $i<count($subphylums); $i++)
		{
		if ($subphylums[$i]==$rootsub)
		{
		$exi=1;
		}
		}
	
		if ($exi==0)
		{
		array_push($subphylums,$rootsub);
		array_push($shtsubphylums,$sub);
		}
	
		$exi=false;
		for ($i=0; $i<count($classises); $i++)
		{
			if ($classises[$i]==$rootcla)
			{
				$exi=1;
			}
		}
	
		if ($exi==0)
		{
			array_push($classises,$rootcla);
			array_push($shtclassises,$cla);
		}
	
	}
	
	
	$items["regnum"] = $regnums;
	$items["phlyum"] = $phylums=array();
	$items["subphylum"] = $subphylums=array();
	$items["classis"] = $classises=array();
	
	$items["phlyum_path"] = $shtphylums=array();
	$items["subphylum_path"] = $shtsubphylums=array();
	$items["classis_path"] = $shtclassises=array();
	
}


//Get Search Data.
function search($f)
{
	
	$ret = array();
	$results_list=array();
	
	$files = speciesfilelist();
	$fnd=0;

	setcookie("sresult", $f, time()+3600);	
	
	foreach($files as $fname)
	{
		$rsp = parsedatafile($fname);
		
		$curr_species= $rsp['species'];

		$hun = $rsp["hu_n"];
		$gen = $rsp["genus"];
		$spe = $curr_species;
		
		$poshun = strpos(strtolower($hun),strtolower($f));
		$posgen = strpos(strtolower($gen),strtolower($f));
		$posspe = strpos(strtolower($spe),strtolower($f));

		if (($posgen!==false)||($posspe!==false)||($poshun!==false))
		{
			array_push($results_list, $fname);
			$fnd++;
		}
		
	}
		
	$ret['success']=1;
	$ret['count']=$fnd;

	$ret['results']=$results_list;
		
	return $ret;
}




//Generate a species image box.
function printspeciesthumb($rfile)
{
	$ritem = parsedatafile($rfile);
	
	$npref = substr($rfile,0,strlen($rfile)-4);
	$hun = $ritem['hu_n'];
	$gen = $ritem['genus'];
	$spe = $ritem['species'];
	$ord = $ritem['ordo'];
	$fam = $ritem['familia'];
	$picfile = $npref . '/' . $ritem['picture'];
	
	if(file_exists($picfile))
	{
		$paintfile = $picfile;
	}
	else 
	{
		$paintfile = "genbrd.png";
	}
	
	$species_link=currGuidePath() . "?view=species&genus=" . $gen . "&species=" . $spe;
	$thislinko=currGuidePath() . "?view=ordo&ordo=" . $ord;
	$thislinkc=currGuidePath() . "?view=classis&classis=" . $ritem["classis"];
	
	?>
	
   	  <div class="col-sm-6 col-md-3">
   	  
       <a href=<?php echo $species_link; ?> class="thumbnail" style="width: 300px; height: 200px;">
       <img class="img-rounded" style="height:100%;" src="<?php echo $paintfile;?>" 
       alt="Generic placeholder thumbnail">
       </a>
       
       		<h2>
       		<b>
					<?php echo $hun; ?>
      		</b>
      		</h2>
			<?echo $gen . " " . $spe; ?>
			Rend: <a href="<?php echo $thislinko;?>"><?php echo translateword($ord); ?></a><br/>
			Család: <?php echo translateword($fam); ?>
      </div>
			
	<?php
	
}

//Print Search Results.
function printresultslist($f)
{
	
	$src = search($f);
	$results = $src['results'];
	$count = $src['count'];
	
	?>
	
	<p><?php echo $count; ?>  találat.</p>
	
	<div class="row">
			
	<?php
	
	
	foreach($results as $rfile)
	{
		printspeciesthumb($rfile);	
	}				
	
	?>
	</div>
		
	<?php
	if ($count==0)
	{
		?>
		<p>Nincs találat.</p>
		<?php
	}

}

		
//Display Search Results Page.
function showresults($f){
	if ($f!=""){
		?>			
		<?php 
		printresultslist($f);
	}
}

//Generate image viewer
function printcarousel($files, $pa)
{
	?>
	<div id="birdimge" class="carousel slide" data-ride="carousel">
	
	<!-- Indicators -->
		<ol class="carousel-indicators">
		
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
		
		<?php 
		for($i=1; $i<count($files); $i++)
		{
		?>
		
			<li data-target="#myCarousel" data-slide-to="<?php echo $i;?>"></li>
		
		<?php 
		}
		?>
			
		</ol>
	
		<!-- Wrapper for slides -->
		<div class="carousel-inner" role="listbox">
		
				<div class="item active">
				<img src="<?php echo $pa."/".$files[0]; ?>" alt="<?php echo $files[0];?>">
				</div>
				
				<?php 
					for($i=1; $i<count($files); $i++)
					{
						?>
						<div class="item">
						<img src="<?php echo $pa."/".$files[$i]; ?>" alt="<?php echo $files[$i];?>">
						</div>
						<?php 											
					}	
					?>
	
		</div>
	
		<!-- Left and right controls -->
			<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
				<span class="sr-only">&#60;</span>
			</a>
			<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	    		<span class="sr-only">&#62;</span>
	 		</a>
	</div>
	<?php 
	
}

//Generate a playlist.
function printplaylist($files, $pa)
{
	?>
	<audio id="audio" preload="auto" tabindex="0" style="width:100%;" controls>
    <source src="<?php echo $pa.'/'. $files[0];?>">Playlist doesn't work now.</audio>
	
	<ul id="playlist">
		<li class="active">
			<a href="<?php echo $pa.'/'.$files[0];?>">
			<?php echo $files[0];?>
			</a>
		</li>
	
	<?php 
	for($i=1; $i<count($files); $i++)
	{
	?>
		<li>
			<a href="<?php echo $pa.'/'.$files[$i];?>">
				<?php echo $files[$i]; ?>
			</a>
		</li>
	<?php
	}
	
	?>
	
	</ul>

	<?php
}


//Display Species Page.
function showspecies(&$sp)
{
	//------------init--------------
	
	$speciesfile=findspeciesbyname($sp["genus"], $sp["species"]);
	
	$details = parsedatafile($speciesfile);
	 	
	$thislinko=currGuidePath() . "?view=ordo&ordo=" . $details["ordo"];
	$thislinkc=currGuidePath() . "?view=classis&classis=" . $details["classis"];
	
	$spc=substr($speciesfile,0,strlen($speciesfile)-4);
	$speima=$spc."/" . $details["picture"];
	$imalink = "picture.php?species=" . $spc;
	
	//sounds
	$snds=array();
	$specfold=substr($speciesfile,0,strlen($speciesfile)-4);
	$pa=getcwd() . "/" . $specfold;

	//???????????
	if (is_dir($pa))
	{
		$snds = filelistbyext("mp3", $spc."");
		$imgs = filelistbyext("jpg", $spc."");
	}
	
	$links = array();
	$links["classis"]=$thislinkc;
	$links["ordo"]=$thislinko;	
	
	
	//--------------print-----------------
	
	?>

		<h1><?php echo $details["hu_n"]; ?></h1>
		<h2><?php echo $details["genus"] . ' ' . $details["species"];?></h2>
	
	<div class="row">
	
		<div class="col-sm-6">
			
			<div class="panel panel-default">
				<div class="panel-body"><?php echo $details["hu_d"]; ?></div>
			</div>
			
			<?php
			if (count($snds)>0){
			?>
			
			<div class="panel panel-default">
				<div class="panel-heading">
						Hangok <span class="badge"><?php echo count($snds);?></span>
				</div>			
				<div class="panel-body">
				<?php
					printplaylist($snds, $specfold);
				?>
				</div>
			</div>
			<?php
			}
				?>
			
		</div>
		<div class="col-sm-6">
					
				<?php printcarousel($imgs, $specfold);?>
			
		</div>	
	</div>
	
	<?php 		

}

//Print classis
function showclassis($con)
{
		
		$kin=listds("regnum");
		$phy=listds("phylum");
		$cla=listds("subphylum");
		$ord=listds("classis");
		$sub=listds("ordo");
		$sub=listds("familia");

		$y=false;
		$specfiles = speciesfilelist();

		$i = 0;
		while($i<count($specfiles) && !$y)
		{
			$details = parsedatafile($specfiles[$i]);
			$reg=$details["regnum"];
			$phy=$details["phylum"];
			$sub=$details["subphylum"];
			$cla=$details["classis"];
			
			if ($cla==$con) 
			{
				$y=true;
			}
			
			$i++;
		}
		
		//1.b ki?rjuk:

		$links = array();
		$links["classis"]="";
		$links["ordo"]="";
	
		
		echo "<h2> Osztály: "  . translateword($cla) . " (" . $cla . ")</h2>";
		echo "<p><small>" . translateword($cla.".d") . "</small></p>";

		$ordos=array();

		$dir = opendir(getcwd());
		while ((($fil = readdir($dir))!== false))
		{
			if ((substr($fil,strlen($fil)-4)==".spe")&&($fil!=".")&&($fil!=".."))
			{
				$file = fopen($fil, "r") or exit("File error.");
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
		?>
		<div class="list-group">
		<?php
		for ($i=0; $i<count($ordos); $i++) 
		{
			$thislink=currGuidePath() . "?view=ordo&ordo=" . $ordos[$i];

			echo "<a class='list-group-item' style='font-size: 20px;' href=" . $thislink . ">" . translateword($ordos[$i]) . " (". $ordos[$i] . ")</a>";
		}
		?>
		</div>
		<?php 
}

//Generate random species
function printrandomsps()
{
	$randspec = getrandomspecies(4);
	
	foreach ($randspec as $onespec)
	{
		printspeciesthumb($onespec);
	}
	
}

//Show ordo
function showordo($con)
{
	
	//---------------------init----------------------
	
	$files = speciesfilelist();
	$familiae = array();
	$all_species = array();
	
	foreach ($files as $fname)
	{
		$sps = parsedatafile($fname);
		$ord = strtolower($sps["ordo"]);
		$fam = strtolower($sps["familia"]);
		
		if($ord==strtolower($con))
		{
			if(!in_array($fam, $familiae))
			{
				array_push($familiae, $fam);
			}
			array_push($all_species, $fname);
		}
	}

	$links = array();
	
	//---------------print-----------------------
	
	?>
	<h2>Rend: <?php echo translateword($con) . " (" . $con . ")"; ?></h2>
	
	<?php 
	
	$ordodesc = translateword($con.".d");
	
	if($ordodesc!="?")
	{
		?>
		<p><?php echo $ordodesc;?></p>
		<?php 
	}
	
	?>
	
	<?php
	
	//LIST ALL ORDO ITEMS
	foreach($familiae as $fam)
	{
		?>
		<h3>Család: <?php echo translateword($fam); ?> (<?php echo $fam;?>) </h3>
		
		<?php 
		 $famdesc = translateword($fam .".d");
		 
		 if($famdesc!="?")
		 {
		 	?>
		 	<p><?php echo $famdesc; ?></p>
		 	<?php
		 }
		 	
		?>
		
		<div class="row">
		
		<?php 			
		foreach($all_species as $spe)
		{
			
			$fami = strtolower(findvalue($spe, "familia", "l"));
			
			if($fami==$fam)
			{
				printspeciesthumb($spe);
					
			}
		
		}
		?>
		</div>
		
		<?php 
	}
	
}

//Display Index Page
function showindex(){
	
	?>
	
	<div class="visible-lg">
	<div class="jumbotron">
	
	<?php 
	
	$welcometitle = "Üdvözöllek a Madárhatározóban!";
	$welcometext = "Szeretettel üdnözöllek az internetes határozóban! Itt a saját általam készített képekkel, hangokkal ismerhetõk meg a különféle madarak. Az adatbázis kereshetõ! Jó böngészést kívánunk!";
	
	?>
	
	<h1> <?php echo $welcometitle; ?> </h1>
	
	<div class="visible-lg"> 
	 <?php echo $welcometext; ?> 
	</div>
	</div>
	</div>
	
	<h2>Véletlen madarak</h2>
	
	<div class="row">
	<?php printrandomsps(); ?>
	</div>
	
		
	<?php 

	
}


?>