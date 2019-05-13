<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="chrome=1">
<meta name="viewport" content="initial-scale=1.0, user-scalable=no, width=device-width">
<title>ARRP - Carte</title>

<link rel="stylesheet" href="css/bootstrap.css">
<link rel="stylesheet" href="css/ol.3.6.0.css" type="text/css">
<link rel="stylesheet" href="css/app.css" type="text/css">

<script src="javascript/mapshtml/jquery-1.11.2.min.js"></script>
<script type="text/javascript">
//$ = jQuery.noConflict( true );
$$ = $.noConflict();
</script>
<script src="javascript/mapshtml/bootstrap.3.3.4.min.js"></script>
<script src="javascript/mapshtml/ol.3.6.0.js"></script>
<script src="javascript/mapshtml/jquery.fullscreen-min.js"></script>
<script src="javascript/mapshtml/proj4js/dist/proj4.js"></script>
<script src="javascript/mapshtml/app_function.js"></script>

</head>
<body>
    <div id="map" class="map">
    	
    	<div id="layer-menu">
            <!--
            <a class="btn btn-primary" type="button" id="menu_print" download="carte_aix-en-provence.png">
                <span class="glyphicon glyphicon-print"></span>
            </a>
            -->

            <!--<button class="btn btn-primary" type="button" id="menu_fullscreen" onclick="javascript:menuFullscreen();return false;">-->
            
            <a class="btn btn-primary" href="maps_general.php?id=3851,3781&iframe=1" target="_blank">
                <span class="glyphicon glyphicon-fullscreen"></span>
            </a>
            

            <button class="btn btn-primary" type="button" id="menu_zoom_in" onclick="javascript:menuZoomIn();return false;">
                <span class="glyphicon glyphicon-zoom-in"></span>
            </button>
            
            <button class="btn btn-primary" type="button" id="menu_zoom_out" onclick="javascript:menuZoomOut();return false;">
                <span class="glyphicon glyphicon-zoom-out"></span>
            </button>
            
        </div>

    </div>

    <script>
    
    <?php 
	$x = '1893924.0158107';
	$y = '3151496.5861277';
	$zoom = '16';

    if (isset($_GET['center']) == true
    	&& strlen($_GET['center']) > 0)
    {
    	$center = explode(',', $_GET['center']);
    	if (is_array($center) == true
    		&& count($center) == 2)
    	{
	    	$x = $center[0];
	    	$y = $center[1];
    	}
    }

    echo 'var centerX = '.$x.';'."\n";
    echo 'var centerY = '.$y.';'."\n";

    if (isset($_GET['zoom']) == true
    	&& strlen($_GET['zoom']) > 0)
    {
    	$zoom = $_GET['zoom'];
    }

    echo 'var zoomDefault = '.$zoom.';'."\n";

    if (isset($GENERAL_URL) == true)
    {
    	echo 'var hostname = \''.$GENERAL_URL.'\';'."\n";
    }

    ?>

    var minX = 1893438.6964301;
    var minY = 3151446.7618862;
    var maxX = 1894409.3351912;
    var maxY = 3151546.4103693;


    
    </script>

    <script src="javascript/mapshtml/app.js"></script>
</body>
</html>