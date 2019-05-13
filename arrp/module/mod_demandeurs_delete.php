<?php
if(!in_array('admin',$_SESSION[PROJET_NAME]['droit'])){
    deconnexionDesBases();
    header('Location: index.php');
    exit;
}
$id_demandeur = isset($_POST['demandeur']) ? $_POST['demandeur'] : (isset($_GET['demandeur']) ? $_GET['demandeur'] : '');
$action = isset($_POST['action']) ? $_POST['action'] : (isset($_GET['action']) ? $_GET['action'] : '');
$from = isset($_POST['from']) ? $_POST['from'] : (isset($_GET['from']) ? $_GET['from'] : '201');

$ok = 1;
$msg = "";
if($action == 'DeleteDemandeur'){
	if(DeleteDemandeur($db,$id_demandeur)){
		$msg = 'Demandeur supprim&eacute;';
		$id_demandeur = '';
	}else{
		$msg = 'Erreur lors de la suppression du demandeur';
		$ok = 0;
	}
}

$BOUTTONS = array();
if($ok != 1){
	$BOUTTONS[] = array(
	                    'ACTION' => "javascript:window.location='index.php?P=".$from."&demandeur=".$id_demandeur."';",
	                    'TXT' => 'Retour',
	                    'IMG' => $GENERAL_URL.'/images/nav_left_green.png',
	                    'TITLE' => 'Retour',
	                   );
}

$page->afficheHeader();

if($ok==1){
	echo '<table><tr><td>' . $msg . '</td><td>&nbsp;&nbsp;&nbsp;</td><td><img src="./images/loading.gif"></td></tr></table>';
	echo '<script language="javascript">setTimeout("window.location=\'./index.php?P=' . $from . '&demandeur=' . $id_demandeur . '\'",1000);</script>';
}else{
	echo '<br/>' . $msg . '<br/>';
}

$page->afficheFooter();
?>