<?php
if(!in_array('admin',$_SESSION[PROJET_NAME]['droit']) && !in_array('saisie',$_SESSION[PROJET_NAME]['droit'])){
    deconnexionDesBases();
    header('Location: index.php?P=2');
    exit;
}
executeReq($db,"alter session set nls_date_format='dd/mm/yyyy hh24:mi:ss'");
$id_demandeur = isset($_POST['id_demandeur']) ? $_POST['id_demandeur'] : (isset($_GET['id_demandeur']) ? $_GET['id_demandeur'] : '');
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$token = isset($_POST['token']) ? $_POST['token'] : (isset($_GET['token']) ? $_GET['token'] : '');

if(!isset($_SESSION[PROJET_NAME]['token'])){
    $_SESSION[PROJET_NAME]['token'] = generateToken(6);
}
if($token != $_SESSION[PROJET_NAME]['token']){
    deconnexionDesBases();
    header('Location: index.php');
    exit;
}

$nom 			= isset($_POST['nom']) ? $_POST['nom'] : '';
$prenom 		= isset($_POST['prenom']) ? $_POST['prenom'] : '';
$adresse 		= isset($_POST['adresse']) ? $_POST['adresse'] : '';
$adresse2 		= isset($_POST['adresse2']) ? $_POST['adresse2'] : '';
$cp 			= isset($_POST['cp']) ? $_POST['cp'] : '';
$ville 			= isset($_POST['ville']) ? $_POST['ville'] : '';
$tel1 			= isset($_POST['tel1']) ? $_POST['tel1'] : '';
$tel2 			= isset($_POST['tel2']) ? $_POST['tel2'] : '';
$observations 	= isset($_POST['observations']) ? $_POST['observations'] : '';
$user_maj = $_SESSION[PROJET_NAME]['login_ldap'];
$date_maj = date('d/m/Y H:i:s');
$_SESSION[PROJET_NAME]['token'] = generateToken(6);

$msg = '';
$Demandeur = new ArrpDemandeurs($db);
$Demandeur->select(array('id_demandeur'=>$id_demandeur));
$id_demandeur   = $Demandeur->getIdDemandeur();
$ok = 1;
if($action==''){
	$Demandeur->setNom($nom);
	$Demandeur->setPrenom($prenom);
	$Demandeur->setAdresse($adresse);
	$Demandeur->setAdresse2($adresse2);
	$Demandeur->setCp($cp);
	$Demandeur->setVille($ville);
	$Demandeur->setTel1($tel1);
	$Demandeur->setTel2($tel2);
	$Demandeur->setObservations($observations);
	if($id_demandeur==''){//insert
		$msg = 'Demandeur cr&eacute;&eacute;';
		$id_demandeur = getMaxId($db,'ARRP_DEMANDEURS','ID_DEMANDEUR');
		$Demandeur->setIdDemandeur($id_demandeur);
		$Demandeur->setUserSaisie($user_maj);
		$Demandeur->setDateSaisie($date_maj);
		$Demandeur->setUserModif($user_maj);
		$Demandeur->setDateModif($date_maj);
		$Demandeur->insert();
	}else{//Update
		$msg = 'Demandeur modifi&eacute;';
		$Demandeur->setUserModif($user_maj);
		$Demandeur->setDateModif($date_maj);
		$Demandeur->update();
	}

}elseif($action='delete'){
	$id_demandeur = '';
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
	echo '<table><tr><td>' . $msg . '</td><td>&nbsp;&nbsp;&nbsp;</td><td><img src="images/loading.gif"></td></tr></table>';
	$P = $action == '' ? '201' : '2';
	echo '<script language="javascript">setTimeout("window.location=\'./index.php?P=' . $P . '&demandeur=' . $id_demandeur . '\'",1000);</script>';
}else{
	echo '<br/>' . $msg . '<br/>';
}

$page->afficheFooter();
?>