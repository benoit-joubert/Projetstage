<?php

$retour = array('retour' => false);

if (isset($_POST['url_carte']) == true
	&& isset($_POST['id_demande']) == true
	&& strlen($_POST['id_demande']) > 0)
{
	$req = "update ARRP_DEMANDES set URL_CARTE = '".$_POST['url_carte']."' where ID_DEMANDE = ".$_POST['id_demande'];
	$res = executeReq($db, $req);

	if (DB::isError($res))
	{
		$retour = array('retour' => false);
	}
	else
	{
		$retour = array('retour' => true);
	}
	
}

echo json_encode($retour);

?>