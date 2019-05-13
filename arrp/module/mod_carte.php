<?php


require_once(realpath(dirname(__FILE__).'/../librairie/class_sigmapapi.php'));

$sigMapApi = new SigMapApi(array(
    'db' => $db,
    'retour_type' => 'json',
    //'retour' => 'echo',
));



// print_jv($layerPointJson);
//$layerPointAutorisationJson = $sigMapApi->getLayersPoint($paramLayerPointAutorisationJson);


$CSS_TO_LOAD[] = $GENERAL_URL.'/css/ol.3.6.0.css';
$CSS_TO_LOAD[] = $GENERAL_URL.'/css/app.css';

/*
$JAVASCRIPTS[] = $GENERAL_URL.'/js/openlayers/ol.3.6.0.js';
$JAVASCRIPTS[] = $GENERAL_URL.'/js/openlayers/jquery.fullscreen-min.js';
$JAVASCRIPTS[] = $GENERAL_URL.'/js/openlayers/proj4js/dist/proj4.js';
$JAVASCRIPTS[] = $GENERAL_URL.'/js/openlayers/app_function.js';
*/
if (isset($_GET['id_demande']) == true)
{
	$id_demande = $_GET['id_demande'];
}
else
{
	$id_demande = '';
}
$from = isset($_GET['from']) ? $_GET['from'] : 3;
$MapFrom = isset($_GET['MapFrom']) ? $_GET['MapFrom'] : 3;
$BOUTTONS = array();
$BOUTTONS[] = array(
                    'HREF' => 'index.php?P='.$MapFrom.'&from='.$from.'&demande=' . $id_demande,
                    'TXT' => 'Retour',
                    'IMG' => $page->getDesignUrl().'/images/toolbar/icon-32-cancel.png',
                    'TITLE' => 'Retour',
                   );

$page->afficheHeader();

echo '<input type="hidden" id="id_demande" value="'.$id_demande.'" />';

?>

<form>
<?php
	if(in_array('admin',$_SESSION[PROJET_NAME]['droit']) || in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
		if($id_demande != ''){
			echo '<button class="btn btn-primary" onclick="javascript:saveUrl();return false;">Enregistrer</button>';
		}
	}
?>
<span id="retour_save"></span>
<input type="text" name="frame_map" id="frame_map" value="" style="width:90%" />
</form>

<div id="map">
	<div id="map-point-select-detail" class="row">
        <div class="col-xs-12 panel panel-primary" id="map-point-select-detail-text">
        </div>
    </div>
</div>



<script type="text/javascript" src="<?php echo $GENERAL_URL .'/javascript/mapshtml/jquery-1.11.2.min.js'; ?>" ></script>
<script type="text/javascript">
$$ = jQuery.noConflict( true );
</script>
<script type="text/javascript" src="<?php echo $GENERAL_URL .'/javascript/mapshtml/ol.3.6.0.js'; ?>" ></script>
<script type="text/javascript" src="<?php echo $GENERAL_URL .'/javascript/mapshtml/app_function.js'; ?>" ></script>

<script>
    
<?php 
$x = '1894240.1585785684';
$y = '3151490.6211698186';
$zoom = '13';

if (isset($_GET['id_demande']) == true)
{
	$id_demande = $_GET['id_demande'];

	$req = 'select URL_CARTE from ARRP_DEMANDES where ID_DEMANDE = \'' . $id_demande . '\'';
	//echo $req;
	$res = executeReq($db, $req);
	list($url) = $res->fetchRow();
	if (strlen($url) > 0)
	{
		$tempo = explode('&', $url);

		foreach ($tempo as $key => $value)
		{
			$tempo2 = explode('=', $value);

			if (count($tempo2) == 2)
			{
				if ($tempo2[0] == 'center')
				{
					$coord = explode(',', $tempo2[1]);
					$x = $coord[0];
					$y = $coord[1];
				}
				elseif ($tempo2[0] == 'zoom')
				{
					$zoom = $tempo2[1];
				}

			}
		}
	}

	$req = 'select ID_PARC,LABX,LABY from ARRP_DEMANDES_PARCELLES where ID_DEMANDE = \'' . $id_demande . '\'';
	//echo $req;
	$res = executeReq($db, $req);
	$listeIdParcDemande = array();
	while (list($id_parc,$labx,$laby) = $res->fetchRow())
	{
		$listeIdParcDemande[] = $id_parc;
		if($url == '' && $labx != ''){
			$x = $labx;
			$y = $laby;
			$zoom = '17';
		}
	}
	$layerPointWktJson = $sigMapApi->getLayersGeometry(array('id_parc' => $listeIdParcDemande));
	$layerPointJson = $sigMapApi->getLayersPoint(array('not_id_parc' => $listeIdParcDemande));

	echo 'var layerPointWktJson = '.$layerPointWktJson.';'."\n";
	echo 'var layerPointJson = '.$layerPointJson.';'."\n";
}




echo 'var centerX = '.$x.';'."\n";
echo 'var centerY = '.$y.';'."\n";
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


<script type="text/javascript" src="<?php echo $GENERAL_URL .'/javascript/mapshtml/app.js'; ?>" ></script>

<?php

$page->afficheFooter();

?>
