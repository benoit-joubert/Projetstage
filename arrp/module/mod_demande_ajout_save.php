<?php
if(!in_array('admin',$_SESSION[PROJET_NAME]['droit']) && !in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
    deconnexionDesBases();
    header('Location: index.php?P=3');
    exit;
}
executeReq($db,"alter session set nls_date_format='dd/mm/yyyy hh24:mi:ss'");
$id_demandeur = isset($_POST['id_demandeur']) ? $_POST['id_demandeur'] : (isset($_GET['id_demandeur']) ? $_GET['id_demandeur'] : '');
$id_demande = isset($_POST['id_demande']) ? $_POST['id_demande'] : (isset($_GET['id_demande']) ? $_GET['id_demande'] : '');
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$from = isset($_POST['from']) ? $_POST['from'] : (isset($_GET['from']) ? $_GET['from'] : '201');
$token = isset($_POST['token']) ? $_POST['token'] : (isset($_GET['token']) ? $_GET['token'] : '');
if(!isset($_SESSION[PROJET_NAME]['token'])){
    $_SESSION[PROJET_NAME]['token'] = generateToken(6);
}
if($token != $_SESSION[PROJET_NAME]['token']){
    deconnexionDesBases();
    header('Location: index.php');
    exit;
}
$code_com 			= isset($_POST['code_com']) ? $_POST['code_com'] : '';
$contact 			= isset($_POST['contact']) ? $_POST['contact'] : '';
$reference 			= isset($_POST['reference']) ? $_POST['reference'] : '';
$date_demande 		= isset($_POST['date_demande']) ? $_POST['date_demande'] : '';
$date_reponse 		= isset($_POST['date_reponse']) ? $_POST['date_reponse'] : '';
$statut_demande 	= isset($_POST['statut_demande']) ? $_POST['statut_demande'] : '';
$statut_aep 		= isset($_POST['statut_aep']) ? $_POST['statut_aep'] : '';
$statut_eu 			= isset($_POST['statut_eu']) ? $_POST['statut_eu'] : '';
$id_signataire 		= isset($_POST['id_signataire']) ? $_POST['id_signataire'] : '';
$id_attestant 		= isset($_POST['id_attestant']) ? $_POST['id_attestant'] : '';
$id_interlocuteur	= isset($_POST['id_interlocuteur']) ? $_POST['id_interlocuteur'] : '';
$observations 		= isset($_POST['observations']) ? $_POST['observations'] : '';
$user_maj = $_SESSION[PROJET_NAME]['login_ldap'];
$date_maj = date('d/m/Y H:i:s');
$_SESSION[PROJET_NAME]['token'] = generateToken(6);

$msg = '';
$Demande = new ArrpDemandes($db);
$Demande->select(array('id_demande'=>$id_demande));
if($id_demande != '' && $id_demande != $Demande->getIdDemande()){
	deconnexionDesBases();
    header('Location: index.php');
    exit;
}
$ok = 1;
if($action == ''){
	$Demande->setIdDemandeur($id_demandeur);
	$Demande->setContact($contact);
	$Demande->setReference($reference);
	$Demande->setDateDemande($date_demande);
	$Demande->setDateReponse($date_reponse);
	$Demande->setStatutDemande($statut_demande);
	$Demande->setStatutAep($statut_aep);
	$Demande->setStatutEu($statut_eu);
	$Demande->setIdSignataire($id_signataire);
	$Demande->setIdAttestant($id_attestant);
	$Demande->setIdInterlocuteur($id_interlocuteur);
	$Demande->setObservations($observations);
	if($id_demande==''){//insert
		$msg = 'Demande cr&eacute;&eacute;e';
		$id_demande = getMaxId($db,'ARRP_DEMANDES','ID_DEMANDE');
		$Demande->setIdDemande($id_demande);
		$Demande->setCodeCom($code_com);
		$Demande->setUserSaisie($user_maj);
		$Demande->setDateSaisie($date_maj);
		$Demande->setUserModif($user_maj);
		$Demande->setDateModif($date_maj);
		$curs = $Demande->insert();
	}else{//Update
		$msg = 'Demande modifi&eacute;e';
		$Demande->setUserModif($user_maj);
		$Demande->setDateModif($date_maj);
		$curs = $Demande->update();
	}
	if (DB::isError($curs)){
		$ok = 0;
		$msg = 'Erreur lors de la mise &acirc; jour des donn&eacute;e';
	}
}elseif($action=='delete'){
	$id_demande = '';
}
$BOUTTONS = array();
if($ok != 1){
	$BOUTTONS[] = array(
	                    'ACTION' => "javascript:window.location='index.php?P=201&demandeur=" . $id_demandeur . "';",
	                    'TXT' => 'Retour',
	                    'IMG' => $GENERAL_URL.'/images/nav_left_green.png',
	                    'TITLE' => 'Retour',
	                   );
}

$page->afficheHeader();

if($ok==1){
	echo '<table><tr><td>' . $msg . '</td><td>&nbsp;&nbsp;&nbsp;</td><td><img src="./images/loading.gif"></td></tr></table>';
	$P = $action == '' ? '301' : '201';
	echo '<script language="javascript">setTimeout("window.location=\'./index.php?P=' . $P . '&from=' . $from . '&demande=' . $id_demande . '\'",1000);</script>';
}else{
	echo '<br/>' . $msg . '<br/>';
}

$page->afficheFooter();
?>