


<html>
<head>
<title>Video Player</title>
<link rel=stylesheet type=text/css href="">
<style type="text/css">
.fadeSome {
	opacity: 0.30;
	filter: alpha(opacity = 30);
	-moz-opacity: 30%;
}

.fadeLots {
	opacity: 0.50;
	filter: alpha(opacity = 50);
	-moz-opacity: 0.5;
}

.fadeCompletely {
	opacity: 0.0;
	filter: alpha(opacity = 0);
	-moz-opacity: 0.0;
}

#silverlightControlHost {
	
}
</style>



<script type="text/javascript">
        function onSilverlightError(sender, args) {

            var appSource = "";
            if (sender != null && sender != 0) {
                appSource = sender.getHost().Source;
            }
            var errorType = args.ErrorType;
            var iErrorCode = args.ErrorCode;

            var errMsg = "Unhandled Error in Silverlight Application " + appSource + "\n";

            errMsg += "Code: " + iErrorCode + "    \n";
            errMsg += "Category: " + errorType + "       \n";
            errMsg += "Message: " + args.ErrorMessage + "     \n";

            if (errorType == "ParserError") {
                errMsg += "File: " + args.xamlFile + "     \n";
                errMsg += "Line: " + args.lineNumber + "     \n";
                errMsg += "Position: " + args.charPosition + "     \n";
            }
            else if (errorType == "RuntimeError") {
                if (args.lineNumber != 0) {
                    errMsg += "Line: " + args.lineNumber + "     \n";
                    errMsg += "Position: " + args.charPosition + "     \n";
                }
                errMsg += "MethodName: " + args.methodName + "     \n";
            }

            throw new Error(errMsg);
        }

        function highlightDownloadArea(fOn) {
            document.getElementById("overlay").className = (fOn) ? "fadeSome" : "fadeLots";            
        }

	function CloseWindow()
	{
	    window.close();
	}


   </script>


<link href="guide.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2">
</head>

<body>
	<table style="text-align: left;" align="left">
		<tr>
			<td>

				<p>Vide&oacute; - <?php echo $_GET["file"] ?> </p>
			</td>

		</tr>
		<tr>
			<td>

				<div id="silverlightControlHost">
					<object data="data:application/x-silverlight,"
						type="application/x-silverlight"
						style="height: 240px; width: 320px">
						<param name="source" value="MediaPlayerTemplate.xap" />
						<param name="onerror" value="onSilverlightError" />
						<param name="autoUpgrade" value="true" />
						<param name="minRuntimeVersion" value="4.0.50401.0" />
						<param name="enableHtmlAccess" value="true" />

						<param name="enableGPUAcceleration" value="true" />


						<!--  unused valid silverlight init parameters
            <param name="enableFrameRateCounter" value="bool" />
            <param name="enableRedrawRegions" value="bool" />
            <param name="maxFrameRate" value="int" />
            <param name="allowHtmlPopupWindow" value="bool"/>
            <param name="background" value="colorValue"/>
            <param name="splashScreenSource" value="uri"/>
            <param name="fullScreen" value="bool"/>
            <param name="onFullScreenChanged" value="functionname"/>
            <param name="onResize" value="functionname"/>
            <param name="onSourceDownloadComplete" value="functionname"/>
            <param name="onSourceDownloadProgressChanged" value="functionname"/>
            <param name="windowLess" value="bool"/>
             -->

						<div onMouseOver="highlightDownloadArea(true)"
							onMouseOut="highlightDownloadArea(false)">
							<img src=""
								style="position: relative; width: 100%; height: 100%; border-style: none;"
								onerror="this.style.display='none'" /> <img src="Preview.png"
								style="position: relative; width: 100%; height: 100%; border-style: none;"
								onerror="this.style.display='none'" />
							<div id="overlay" class="fadeLots"
								style="position: relative; width: 100%; height: 100%; border-style: none; background-color: white;" /></div>
							<table width="100%" height="100%" style="position: relative;">
								<tr>
									<td align="center" valign="middle"><img
										src="http://go2.microsoft.com/fwlink/?LinkId=108181"
										alt="Get Microsoft Silverlight"></td>
								</tr>
							</table>
							<a href="http://go2.microsoft.com/fwlink/?LinkID=149156"> <img
								src="" class="fadeCompletely"
								style="position: relative; width: 100%; height: 100%; border-style: none;"
								alt="Get Microsoft Silverlight" />
							</a>
						</div>
					</object>

					<iframe id='I1'
						style='visibility: hidden; height: 0; width: 0; border: 0px'
						name="I1"></iframe>
				</div>

			</td>


		</tr>
		<tr>
			<td>
				<p>
					<a
						href=<?php $vdir = "http://www.imager.fw.hu/maxor/media/"; echo $_GET["file"] . " "; ?>>
						Let&ouml;lt&eacute;s</a>
				</p>
				<p class="footer">
					A lej&aacute;tsz&oacute;hoz a Silverlight b�v&iacute;tm&eacute;ny
					sz&uuml;ks&eacute;ges.<br> 2010-2013. Elekes D&aacute;vid | Version
					0.91
				</p>
			</td>
		</tr>
	</table>

</body>

</html>

