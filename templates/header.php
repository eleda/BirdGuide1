<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="utf-8">
<title>Infra Bird Guide</title>
<meta name="generator" content="Bootply" />
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1">
<link href="css/bootstrap.min.css" rel="stylesheet">

<!-- css -->
<link href="css/style.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css?family=Arima+Madurai|Open+Sans" rel="stylesheet">

</head>
<body>
 

<!-- routing -->
<div class="container">

<!-- HEADER -->
		<div class="navbar navbar-default" role="navigation">

			<div class="navbar-header navbar-left">

				<button type="button" class="navbar-toggle" data-toggle="collapse"
					data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span> <span
						class="icon-bar"></span> <span class="icon-bar"></span> <span
						class="icon-bar"></span>
				</button>

				<a class="navbar-brand" rel="home"
					href="<?php echo currGuidePath();?>" title="Madárhatározó">Madárhatározó					
				</a>

			</div>

			<ul class="nav navbar-nav collapse navbar-collapse"
				id="bs-example-navbar-collapse-1">
				<li><a href="<?php echo $clalink;?>">Osztályok</a></li>
				<li><a href="<?php echo $randspelink;?>">Random</a></li>
			</ul>

			<div class="col-sm-6 col-md-7 pull-left">

				<form method="get" class="navbar-form navbar-search"
					action='guide.php' id='sch'>
					<div class="input-group">
						<!-- TODO current search value -->
						<input type="text" class="form-control"
							placeholder="Madárfajok, családok" name="search" id="sch"
							width="100px" value="<?php echo $val; ?>" />
						<div class="input-group-btn">
							<button type='submit' class="btn btn-default" name="go" id="go">Keresés</button>
							<input type='hidden' name='view' value='search' />
						</div>
					</div>
				</form>

			</div>

		</div>

<!-- /HEADER -->
